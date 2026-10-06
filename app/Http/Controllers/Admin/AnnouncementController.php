<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Announcement::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $viewData = [
            'title' => 'Pengumuman',
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'search' => $search,
        ];

        return view('admin.announcement.index', $viewData);
    }

    public function create()
    {
        $viewData = [
            'title' => 'Buat Pengumuman',
            'targets' => Announcement::TARGETS,
        ];

        return view('admin.announcement.create', $viewData);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target' => 'required|in:' . implode(',', array_keys(Announcement::TARGETS)),
            'is_published' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $announcement = Announcement::create([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'target' => $validated['target'],
                'is_published' => false,
                'created_by' => $request->user()->id,
            ]);

            DB::commit();

            ActivityLogger::log('admin.announcement.created', 'Membuat pengumuman: ' . $announcement->title, $announcement);
            event(new AdminDataChanged('announcement', 'created', $announcement->id));

            if ($request->boolean('is_published')) {
                $this->publishAnnouncement($announcement);
                return redirect()->route('admin.dashboard.announcement')->with('success', 'Pengumuman berhasil dibuat dan dikirim.');
            }

            return redirect()->route('admin.dashboard.announcement')->with('success', 'Pengumuman berhasil disimpan sebagai draf.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal membuat pengumuman: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $viewData = [
            'title' => 'Edit Pengumuman',
            'data' => $announcement,
            'targets' => Announcement::TARGETS,
        ];

        return view('admin.announcement.edit', $viewData);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:announcements,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target' => 'required|in:' . implode(',', array_keys(Announcement::TARGETS)),
            'is_published' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $announcement = Announcement::findOrFail($validated['id']);
            $wasPublished = $announcement->is_published;

            $announcement->update([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'target' => $validated['target'],
            ]);

            DB::commit();

            ActivityLogger::log('admin.announcement.updated', 'Mengubah pengumuman: ' . $announcement->title, $announcement);
            event(new AdminDataChanged('announcement', 'updated', $announcement->id));

            if ($request->boolean('is_published') && ! $wasPublished) {
                $this->publishAnnouncement($announcement);
                return redirect()->route('admin.dashboard.announcement')->with('success', 'Pengumuman berhasil diperbarui dan dikirim.');
            }

            return redirect()->route('admin.dashboard.announcement')->with('success', 'Pengumuman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengumuman: ' . $e->getMessage());
        }
    }

    public function publish(Request $request)
    {
        $announcement = Announcement::findOrFail($request->id);

        if ($announcement->is_published) {
            return redirect()->back()->with('error', 'Pengumuman ini sudah pernah dikirim.');
        }

        $this->publishAnnouncement($announcement);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim ke pengguna.');
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $announcement = Announcement::findOrFail($request->id);
            $announcementId = $announcement->id;
            $announcementTitle = $announcement->title;
            $announcement->delete();

            DB::commit();

            ActivityLogger::log('admin.announcement.deleted', 'Menghapus pengumuman: ' . $announcementTitle);
            event(new AdminDataChanged('announcement', 'deleted', $announcementId));

            return redirect()->route('admin.dashboard.announcement')->with('success', 'Pengumuman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Tandai terbit lalu kirim notifikasi in-app + email ke pengguna sasaran.
     */
    private function publishAnnouncement(Announcement $announcement): void
    {
        $announcement->update([
            'is_published' => true,
            'published_at' => $announcement->published_at ?? now(),
        ]);

        $query = User::query();

        if ($announcement->target !== 'all') {
            $query->where('role', $announcement->target);
        }

        $query->chunkById(200, function ($users) use ($announcement) {
            foreach ($users as $user) {
                try {
                    $user->notify(new AnnouncementNotification($announcement));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });

        ActivityLogger::log('admin.announcement.published', 'Mengirim pengumuman: ' . $announcement->title, $announcement);
        event(new AdminDataChanged('announcement', 'published', $announcement->id));
    }
}
