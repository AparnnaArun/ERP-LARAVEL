<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class openingaccountdetail extends Model
{
     protected $fillable = ['opaccid','acchead','debit','credit','createdby','cmpid','finyear','wdate','accname'];
}
