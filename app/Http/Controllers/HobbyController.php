<?php

namespace App\Http\Controllers;

use App\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Haalt alle data uit table en geeft aan var
        $hobbies = Hobby::all();

        // Returns view index.blade.php ex map Hobby en geeft $hobbies array mee
        return view('hobby.index')->with([
            'hobbies' => $hobbies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Returns view create.blade.php ex map Hobby
        return view('hobby.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            // Naam min 3 chars
            'name'      => 'required|min:3',
            // Description min 5 chars
            'description'      => 'required|min:5'
        ]);

        // Nieuwe instance van Hobby object, zie use app/Hobby
        $hobby = new Hobby([
            'name'          => $request->name,
            'description'   => $request->description
        ]);
        // Sla op
        $hobby->save();

        // Keer terug naar overview met success message
        return $this->index()->with([
            'message_success'    => "The hobby <b>" . $hobby->name . "</b> was added."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        //Ga naar Details page van hobby
        return view('hobby.show')->with([
            'hobby' => $hobby
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        //Return view en geef hobby mee
        return view('hobby.edit')->with([
            'hobby' => $hobby
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hobby $hobby)
    {
        //Validation
        $request->validate([
            // Naam min 3 chars
            'name'      => 'required|min:3',
            // Description min 5 chars
            'description'      => 'required|min:5'
        ]);

        // Update records
        $hobby->update([
            // Welke velden geupdate worden. Request = hobby
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        // Return view met attributes voor success message
        return $this->index()->with([
            'message_success' => "The hobby <b>" . $hobby->name . "</b> was updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {
        //Sla hobby naam op voor success message alvorens te verwijderen
        $oldName = $hobby->name;

        // Verwijder record
        $hobby->delete();

        // return index incl success msg
        return $this->index()->with([
            'message_success' => "The hobby <b> " . $oldName . "</b> was deleted."
        ]);
    }
}
