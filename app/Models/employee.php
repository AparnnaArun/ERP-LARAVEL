<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
   protected $fillable = ['slno','empid','name','dob','dateofjoining','joiningposition','department','curposition','salaried','approve','bsalary','allowance','vehicleno','accname','address','actualdob','homeaddr','kwttel1','kwttel2','hometel','email','emergency1','emergency1no','emergency2','emergency2no','spouse','spouseno','nochildren','education','passportno','weddate',
   'createdby','cmpid','finyear','wdate','passportexp','civilidno','civilidexp','lisenceno','lisenceexp'];
}
