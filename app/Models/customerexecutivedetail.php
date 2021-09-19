<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerexecutivedetail extends Model
{
   protected $fillable = ['customerid','executive','createdby','cmpid','finyear','wdate'];
}
