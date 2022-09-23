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
        $id = DB::table('users')->where('email', 'agus.halim@afresto.com')->first()->id;

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'Cubes 2016/2017',
            'description' => 'This is about architecture',
            'url' => 'magazines/1662891430_magazine/SAW7sQapPSqR3ai83WBB5UlyOo6HMnr8s66zgq7y.pdf',
            'cover' => 'magazines/1662891430_magazine/iaupW54xERVhZmNQGI3ratOFYxXPYZMRc4eqn7p5.png',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'The Nation',
            'description' => 'walked out of school, they asked for adults to join
            them next time',
            'url' => 'magazines/1662886385_magazine/2Z82zXkEOiPxEiGuSP6HzsIC3yIKh2IFVMeCrOUO.pdf',
            'cover' => 'magazines/1662886385_magazine/ntGNYGF9xiXa07Zq6UbYFamRULrBNwUi8kQzQvkn.png',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => 'The Economist',
            'description' => "Donald Trump sought his
            fourth national security adviser in less than three years after
            firing John Bolton, who had
            been in the job for 17 months.
            Mr Bolton says he resigned
            before Mr Trump sacked him.
            The pair had not seen eye to
            eye: Mr Bolton was far more
            hawkish on Iran, North Korea
            and Russia",
            'url' => 'magazines/1662888877_magazine/cakbZ0nCf9mpsQngRjnRL2PF4jvJWkpFR3nEATrE.pdf',
            'cover' => 'magazines/1662888877_magazine/MGMXpW3kEtsrdWBuK3qnXYpZdaIxqkuw6oz9oIqV.png',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('magazines')->insert([
            'author_id' => $id,
            'title' => "The Architecture Digest Italy",
            'description' => 'the art or science of building specifically : the art or practice of designing and building structures and especially habitable ones',
            'url' => 'magazines/1662910199_magazine/uQ56R3P9THtqKyF9G5Kc2Kcei9vLZenLf02fERpX.pdf',
            'cover' => 'magazines/1662910199_magazine/qWCMaDkFeuyU9b4tlas7gX4Sr2XJLjeXebM2ThbC.png',
            'moderation_status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
