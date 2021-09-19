<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stocktransferdetail extends Model
{
     protected $fillable = ['transfer_id','item_id','item_code','item_name','unit','qnty','rate','stock_value','createdby','cmpid','finyear','wdate','batch'];
}
