<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class overtime extends Model
{
    protected $fillable = ['type','rate','createdby','cmpid','finyear','wdate'];
}
