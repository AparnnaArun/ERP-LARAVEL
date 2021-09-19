<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
   protected $fillable = ['vendor','short_name','account','phone','email','fax','address','active','approve','business_type','contract_date','credit_limit','credit_days','tax_applicable','website','tax_exempted','exciseduty_applicable','contact_person','designation','cpersonphone','createdby','cmpid','finyear','wdate','lead_time','security_deposit','termsand_conditions'];
}
