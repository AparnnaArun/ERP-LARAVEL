<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
protected $fillable = ['empno','empname','position','dateofjoin','contractperiod','probperiodstart','probperiodend','probsalary','ticket','moballowance','vehicle','fuelallowance','accommodation','food','leavedetails','penality','confirmsalary','createdby','cmpid','finyear','wdate'];
}
