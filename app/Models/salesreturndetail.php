<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesreturndetail extends Model
{
  protected $fillable = ['rtn_id','return_no','item_id','item_code','item_name','unit','batch','rate','salesquantity','freeqnty','rtnqnty','damage','rtnfreeqnty','discount','amount','totalcost','createdby','cmpid','finyear','wdate'];
}
