<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockmovement extends Model
{
protected $fillable = ['voucher_id','voucher_type','voucher_date','description','location_id','item_id','unit','batch','rate','quantity','stock_value','status','createdby','cmpid','finyear','wdate','qntyout','stockout'];
}
