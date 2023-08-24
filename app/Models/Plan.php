<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'user_id',

    ];


    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
