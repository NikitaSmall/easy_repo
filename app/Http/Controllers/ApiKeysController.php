<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiKey;
use Auth;

class ApiKeysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        ApiKey::create([
          'user_id' => $user->id,
          'key' => md5(openssl_random_pseudo_bytes(20) . $user->email)
        ]);

        return redirect(route('home'));
    }
}
