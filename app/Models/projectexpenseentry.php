<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectexpenseentry extends Model
{
protected $fillable = ['slno','entry_no','keycode','executive','vendor_id','expense_type','remarks','dates','user','paymentmode','bankcash','totalamount','number','bank','totalamt','collected_amount','debitnote_amount','balance_amount','paidstatus','balanceamount','createdby','cmpid','finyear','wdate','is_deleted','commission_percentage','comm_pay_account','exe_com_exp_ac','projectid','expensefrom'];

public function projectexpenseentrydetail()
{
 return $this->hasMany(projectexpenseentrydetail::class,'expense_id');
}
}
