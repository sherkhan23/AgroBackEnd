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
            "phoneNumber" => ["required"],
            "password" => ["required"]
        ]);

        if(auth("web")->attempt($data)) {
            return redirect("/home");
        }

        return redirect(route("login"))->withErrors(["phoneNumber" => "Пользователь не найден, либо данные введены не правильно"]);
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



    public function getFarmer(Request $request){
        if(isset($_GET['farmer'])) {
            session_start();
            $_SESSION['farmer1'] = $_GET['farmer'];
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "phoneNumber" => ["required"],
            "farmer" => ["required"],
            "password" => ["required", 'min:6',"confirmed"]
        ]);

        $user = User::create([
            "name" => $data["name"],
            "phoneNumber" => $data["phoneNumber"],
            "farmer" => $data["farmer"],
            "password" => $data["password"]
        ]);

        if($user) {
            //event(new Registered($user));
            auth("web")->login($user);
        }

//        return redirect('/');
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
