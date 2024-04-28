<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
    
    public function getAvatar(){
        if($this->filename!='' AND $this->directory!=''){
            return $this->directory.'/'.$this->filename;
        }
        return 'assets/img/profiles/avatar.jpg';
    }
}
