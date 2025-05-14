<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Reaction_Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		// Eliminar todas as imagens quando estiver a resetar com o seed, e deixa na mesma as imagens default, só apaga as imagens metidas pelos users seja foto de perfil, 
		// wallpaper ou imagem do post
		$old_profile_photos = File::files(public_path('storage/profile_photos'));
		$old_profile_wallpapers = File::files(public_path('storage/profile_wallpapers'));
		$old_post_wallpapers = File::files(public_path('storage/post_wallpapers'));
		foreach($old_profile_photos as $image) {
			if($image->getFilename() !== 'default.png') {
				File::delete($image->getPathname());
			}
		}
		foreach($old_profile_wallpapers as $image) {
			if($image->getFilename() !== 'default.png') {
				File::delete($image->getPathname());
			}
		}
		foreach($old_post_wallpapers as $image) {
			if($image->getFilename() !== 'factory.png') {
				File::delete($image->getPathname());
			}
		}
		
        User::factory(10)->create();
        Tag::factory(10)->create();
        Post::factory(10)->create();
        Comment::factory(10)->create();
    }
}
