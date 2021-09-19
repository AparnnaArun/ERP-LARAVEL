<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    public $fillable = ['accounttype','seqnumber','active','name','printname','parentid','description','category','fullcode','createdby','finyear','wdate','cmpid'];

    public function childs() {
        return $this->hasMany('App\Models\account','parentid','id') ;
    }
}
