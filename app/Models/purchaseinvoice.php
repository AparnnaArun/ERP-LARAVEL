<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseinvoice extends Model
{
         protected $fillable = ['slno','p_invoice','invoice','dates','vendor','payment_mode','inv_date','project_code','purchase_method','currency','locations','additionalcharges','tot_qnty','tamount','discount_total','tax','net_total','erate','totalamount','collected_amount','debit_note_amount','balance','is_deleted','is_returned','paidstatus','createdby','finyear','wdate','cmpid','grnid'];


        public function purchaseinvoicedetail()
{
 return $this->hasMany(purchaseinvoicedetail::class,'piid');
}
}
