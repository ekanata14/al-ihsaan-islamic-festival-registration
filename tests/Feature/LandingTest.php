<?php

namespace Tests\Feature;

use App\Models\ContactPerson;
use App\Models\LandingBlock;
use App\Models\LandingSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_active_blocks(): void
    {
        LandingSetting::create(['key' => 'site_name', 'value' => 'Festival Uji']);
        LandingSetting::create(['key' => 'footer_show', 'value' => '1']);

        LandingBlock::create([
            'type' => 'rich_text',
            'name' => 'Tentang',
            'content' => ['title' => 'Tentang Kami', 'body' => '<p>Konten uji tampil</p>', 'background' => 'white'],
            'sort_order' => 1,
            'is_active' => true,
        ]);

        LandingBlock::create([
            'type' => 'rich_text',
            'name' => 'Tersembunyi',
            'content' => ['title' => 'Rahasia', 'body' => 'tidak-tampil', 'background' => 'white'],
            'sort_order' => 2,
            'is_active' => false,
        ]);

        LandingBlock::create([
            'type' => 'contact',
            'name' => 'Kontak',
            'content' => ['title' => 'Hubungi Kami', 'subtitle' => '', 'groups' => []],
            'sort_order' => 3,
            'is_active' => true,
        ]);

        ContactPerson::create(['name' => 'Narahubung Uji', 'whatsapp' => '+628111', 'sort_order' => 1, 'is_active' => true]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Tentang Kami');
        $response->assertSee('Konten uji tampil', false);
        $response->assertDontSee('tidak-tampil');
        $response->assertSee('Narahubung Uji');
    }

    public function test_guest_is_redirected_from_landing_admin(): void
    {
        $this->get(route('admin.dashboard.landing.content'))->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_landing_admin(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.dashboard.landing.content'))
            ->assertForbidden();
    }

    public function test_admin_can_store_a_landing_block(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.dashboard.landing.content.store'), [
            'type' => 'rich_text',
            'name' => 'Blok Baru',
            'is_active' => 1,
            'content' => [
                'title' => 'Judul Baru',
                'body' => '<p>Isi baru</p>',
                'background' => 'gray',
            ],
        ]);

        $response->assertRedirect(route('admin.dashboard.landing.content'));
        $this->assertDatabaseHas('landing_blocks', ['type' => 'rich_text', 'name' => 'Blok Baru']);

        $block = LandingBlock::where('name', 'Blok Baru')->firstOrFail();
        $this->assertSame('Judul Baru', $block->content['title']);
    }

    public function test_admin_landing_pages_render_without_errors(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $block = LandingBlock::create(['type' => 'hero', 'name' => 'Hero', 'content' => [], 'sort_order' => 1]);

        $this->actingAs($admin)->get(route('admin.dashboard.landing.content'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.landing.content.create', ['type' => 'hero']))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.landing.content.edit', $block->id))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.landing.settings'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.landing.contact'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard.landing.contact.create'))->assertOk();
    }

    public function test_admin_can_update_landing_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('admin.dashboard.landing.settings.update'), [
            'site_name' => 'Nama Baru',
            'primary_color' => '#123456',
            'accent_color' => '#abcdef',
            'footer_show' => '1',
            'navbar_links' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Lomba', 'url' => '#lomba'],
            ],
        ]);

        $response->assertRedirect(route('admin.dashboard.landing.settings'));
        $this->assertDatabaseHas('landing_settings', ['key' => 'site_name', 'value' => 'Nama Baru']);
        $this->assertSame('Home', LandingSetting::getJson('navbar_links')[0]['label']);
    }
}
