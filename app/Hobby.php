<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    // Eloquent Relationship:
    // 1 hobby behoort tot 1 user
    public function user()
    {
        //Deze class heeft meerdere instances
        return $this->belongsTo('App\User');
    }

    //1 hobby heeft meerdere tags
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'user_id'
    ];
}
