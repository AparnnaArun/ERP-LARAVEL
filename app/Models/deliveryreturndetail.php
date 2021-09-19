<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliveryreturndetail extends Model
{
    protected $fillable = ['dnrtn_id','item_id','item_code','item_name','unit','batch','dnqnty','rtnqnty','rate','amount','createdby','cmpid','finyear','wdate'];
}
