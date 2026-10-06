<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_announcement_pages_render(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $announcement = Announcement::create([
            'title' => 'Pengumuman Render',
            'body' => 'Isi',
            'target' => 'all',
            'is_published' => false,
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)->get(route('admin.dashboard.announcement'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.announcement.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.announcement.edit', $announcement->id))->assertOk();
    }

    public function test_non_admin_cannot_access_announcements(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.dashboard.announcement'))
            ->assertForbidden();
    }

    public function test_admin_can_publish_and_notify_all_users(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $wali = User::factory()->create(['role' => 'user']);
        $khitan = User::factory()->create(['role' => 'khitan']);

        $response = $this->actingAs($admin)->post(route('admin.dashboard.announcement.store'), [
            'title' => 'Pengumuman Uji',
            'body' => 'Isi pengumuman uji',
            'target' => 'all',
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('admin.dashboard.announcement'));
        $this->assertDatabaseHas('announcements', ['title' => 'Pengumuman Uji', 'is_published' => true]);

        Notification::assertSentTo($wali, AnnouncementNotification::class);
        Notification::assertSentTo($khitan, AnnouncementNotification::class);
    }

    public function test_draft_announcement_is_not_sent(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)->post(route('admin.dashboard.announcement.store'), [
            'title' => 'Draf Uji',
            'body' => 'Isi draf',
            'target' => 'all',
        ]);

        $this->assertDatabaseHas('announcements', ['title' => 'Draf Uji', 'is_published' => false]);
        Notification::assertNothingSent();
    }

    public function test_targeted_announcement_only_notifies_matching_role(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $wali = User::factory()->create(['role' => 'user']);
        $khitan = User::factory()->create(['role' => 'khitan']);

        $this->actingAs($admin)->post(route('admin.dashboard.announcement.store'), [
            'title' => 'Khusus Wali',
            'body' => 'Isi',
            'target' => 'user',
            'is_published' => 1,
        ]);

        Notification::assertSentTo($wali, AnnouncementNotification::class);
        Notification::assertNotSentTo($khitan, AnnouncementNotification::class);
    }

    public function test_admin_can_publish_existing_draft(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $wali = User::factory()->create(['role' => 'user']);

        $announcement = \App\Models\Announcement::create([
            'title' => 'Draf Lama',
            'body' => 'Isi draf lama',
            'target' => 'all',
            'is_published' => false,
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.dashboard.announcement.publish'), ['id' => $announcement->id])
            ->assertRedirect();

        $this->assertTrue($announcement->fresh()->is_published);
        Notification::assertSentTo($wali, AnnouncementNotification::class);
    }
}
