<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesorderdetail extends Model
{
    protected $fillable = ['order_id','dnd_id','item_id','code','item','unit','quantity','issdn_qnty','bal_qnty','rate','discount','amount','createdby','cmpid','finyear','wdate','enq_id'];
}
