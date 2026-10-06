<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Models\LandingSetting;
use App\Support\ActivityLogger;
use App\Support\LandingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LandingSettingController extends Controller
{
    private const TEXT_KEYS = [
        'site_name',
        'meta_title',
        'meta_description',
        'primary_color',
        'accent_color',
        'event_date',
        'footer_about',
        'footer_address',
        'footer_email',
        'footer_phone',
        'footer_copyright',
    ];

    private const REPEATER_KEYS = [
        'navbar_links' => ['label', 'url'],
        'footer_quick_links' => ['label', 'url'],
        'footer_socials' => ['label', 'url'],
    ];

    private const IMAGE_KEYS = ['logo', 'favicon'];

    public function edit()
    {
        $viewData = [
            'title' => 'Pengaturan Landing Page',
            'settings' => LandingSetting::allCached(),
        ];

        return view('admin.landing.settings.edit', $viewData);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'primary_color' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'event_date' => 'nullable|string|max:32',
            'footer_email' => 'nullable|email|max:255',
            'file.logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'file.favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'navbar_links' => 'nullable|array',
            'footer_quick_links' => 'nullable|array',
            'footer_socials' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            foreach (self::TEXT_KEYS as $key) {
                LandingSetting::put($key, $request->input($key));
            }

            LandingSetting::put('footer_show', $request->boolean('footer_show') ? '1' : '0');

            foreach (self::REPEATER_KEYS as $key => $subKeys) {
                LandingSetting::put($key, $this->sanitizeRepeater($request->input($key, []), $subKeys));
            }

            foreach (self::IMAGE_KEYS as $key) {
                if ($request->hasFile('file.' . $key)) {
                    $this->deleteStoredImage(LandingSetting::get($key));
                    $path = $request->file('file.' . $key)->store('landing/branding', 'public');
                    LandingSetting::put($key, 'storage/' . $path);
                }
            }

            DB::commit();

            ActivityLogger::log('admin.landing.settings.updated', 'Memperbarui pengaturan landing page');
            event(new AdminDataChanged('landing', 'updated', null));

            return redirect()->route('admin.dashboard.landing.settings')->with('success', 'Pengaturan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    private function sanitizeRepeater($rows, array $keys): array
    {
        if (! is_array($rows)) {
            return [];
        }

        $items = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $item = [];
            $hasValue = false;

            foreach ($keys as $key) {
                $value = isset($row[$key]) && is_string($row[$key]) ? trim($row[$key]) : ($row[$key] ?? null);
                $item[$key] = $value;

                if ($value !== null && $value !== '') {
                    $hasValue = true;
                }
            }

            if ($hasValue) {
                $items[] = $item;
            }
        }

        return array_values($items);
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
