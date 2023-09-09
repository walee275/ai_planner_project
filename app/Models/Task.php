<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;



    protected $fillable = [
        'title',
        'description',
        'detailed_description',
        'plan_id',
        'user_id',

    ];


    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
