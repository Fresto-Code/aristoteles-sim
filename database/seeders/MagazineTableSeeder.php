<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagazineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->where('email', 'admin@argon.com')->first()->id;

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'Homo Sapien',
            'description' => 'A good book description is a detailed, descriptive copy that is good for public display, used for your book marketing, book discovery, and for sales purposes.',
            'url' => 'assets/magazine/1.pdf',
            'cover' => 'assets/covers/1.jpg',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);
       
        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'How to Make Money?',
            'description' => 'Wondering how to write a book description that sells? This post details the process and provides book description examples from famous authors.',
            'url' => 'assets/magazine/2.pdf',
            'cover' => 'assets/covers/2.jpg',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'Naga Bonar',
            'description' => "In this post, we've condensed the process of writing an Amazon book description into three simple steps. We'll also share some examples of book descriptions that sell.",
            'url' => 'assets/magazine/3.pdf',
            'cover' => 'assets/covers/3.jpg',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => "Don't be a fool",
            'description' => 'How to Write a Book Description That Will Captivate Readers',
            'url' => 'assets/magazine/2.pdf',
            'cover' => 'assets/covers/4.jpg',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
