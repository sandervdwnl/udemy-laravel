<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    // Eloquent Relationship:
    // 1 tag behoort tot meerdere hobbies
    public function hobbies()
    {
        return $this->belongsToMany('App\Hobby');
    }

    public function filteredHobbies()
    {
        //class Tag behoort tot vele van class Hobbies,
        // waar in Pivot table tag_id gelijk is aan Tag table $tag->id,
        // gesorteerd op aflopend 'updated_at' van Hobby table
        return $this->belongsToMany('App\Hobby')->wherePivot('tag_id', $this->id)
            ->orderBy('updated_at', 'DESC');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'style',
    ];
}
