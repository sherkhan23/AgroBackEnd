<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "phoneNumber" => ["required", "string"],
            "password" => ["required"]
        ]);

        if(auth("web")->attempt($data)) {
            return redirect(("/"));
        }

        return redirect(route("login"))->withErrors(["email" => "Пользователь не найден, либо данные введены не правильно"]);
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect(route("login"));
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function showForgotForm()
    {
        return view("auth.forgot");
    }

    //  public function userData(){
    //        $data = User::orderBy('id')->take(1)->get();
    //        return view('/', [
    //            'User' => $data,
    //
    //            ]);
    //    }


    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "phoneNumber" => ["required", "string", "unique:users,phoneNumber"],
            "farmer" => ['required'],
            "password" => ["required", "confirmed"]
        ]);

        $user = User::create([
            "name" => $data["name"],
            "phoneNumber" => $data["phoneNumber"],
            "farmer" => $data["farmer"],
            "password" => bcrypt($data["password"])
        ]);

        if($user) {
            //event(new Registered($user));
            auth("web")->login($user);
        }

        return redirect('/');
    }

    public function showProfile()
    {
        return view("profile");
    }

    public function showCheckPhoneNumberExist(){
        return view('auth.checkPhoneNumberExist');
    }


    public function checkPhoneNumberExist(Request $request){
        $data = $request->validate([
            "phoneNumber" => ["required"],
        ]);

        if (DB::table('Users')->where('phoneNumber', $data)->exists()){
            return redirect('/login');
        }
        else{
            return redirect('/register');
        }
    }



}
