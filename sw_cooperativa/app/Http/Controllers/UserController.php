<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;

use App\User;
use App\Http\Helper\ResponseBuilder;


class UserController extends Controller
{
    public function __construct(){

    }

    public function index (Request $request){
        $users = User::all();
        return response()->json($users, 200);
    }


    public function login(Request $request){
        $Username = $request->username;
        $Password = $request->password;

        $user = User::where('username', $Username)->first();
        error_log($this->django_password_verify($Password, $user->password));
        error_log($user->password);
        if (!empty($user)) {
            if ($this->django_password_verify($Password, $user->password)) {
                $status = true;
                $info = "User is correct";
            } else {
                $status = false;
                $info = "User is incorrect";
            }

        } else {
            $status = false;
            $info = "User is incorrect";
        }
        return ResponseBuilder::result($status, $info);
    }

    
    public function django_password_verify(string $password, string $djangoHash): bool
    {
        $pieces = explode('$', $djangoHash);
        if (count($pieces) !== 4) {
            throw new Exception("Illegal hash format");
        }
        list($header, $iter, $salt, $hash) = $pieces;
        // Get the hash algorithm used:
        if (preg_match('#^pbkdf2_([a-z0-9A-Z]+)$#', $header, $m)) {
            $algo = $m[1];
        } else {
            throw new Exception(sprintf("Bad header (%s)", $header));
        }
        if (!in_array($algo, hash_algos())) {
            throw new Exception(sprintf("Illegal hash algorithm (%s)", $algo));
        }

        $calc = hash_pbkdf2(
            $algo,
            $password,
            $salt,
            (int) $iter,
            32,
            true
        );
        return hash_equals($calc, base64_decode($hash));
    }
}