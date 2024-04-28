<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $guarded = [];
    
    public function question(){
        return $this->belongsTo('App\Models\Backoffice\Question', 'question_id','id');
    }
}
