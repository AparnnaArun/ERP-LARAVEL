<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemmaster extends Model
{
    protected $fillable = ['item','active','slno','code','is_local','localslno','description','item_type','brand','category','commodity','item_group','basic_unit','alt_unit','business_item','criticality','cost','part_no','costing_method','batch_wise','exp_applicable','minimum_stock','reorder_level','maximum_stock','automatic_reorder_level','intervals','reordering_quantity_days','demand','no_days','buffer_stock','purchase_account','sales_account','purchasereturn_account','salesreturn_account','createdby','cmpid','finyear','wdate'];
}
