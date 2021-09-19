<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesinvoicedetail extends Model
{
     protected $fillable = ['inv_id','location_id','delidetid','item_id','item_code','item_name','unit','batch','rate','quantity','amount','discount','freeqnty','totalcost','isslnrtn_qnty','penrtn_qnty','createdby','cmpid','finyear','wdate'];
}
