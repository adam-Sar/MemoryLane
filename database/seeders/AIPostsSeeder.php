<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Community;
use Illuminate\Database\Seeder;

class AIPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure we have at least one user
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password')
            ]);
        }

        // Ensure we have at least one community
        $community = Community::first();
        if (!$community) {
            $community = Community::create([
                'name' => 'Retro Gaming',
                'slug' => 'retro-gaming',
                'description' => 'A place for classic games.',
                'user_id' => $user->id
            ]);
        }

        // Post 1: Platformer
        Post::create([
            'user_id' => $user->id,
            'community_id' => $community->id,
            'title' => 'Found a hidden pit mechanic in this old platformer',
            'body' => "I was replaying this classic 8-bit game today and noticed something weird about this specific pit. Look at the doodle, I circled it in pink. If you hold down while jumping, you clip through the invisible wall into a secret developer room!\n\nHas anyone else ever noticed this? I've been playing this for 20 years and only just discovered it.",
            'tag' => 'Action',
            'screenshot_path' => 'posts/retro_platformer.png',
            'doodle_path' => 'posts/doodle_platformer.png',
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
        ]);

        // Post 2: Racing
        Post::create([
            'user_id' => $user->id,
            'community_id' => $community->id,
            'title' => 'Hilarious glitch in this 90s racing title',
            'body' => "So I managed to get a screenshot before the game completely crashed. As you can see by my doodle, the green exclamation mark points to the blue vehicle that's literally floating sideways.\n\nTurns out, if you drift exactly at the pixel boundary of the dirt terrain and the asphalt, the physics engine divides by zero and sends you into orbit.",
            'tag' => 'Sports',
            'screenshot_path' => 'posts/racing.png',
            'doodle_path' => 'posts/doodle_racing.png',
            'created_at' => now()->subHours(5),
            'updated_at' => now()->subHours(5),
        ]);

        // Post 3: RPG
        Post::create([
            'user_id' => $user->id,
            'community_id' => $community->id,
            'title' => 'Help identifying this cursed item from my old save file?',
            'body' => "I booted up my old SNES cartridge after a decade. I checked my inventory and there's this weird placeholder item that I crossed out here in cyan.\n\nIt has no name, no stats, and if I try to equip it, the background music stops playing. I'm too scared to sell it.",
            'tag' => 'RPG',
            'screenshot_path' => 'posts/rpg.png',
            'doodle_path' => 'posts/doodle_rpg.png',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        echo "AI posts seeded successfully.\n";
    }
}
