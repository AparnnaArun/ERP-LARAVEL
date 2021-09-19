<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesrateupdation extends Model
{
    protected $fillable = ['date','division','category','item_id','item','batch','retail_salesrate','retail_bottomrate','wholesale_salesrate','wholesale_bottomrate','dealer_salesrate','dealer_bottomrate','createdby','cmpid','finyear','wdate'];
}
