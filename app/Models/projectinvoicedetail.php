<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectinvoicedetail extends Model
{
     protected $fillable = ['proinv_id','item_id','item','rate','qnty','total','createdby','cmpid','finyear','wdate'];
}
