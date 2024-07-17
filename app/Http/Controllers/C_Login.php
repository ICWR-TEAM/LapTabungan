<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class C_Login extends Controller
{
    public function index() {
        if(Auth::user()){
            return redirect("/dashboard");
        }
        return view("administrator.login");
    }

    public function action_login(Request $req){
        $data = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $remember = $req->has('remember');

        if (Auth::attempt($data, $remember)) {
            DB::table("users")->where("id", Auth::id())->update(
                [
                    "updated_at" => Carbon::now()
                ]
            );
            $req->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            Session::flash('error_login', 'Email atau password salah.');
            return redirect('/');
        }
    }
}
