<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = [];
    
    public function quiz(){
        return $this->belongsTo('App\Models\Backoffice\Quiz', 'quiz_id','id');
    }

    public function options(){
        return $this->hasMany('App\Models\Backoffice\Option', 'question_id','id');
    }
}
