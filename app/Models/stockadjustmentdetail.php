<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockadjustmentdetail extends Model
{
      protected $fillable = ['stockid','item_id','item_code','item','unit','qnty','rate','stock_value','createdby','cmpid','finyear','wdate','batch'];
}
