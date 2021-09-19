<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesenquirydetail extends Model
{
      protected $fillable = ['enq_id','item_id','item_name','code','unit','description','quantity','drawing_no','createdby','cmpid','finyear','wdate','quoteqnty','balqnty'];
}
