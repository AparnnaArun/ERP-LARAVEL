<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requestforquotationdetail extends Model
{
   protected $fillable = ['reqid','item_id','item_code','item_name','unit','reqqnty','rate','total','createdby','finyear','wdate','cmpid'];
}
