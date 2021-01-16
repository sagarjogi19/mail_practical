<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id', 
        'parent_id',
        'subject',
        'message',
        'is_read'
    ];
    
    public function thread()
   {
      return $this->hasMany(Mail::class, 'parent_id');
    }
    
    public function lastthread()
   {
      return $this->hasOne(Mail::class, 'parent_id')->orderBy('id','desc');
    }
    
    public function from() {
        return $this->belongsTo('App\User', 'from_user_id', 'id');
    }
    
    public function to() {
        return $this->belongsTo('App\User', 'to_user_id', 'id');
    }
}
