<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectexpenseentrydetail extends Model
{
   protected $fillable = ['expense_id','projectid','projectcode','projectname','customerid','customer','executive','amount','createdby','cmpid','finyear','wdate'];
   public function projectexpenseentry()
{
 return $this->belongsTo(projectexpenseentry::class,'id');
}
 
}
