<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseinvoicedetail extends Model
{
    protected $fillable = ['piid','item_id','item_code','item_name','unit','batch','quantity','rtnqnty','balqnty','rate','total','newcalcost','createdby','finyear','wdate','cmpid'];
}
