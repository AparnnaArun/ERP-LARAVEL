<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
     protected $fillable = ['vehicleno','vehicletype','manufactyear','purchasedate','purchaseamount','registrationexpiry','insurance','insuranceexpiry','salesdate','active','createdby','cmpid','finyear','wdate'];
}
