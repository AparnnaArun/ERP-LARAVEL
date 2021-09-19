<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliverynotereturn extends Model
{
    
          protected $fillable = ['slno','rtn_no','deli_note_number','location','customer','remarks','dates','createdby','cmpid','finyear','wdate'];


        public function deliverynotereturndetail()
{
 return $this->hasMany(deliverynotedetail::class,'dnrtn_id');
}
}
