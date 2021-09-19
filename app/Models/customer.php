<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
     protected $fillable = ['name','short_name','account','phone','email','fax','address','active','approve','businesstype','ratetype','creditlimit','creditdays','taxapplicable','website','taxexempted','customerstatus','contactperson','designation','cpersonphone','createdby','cmpid','finyear','wdate','specialprice'];

}
