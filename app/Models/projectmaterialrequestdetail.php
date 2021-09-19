<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectmaterialrequestdetail extends Model
{
    protected $fillable = ['matreq_id','item_id','item_name','code','unit','req_qnty','iss_qnty','bal_qnty','createdby','cmpid','finyear','wdate','quoteqnty','balqnty'];
}
