<?php

namespace App\Http\Controllers;

use App\Hobby;
use App\Tag;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HobbyController extends Controller
{

    // Constructor
    public function __construct()
    {
        // Beprekt toegang voor uitgelogde users tot index en show methods
        $this->middleware('auth')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Haalt alle data uit table en geeft aan var
        // $hobbies = Hobby::all();

        // Slaat alles uit tabel op in var incl pagination en sorteer op created_at datum
        $hobbies = Hobby::orderBy('created_at', 'DESC')->paginate(10);
        // 10 results per page

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
        $request->validate([
            // Naam min 3 chars
            'name'      => 'required|min:3',
            // Description min 5 chars
            'description'      => 'required|min:5',
            // Image upload, check MIME-types, max size 1mb. max-width 200px
            'image' => 'mimes:jpeg,bmp,jpg,png,gif|max:1000|dimensions:max_width=2000'
        ]);

        // Nieuwe instance van Hobby object, zie use app/Hobby
        $hobby = new Hobby([
            'name'          => $request->name,
            'description'   => $request->description,
            'user_id' => auth()->id()
        ]);
        // Sla op
        $hobby->save();

        // Upload image
        if ($request->image) {
            //Generate img functie
            $this->saveImages($request->image, $hobby->id);
        }

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
        $allTags = Tag::all();

        $usedTags = $hobby->tags;

        $availableTags = $allTags->diff($usedTags);



        //Ga naar Details page van hobby
        return view('hobby.show')->with([
            'hobby' => $hobby,
            'availableTags' => $availableTags,
            'message_success' => Session::get('message_success')
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
            'hobby' => $hobby,
            'message_success' => Session::get('message_success')
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
            'description'      => 'required|min:5',
            // Image upload, check MIME-types, max size 1mb. max-width 200px
            'image' => 'mimes:jpeg,bmp,jpg,png,gif|max:1000|dimensions:max_width=2000'
        ]);

        // Upload image
        if ($request->image) {
            //Generate img functie
            $this->saveImages($request->image, $hobby->id);
        }

        // Update records
        $hobby->update([
            // Welke velden geupdate worden. Request = hobby
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        return redirect('/user/{{$user->id')->with([
            'hobby' => $hobby,
            'message_success' => Session::get('message_success')
        ]);
        // Return view met attributes voor success message
        // return $this->index()->with([
        //     'message_success' => "The hobby <b>" . $hobby->name . "</b> was updated."
        // ]);
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

    //Generate images
    function saveImages($imageInput, $hobby_id)
    {
        // sla op in var
        $image = Image::make($imageInput);
        // Check img orientation
        if ($image->width() > $image->height()) {
            // dd('Landscape');
            // Vergroot width naar 1200 en sla op in img/hobies/hobby_id+_large.jpg 
            $image->widen(1200)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")
                // maak van deze weer een geblurde img width 400 en sla op
                ->widen(400)->pixelate(12)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");
            // public_path verwijst naar de root folder
            // nieuwe instance. omdat we van een geburde 400 geen nieuwe ongeblurde thumb kunnen maken
            $image = Image::make($imageInput);
            // thumb 60px
            $image->widen(60)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg");
        } else {
            // dd('Portrait');
            $image->heighten(900)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")
                // maak van deze weer een geblurde img width 400 en sla op
                ->heighten(400)->pixelate(12)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");
            // public_path verwijst naar de root folder
            // nieuwe instance. omdat we van een geburde 400 geen nieuwe ongeblurde thumb kunnen maken
            $image = Image::make($imageInput);
            // thumb 60px
            $image->heighten(60)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg");
        }
    }

    function deleteImages($hobby_id)
    {
        if (file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")) {
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg");
        }
        if (file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg")) {
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");
        }
        if (file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg")) {
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg");
        }

        return back()->with([
            'success_message' => "Image is deleted"
        ]);
    }
}
