<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockissuereturndetail extends Model
{
    protected $fillable = ['stissrtn_id','item_id','item_code','item_name','unit','issqnty','rtnqnty','rate','total','createdby','cmpid','finyear','wdate','batch'];
}
