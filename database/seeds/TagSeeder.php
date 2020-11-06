<?php

use Illuminate\Database\Seeder;
// Model Tag
use App\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Array met tags met BS kleuren
        // Dit zijn statische waardes, want deze zijn
        // van te vooren vastgesteld.
        $tags = [
            'Sports'        => 'primary', //Primary is Blauw in BS
            'Relaxation'    => 'secondary', // Grijs
            'Social'        => 'success', // Groen
            'Work'          => 'danger', // Rood
            'Family'        => 'info' // Azure
        ];

        // Loop door tags om in te voeren in tags tabel
        foreach ($tags as $key => $value) {

            $tag = new Tag([
                // De key wordt als name ingevoerd
                'name'  => $key,
                // en de value als style
                'style' => $value
            ]);
            // Opslaan met save-method van Tag Model
            $tag->save();
        }
    }
}
