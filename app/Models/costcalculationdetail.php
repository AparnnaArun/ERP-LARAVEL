<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class costcalculationdetail extends Model
{
     protected $fillable = ['costid','code','item','qnty','purcost','erate','kdamt','extracost','totalkd','totalextra','cost','createdby','cmpid','finyear','wdate'];
}
