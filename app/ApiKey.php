<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{

    protected $fillable = [
      'user_id', 'key'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public static function check($key)
    {
      $apiKeyresult = self::where('key', $key)->first();

      if ($apiKeyresult) {
        return $apiKeyresult->user;
      }

      return null;
    }
}
