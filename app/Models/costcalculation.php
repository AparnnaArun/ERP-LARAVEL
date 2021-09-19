<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class costcalculation extends Model
{
    protected $fillable = ['pi_no','purchasecost','addcharges','customs','freight','insurance','transport','extracost','totalextracost','percentextracost','is_deleted','createdby','cmpid','finyear','wdate'];
            public function costcalculationdetail()
{
 return $this->hasMany(costcalculationdetail::class,'costid');
}
}
