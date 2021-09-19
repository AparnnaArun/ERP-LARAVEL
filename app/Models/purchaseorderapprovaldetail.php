<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseorderapprovaldetail extends Model
{
     protected $fillable = ['reqid','item_id','item_code','item_name','unit','apprqnty','grnqnty','invqnty','balqnty','rate','total','createdby','finyear','wdate','cmpid'];
}
