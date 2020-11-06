<?php

use Illuminate\Database\Seeder;
// nodig voor db::table functie
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Call UserFactory 100x icm create om 100 users aan te maken
        factory(App\User::class, 100)->create()
            // Maak bij elke call gelijk random 1 tot 8 hobby's aan
            ->each(function ($user) {
                factory(App\Hobby::class, rand(1, 8))->create([
                    // Vul user id waarde in in col user_id
                    'user_id'   => $user->id
                    // Maak gelijk hobby's aan
                ])->each(function ($hobby) {
                    // Sla array met waarde van 1 tot 8 op
                    $tags_ids = range(1, 8);
                    // Shuffle de waardes in de array
                    shuffle($tags_ids);
                    // sla 1e zoveel random waarde op, bijv 2,4,8 uit 2,4,8,1,3,5,7,6
                    $assignments = array_slice(0, rand(1, 8));
                    // Invoeren in hobby_tag tabel
                    foreach ($assignments as $tag_id) {
                        DB::table('hobby_tag')->insert([
                            'hobby_id'  => $hobby->id,
                            'tag_id'    => $tag_id, //1 waarde van $assignments
                            //Omdat we Facades\DB gebruiken, vullen we deze 2 cols zelf in
                            'created_at'    => Now(),
                            'updated_at'    => Now()
                        ]);
                    }
                });
            });
    }
}
