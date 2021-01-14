<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //Ga naar Details page van hobby
        return view('user.show')->with([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // //Return view en geef hobby mee
        return view('user.edit')->with([
            'user' => $user,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Validation
        $request->validate([
            // Description min 5 chars
            'motto'      => 'required|min:25',
            // Image upload, check MIME-types, max size 1mb. max-width 200px
            'image' => 'mimes:jpeg,bmp,jpg,png,gif|max:1000|dimensions:max_width=2000'
        ]);

        // Upload image
        if ($request->image) {
            //Generate img functie
            $this->saveImages($request->image, $user->id);
            // error check
        }

        // Update records
        $user->update([
            // Welke velden geupdate worden. Request = hobby
            'about_me' => $request['about_me'],
            'motto'    => $request['motto']
        ]);

        // Return view met attributes voor success message
        return redirect('/home')->with([ //editted path due to bug
            'message_success' => "The user info <b>" . $user->name . "</b> was updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    //Generate images
    function saveImages($imageInput, $user_id)
    {
        // sla op in var
        $image = Image::make($imageInput);
        // Check img orientation
        if ($image->width() > $image->height()) {
            // dd('Landscape');
            // Vergroot width naar 1200 en sla op in img/hobies/hobby_id+_large.jpg 
            $image->widen(1200)
                ->save(public_path() . "/img/users/" . $user_id . "_large.jpg")
                // maak van deze weer een geblurde img width 400 en sla op
                ->widen(400)->pixelate(12)
                ->save(public_path() . "/img/users/" . $user_id . "_pixelated.jpg");
            // public_path verwijst naar de root folder
            // nieuwe instance. omdat we van een geburde 400 geen nieuwe ongeblurde thumb kunnen maken
            $image = Image::make($imageInput);
            // thumb 60px
            $image->widen(60)
                ->save(public_path() . "/img/users/" . $user_id . "_thumb.jpg");
        } else {
            // dd('Portrait');
            $image->heighten(900)
                ->save(public_path() . "/img/users/" . $user_id . "_large.jpg")
                // maak van deze weer een geblurde img width 400 en sla op
                ->heighten(400)->pixelate(12)
                ->save(public_path() . "/img/users/" . $user_id . "_pixelated.jpg");
            // public_path verwijst naar de root folder
            // nieuwe instance. omdat we van een geburde 400 geen nieuwe ongeblurde thumb kunnen maken
            $image = Image::make($imageInput);
            // thumb 60px
            $image->heighten(60)
                ->save(public_path() . "/img/users/" . $user_id . "_thumb.jpg");
        }
    }

    function deleteImages($user_id)
    {
        if (file_exists(public_path() . "/img/users/" . $user_id . "_large.jpg")) {
            unlink(public_path() . "/img/hobbies/" . $user_id . "_large.jpg");
        }
        if (file_exists(public_path() . "/img/users/" . $user_id . "_pixelated.jpg")) {
            unlink(public_path() . "/img/hobbies/" . $user_id . "_pixelated.jpg");
        }
        if (file_exists(public_path() . "/img/users/" . $user_id . "_thumb.jpg")) {
            unlink(public_path() . "/img/users/" . $user_id . "_thumb.jpg");
        }

        return back()->with([
            'success_message' => "Image is deleted"
        ]);
    }
}
