<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasecostdetail extends Model
{
  protected $fillable = ['pcid','dates','costfor','vendoracc','vendor','amount','createdby','finyear','wdate','cmpid','settledamt','unsettledamt','pinvid','addnos'];
}
