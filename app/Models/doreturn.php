<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doreturn extends Model
{
   protected $fillable = ['slno','rtn_no','deli_note_number','location','customer','remarks','dates','createdby','cmpid','finyear','wdate'];
  public function deliveryreturndetail()
{
 return $this->hasMany(deliveryreturndetail::class,'dnrtn_id');
}
   
}
