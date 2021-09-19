<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usercompany extends Model
{
     protected $fillable = ['userid','companyid','createdby','cmpid','finyear','wdate'];
}
