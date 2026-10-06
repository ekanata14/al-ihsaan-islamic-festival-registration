<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Models\ContactPerson;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactPersonController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ContactPerson::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $viewData = [
            'title' => 'Kontak Person',
            'datas' => $query->ordered()->paginate(10)->appends(['search' => $search]),
            'search' => $search,
        ];

        return view('admin.landing.contact.index', $viewData);
    }

    public function create()
    {
        $viewData = [
            'title' => 'Tambah Kontak Person',
        ];

        return view('admin.landing.contact.create', $viewData);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'whatsapp' => 'required|string|max:32',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->boolean('is_active', true);
            $contact = ContactPerson::create($validated);

            DB::commit();

            ActivityLogger::log('admin.landing.contact.created', 'Menambah kontak person: ' . $contact->name, $contact);
            event(new AdminDataChanged('contact-person', 'created', $contact->id));

            return redirect()->route('admin.dashboard.landing.contact')->with('success', 'Kontak person berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambah kontak person: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $contact = ContactPerson::findOrFail($id);

        $viewData = [
            'title' => 'Edit Kontak Person',
            'data' => $contact,
        ];

        return view('admin.landing.contact.edit', $viewData);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:contact_persons,id',
            'name' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'whatsapp' => 'required|string|max:32',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $contact = ContactPerson::findOrFail($validated['id']);
            $validated['is_active'] = $request->boolean('is_active', true);
            $contact->update($validated);

            DB::commit();

            ActivityLogger::log('admin.landing.contact.updated', 'Mengubah kontak person: ' . $contact->name, $contact);
            event(new AdminDataChanged('contact-person', 'updated', $contact->id));

            return redirect()->route('admin.dashboard.landing.contact')->with('success', 'Kontak person berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kontak person: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $contact = ContactPerson::findOrFail($request->id);
            $contactId = $contact->id;
            $contactName = $contact->name;
            $contact->delete();

            DB::commit();

            ActivityLogger::log('admin.landing.contact.deleted', 'Menghapus kontak person: ' . $contactName);
            event(new AdminDataChanged('contact-person', 'deleted', $contactId));

            return redirect()->route('admin.dashboard.landing.contact')->with('success', 'Kontak person berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus kontak person: ' . $e->getMessage());
        }
    }
}
