<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasereturndetail extends Model
{
    protected $fillable = ['purrtn_id','item_id','item_code','item_name','unit','batch','quantity','rate','total','createdby','finyear','wdate','cmpid'];
}
