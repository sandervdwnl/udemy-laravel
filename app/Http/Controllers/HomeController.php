<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hobby; //added myself due to bug
use Illuminate\Support\Facades\Session; //added myself due to bug

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hobbies = Hobby::select()
            ->where('user_id', auth()->id())
            ->orderBy('updated_at', 'DESC')
            ->get();


        return view('home')->with([
            'hobbies' => $hobbies,
            'message_success' => Session::get('message_success')
        ]);
    }
}
