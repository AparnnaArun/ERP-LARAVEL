<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salarycalculation extends Model
{
    protected $fillable = ['name','month','year','empid','bsalary','allowance','addallowance','norover','frover','holover','thissalary','workingdays','workeddays','createdby','cmpid','finyear','wdate','nramount','framount','holamount','slid','deduction','nettotal','advance','amount'];
}
