<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class executive extends Model
{

	
    protected $fillable = ['executive','short_name','account','comm_pay_account','exe_com_exp_ac','active','is_commissioned','commission_percentage','createdby','cmpid','finyear','wdate'];
}
