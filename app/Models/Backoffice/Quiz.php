<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Quiz extends Model
{
    use SoftDeletes;

    protected $table = 'quizzes';

    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
    
    public function questions(){
        return $this->hasMany('App\Models\Backoffice\Question', 'quiz_id','id');
    }
}
