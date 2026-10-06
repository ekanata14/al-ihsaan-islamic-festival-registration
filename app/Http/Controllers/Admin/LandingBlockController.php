<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Models\LandingBlock;
use App\Support\ActivityLogger;
use App\Support\LandingBlockTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LandingBlockController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Konten Landing Page',
            'blocks' => LandingBlock::orderBy('sort_order')->orderBy('id')->get(),
            'types' => LandingBlockTypes::all(),
        ];

        return view('admin.landing.content.index', $viewData);
    }

    public function create(Request $request)
    {
        $type = $request->input('type');
        abort_unless(LandingBlockTypes::exists($type), 404);

        $viewData = [
            'title' => 'Tambah Blok: ' . LandingBlockTypes::label($type),
            'type' => $type,
            'schema' => LandingBlockTypes::get($type),
            'data' => null,
            'content' => LandingBlockTypes::defaultContent($type),
        ];

        return view('admin.landing.content.create', $viewData);
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        abort_unless(LandingBlockTypes::exists($type), 404);

        $request->validate(array_merge([
            'name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ], LandingBlockTypes::contentRules($type), LandingBlockTypes::fileRules($type)));

        try {
            DB::beginTransaction();

            $content = array_merge(
                LandingBlockTypes::defaultContent($type),
                $this->sanitizeContent($type, $request)
            );
            $content = $this->handleUploads($type, $request, $content, null);

            $block = LandingBlock::create([
                'type' => $type,
                'name' => $request->input('name') ?: LandingBlockTypes::label($type),
                'content' => $content,
                'is_active' => $request->boolean('is_active', true),
                'sort_order' => (int) LandingBlock::max('sort_order') + 1,
            ]);

            DB::commit();

            ActivityLogger::log('admin.landing.block.created', 'Menambah blok landing: ' . $block->name, $block);
            event(new AdminDataChanged('landing', 'created', $block->id));

            return redirect()->route('admin.dashboard.landing.content')->with('success', 'Blok berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambah blok: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $block = LandingBlock::findOrFail($id);

        $viewData = [
            'title' => 'Edit Blok: ' . LandingBlockTypes::label($block->type),
            'type' => $block->type,
            'schema' => LandingBlockTypes::get($block->type),
            'data' => $block,
            'content' => array_merge(LandingBlockTypes::defaultContent($block->type), $block->content ?? []),
        ];

        return view('admin.landing.content.edit', $viewData);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:landing_blocks,id',
            'name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $block = LandingBlock::findOrFail($validated['id']);
        $type = $block->type;

        $request->validate(array_merge(
            LandingBlockTypes::contentRules($type),
            LandingBlockTypes::fileRules($type)
        ));

        try {
            DB::beginTransaction();

            $content = array_merge(
                LandingBlockTypes::defaultContent($type),
                $this->sanitizeContent($type, $request)
            );
            $content = $this->handleUploads($type, $request, $content, $block);

            $block->update([
                'name' => $request->input('name') ?: LandingBlockTypes::label($type),
                'content' => $content,
                'is_active' => $request->boolean('is_active', true),
            ]);

            DB::commit();

            ActivityLogger::log('admin.landing.block.updated', 'Mengubah blok landing: ' . $block->name, $block);
            event(new AdminDataChanged('landing', 'updated', $block->id));

            return redirect()->route('admin.dashboard.landing.content')->with('success', 'Blok berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui blok: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $block = LandingBlock::findOrFail($request->id);
            $blockId = $block->id;
            $blockName = $block->name;

            foreach (LandingBlockTypes::fields($block->type) as $field) {
                if (LandingBlockTypes::isFileField($field)) {
                    $this->deleteStoredImage($block->content[$field['name']] ?? null);
                }
            }

            $block->delete();

            DB::commit();

            ActivityLogger::log('admin.landing.block.deleted', 'Menghapus blok landing: ' . $blockName);
            event(new AdminDataChanged('landing', 'deleted', $blockId));

            return redirect()->route('admin.dashboard.landing.content')->with('success', 'Blok berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus blok: ' . $e->getMessage());
        }
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:landing_blocks,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['order'] as $index => $id) {
                LandingBlock::where('id', $id)->update(['sort_order' => $index + 1]);
            }

            DB::commit();

            LandingBlock::flushCache();
            event(new AdminDataChanged('landing', 'reordered', null));

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function toggle(Request $request)
    {
        $block = LandingBlock::findOrFail($request->id);
        $block->is_active = ! $block->is_active;
        $block->save();

        ActivityLogger::log('admin.landing.block.toggled', 'Mengubah status blok: ' . $block->name, $block);
        event(new AdminDataChanged('landing', 'updated', $block->id));

        return redirect()->back()->with('success', 'Status blok berhasil diperbarui.');
    }

    /**
     * Ambil hanya field sesuai skema tipe, buang baris repeater yang kosong.
     */
    private function sanitizeContent(string $type, Request $request): array
    {
        $input = $request->input('content', []);

        if (! is_array($input)) {
            return [];
        }

        $clean = [];

        foreach (LandingBlockTypes::fields($type) as $field) {
            $name = $field['name'];

            if ($field['type'] === 'repeater') {
                $rows = $input[$name] ?? [];
                $items = [];

                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        if (! is_array($row)) {
                            continue;
                        }

                        $item = [];
                        $hasValue = false;

                        foreach ($field['subfields'] ?? [] as $sub) {
                            $value = $row[$sub['name']] ?? null;
                            $value = is_string($value) ? trim($value) : $value;
                            $item[$sub['name']] = $value;

                            if ($value !== null && $value !== '') {
                                $hasValue = true;
                            }
                        }

                        if ($hasValue) {
                            $items[] = $item;
                        }
                    }
                }

                $clean[$name] = array_values($items);
            } elseif ($field['type'] === 'checkbox') {
                $clean[$name] = ! empty($input[$name]) ? 1 : 0;
            } else {
                $value = $input[$name] ?? null;
                $clean[$name] = is_string($value) ? trim($value) : $value;
            }
        }

        return $clean;
    }

    private function handleUploads(string $type, Request $request, array $content, ?LandingBlock $existing): array
    {
        foreach (LandingBlockTypes::fields($type) as $field) {
            if (! LandingBlockTypes::isFileField($field)) {
                continue;
            }

            $name = $field['name'];

            if ($request->hasFile('file.' . $name)) {
                if ($existing) {
                    $this->deleteStoredImage($existing->content[$name] ?? null);
                }

                $path = $request->file('file.' . $name)->store('landing', 'public');
                $content[$name] = 'storage/' . $path;
            }
        }

        return $content;
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
