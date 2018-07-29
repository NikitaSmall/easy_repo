<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function __construct()
    {
      $this->middleware('api_key');
    }

    public function get(Request $request)
    {
      return response()->json(['key' => 'value']);
    }

    public function set(Request $request)
    {
      return response()->json(['key' => 'set!']);
    }
}
