<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;

    protected $table = 'results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo('App\Models\Backoffice\Quiz', 'quiz_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }

    public function answers(){
        return $this->hasMany('App\Models\Backoffice\Answer', 'result_id','id');
    }

    public function scoreResult(){
        return $this->hasMany('App\Models\Backoffice\Answer', 'result_id','id')->where('is_correct', TRUE)->count();
    }
}
