<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proformainvoicedetail extends Model
{
  protected $fillable = ['pro_id','item_id','item','code','unit','quantity','rate','discount','amount','createdby','cmpid','finyear','wdate','qtnd_id'];
}
