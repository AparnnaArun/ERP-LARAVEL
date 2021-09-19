<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliverynotedetail extends Model
{
       protected $fillable = ['dln_id','so_id','location_id','item_id','code','item','unit','batch','quantity','inv_qnty','dortn_qnty','bal_qnty','rate','amount','createdby','cmpid','finyear','wdate'];
}
