<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Haalt alle data uit table en geeft aan var
        $tags = Tag::all();

        // Returns view index.blade.php ex map Hobby en geeft $hobbies array mee
        return view('tag.index')->with([
            'tags' => $tags
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
        return view('tag.create');
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
            'style'      => 'required|min:5'
        ]);

        // Nieuwe instance van Hobby object, zie use app/Hobby
        $tag = new Tag([
            'name'          => $request->name,
            'style'   => $request->style
        ]);
        // Sla op
        $tag->save();

        // Keer terug naar overview met success message
        return $this->index()->with([
            'message_success'    => "The tag <b>" . $tag->name . "</b> was added."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //Return view en geef hobby mee
        return view('tag.edit')->with([
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //Validation
        $request->validate([
            // Naam min 3 chars
            'name'      => 'required|min:3',
            // Description min 5 chars
            'style'      => 'required|min:5'
        ]);

        // Update records
        $tag->update([
            // Welke velden geupdate worden. Request = hobby
            'name'          => $request->name,
            'style'   => $request->style
        ]);

        // Return view met attributes voor success message
        return $this->index()->with([
            'message_success' => "The tag <b>" . $tag->name . "</b> was updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //Sla hobby naam op voor success message alvorens te verwijderen
        $oldName = $tag->name;

        // Verwijder record
        $tag->delete();

        // return index incl success msg
        return $this->index()->with([
            'message_success' => "The tag <b> " . $oldName . "</b> was deleted."
        ]);
    }
}
