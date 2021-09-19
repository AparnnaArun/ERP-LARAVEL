<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesinvoice extends Model
{
      protected $fillable = ['slno','invoice_no','po_number','manual_do_no','manual_inv_no','customer_id','cus_accnt','customer','payment_mode','dates','total','currency','deli_note_no','ship_to','invoicefrom','delinoteno','discount_total','net_total','freight','pf','insurance','others','advance','grand_total','collected_amount','creditnote_amount','balance','deli_info','payment_terms','vehicle_details','tax','sales_commission','erate','paidstatus','totcosts','isslnrtn_amt','profit','createdby','cmpid','finyear','wdate','is_deleted','is_returned','commission_percentage','comm_pay_account','exe_com_exp_ac','rtncost'];

public function salesinvoicedetail()
{
 return $this->hasMany(salesinvoicedetail::class,'inv_id');
}
}
