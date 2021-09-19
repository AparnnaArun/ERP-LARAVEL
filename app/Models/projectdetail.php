<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectdetail extends Model
{
  protected $fillable = ['slno','project_code','project_name','short_name','customer_id','exp_startingdate','exp_endingdate','executive','customer_po','remarks','is_completed','is_deleted','createdby','cmpid','finyear','wdate','active'];
}
