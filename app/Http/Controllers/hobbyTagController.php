<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class hobbyTagController extends Controller
{
    public function getFilteredHobbies($tag_id)
    {
        // Output for error handling
        //die('Hobbies filtered for tag no: ' . $tag_id);

        // nieuwe instance van Tag om $tag->..... te gebruiken
        $tag = new Tag();

        // Zoek $tag_id, bij geen result een error, 
        // Sla op in $hobbies
        $hobbies = $tag::findOrFail($tag_id)
            // filteredHobbies is functie ex Tag-Model
            ->filteredHobbies()->paginate(10);

        // Sla tag_id op
        $filter = $tag::find($tag_id);

        // return view hobby.index, omdat layout ok is
        // en geef $hobbies van hierboven mee als waarde
        return view('hobby.index', [
            // alternatief vor ->with()
            'hobbies' => $hobbies,
            'filter' => $filter
        ]);
    }
}
