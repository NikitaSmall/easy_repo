<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
      'user_id', 'key', 'value'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public static function getValue($key, $userId)
    {
      return self::where('key', $key)->where('user_id', $userId)->first();
    }

    public static function setValue($key, $userId, $value)
    {
      return self::updateOrCreate(
        ['key' => $key, 'user_id' => $userId], ['value' => $value]
      );
    }
}
