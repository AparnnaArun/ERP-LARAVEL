<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectinvoice extends Model
{
   protected $fillable = ['slno','projinv_no','projectid','projectname','customerid','customer','dates','totalamount','collected_amount','creditnote_amount','bal_amount','paidstatus','executive','is_deleted','commission_percentage','comm_pay_account','exe_com_exp_ac','createdby','cmpid','finyear','wdate','remarks','cus_accnt'];

public function projectinvoicedetail()
{
 return $this->hasMany(projectinvoicedetail::class,'proinv_id');
}
}
