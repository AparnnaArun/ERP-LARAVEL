<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesquotationdetail extends Model
{
    protected $fillable = ['qtn_id','item_id','item','code','unit','quantity','rate','discount','amount','createdby','cmpid','finyear','wdate','enq_id'];
}
