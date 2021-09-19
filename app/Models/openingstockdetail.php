<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class openingstockdetail extends Model
{
   protected $fillable = ['opening_id','item_id','inward_date','exp_date','batch','unit','opening_qnty','opening_rate','stock_value','createdby','cmpid','finyear','wdate'];
}
