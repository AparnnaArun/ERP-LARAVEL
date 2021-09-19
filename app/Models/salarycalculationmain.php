<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salarycalculationmain extends Model
{
    protected $fillable = ['slno','keycode','voucher','month','year','workingdays','totalnetsalary','totaladvance','collected_amount','balance','is_deleted','createdby','cmpid','finyear','wdate','dates','advncebalnce','collectedadvnce'];
}
