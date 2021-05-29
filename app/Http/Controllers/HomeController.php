<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Events\sendmessage;
use App\Events\userActivity;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $req)
    {
        if ($req->isMethod("GET")) {
            $user = Auth::user();

            $user->status = "Online";
            $user->save();
            //dd($user);
            $user = User::where("status", "=", "Online")->get('id');
            // dd($user);
            event(new userActivity(Auth::user(), "Online"));

            return view('chatroom', ['user' => $user]);
        } else if ($req->ajax()) {
            event(new sendmessage($req->text, $req->user));
        }
    }
    public function logout()
    {
        $user = Auth::user();
        $user->status = "Offline";
        $user->save();
        event(new userActivity(Auth::user(), "left"));
        Auth::logout();
        return view('welcome');
    }
}
