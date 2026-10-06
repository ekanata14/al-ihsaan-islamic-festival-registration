<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private function createNotification(User $user, array $data = []): void
    {
        $user->notifications()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\AnnouncementNotification',
            'data' => $data + [
                'title' => 'Judul Uji',
                'message' => 'Pesan notifikasi uji',
                'url' => '/user-dashboard',
            ],
            'read_at' => null,
        ]);
    }

    public function test_notification_page_lists_notifications(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->createNotification($user);

        $this->actingAs($user)
            ->get(route('notifications.index'))
            ->assertOk()
            ->assertSee('Pesan notifikasi uji');
    }

    public function test_unread_count_endpoint(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->createNotification($user);
        $this->createNotification($user);

        $this->actingAs($user)
            ->getJson(route('notifications.unread-count'))
            ->assertOk()
            ->assertJson(['count' => 2]);
    }

    public function test_notification_can_be_marked_as_read(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->createNotification($user);

        $notification = $user->notifications()->first();

        $this->actingAs($user)
            ->post(route('notifications.read', $notification->id))
            ->assertRedirect('/user-dashboard');

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_all_notifications_can_be_marked_as_read(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->createNotification($user);
        $this->createNotification($user);

        $this->actingAs($user)
            ->post(route('notifications.read-all'))
            ->assertRedirect(route('notifications.index'));

        $this->assertSame(0, $user->unreadNotifications()->count());
    }

    public function test_guest_cannot_access_notifications(): void
    {
        $this->get(route('notifications.index'))->assertRedirect(route('login'));
    }
}
