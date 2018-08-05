<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Storage;

class StorageController extends Controller
{
    public function __construct()
    {
      $this->middleware('api_key');
    }

    public function get(Request $request)
    {
      $value = Storage::getValue($request->key, Auth::id());
      if ($value == null) {
        // return response()->json(['message' => 'the value with given key is not found'], 404);
        return response()->json([$request->key => ''], 404);
      }

      return response()->json([$value->key => $value->value]);
    }

    public function set(Request $request)
    {
      $value = Storage::setValue($request->input('key'),
        Auth::id(), $request->input('value'));

      return response()->json([$value->key => $value->value]);
    }
}
