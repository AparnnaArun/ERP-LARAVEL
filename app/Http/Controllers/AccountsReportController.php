<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use App\Models\account;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\customer;
use App\Models\openingaccountdetail;
use App\Models\receiptdetail;
use App\Models\receipt;
use App\Models\vendor;
use App\Models\purchaseinvoice;
use App\Models\projectinvoice;
use App\Models\vendorpayment;
use App\Models\deliverynote;
use App\Models\salesorder;
use App\Models\executivecommission;
use App\Models\salesinvoice;
use App\Models\salesinvoicedetail;
use App\Models\projectmaterialissuedetail;
use App\Models\projectmaterialissue;
use App\Models\executive;
use App\Models\itemmaster;
use App\Models\stockmovement;
use App\Models\currentstock;
  
class AccountsReportController extends Controller
{
    function getdaybook(Request $req){
        if(session('id')!=""){
      
      return view('accounts/reports/daybook');
      }
else{
 return redirect('/erp'); 

   }
}


function loaddaybook(Request $req) {
  $action=$req->action;
  $dates=$req->startdate;
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->enddate;
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $voch = regularvoucherentry::with('regularvoucherentrydetail')
               ->whereBetween('dates',array($nddate,$nddate1))
              ->orderBy('id','desc')->get();  
 return view('accounts/reports/loaddaybook',['voch'=>$voch,'action'=>$action]);

   }
   function getjournal(Request $req){
       if(session('id')!=""){
      
      return view('accounts/reports/journal');
      }
else{
 return redirect('/erp'); 

   }


   }
   function ageing(Request $req){
     $custs =customer::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('accounts/receipts/ageing',['custs'=>$custs]); 
   }
 function sageing(){
    $custs =customer::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('accounts/receipts/salesageing',['custs'=>$custs]); 
   }
   function sreport(){
    $custs =customer::select('id','short_name','account')->orderBy('short_name','Asc')->get();
   return view('accounts/receipts/salesreport',['custs'=>$custs]); 
   }
   function loadsalesreport(Request $req){
$cusss=customer::select('name')->where('account',$req->customer)->first();
  $op =openingaccountdetail::where('acchead',$req->customer)
      ->first();
      $reg=regularvoucherentrydetail::where('account_name',$req->customer)
           ->get();
           return view('accounts/receipts/loadsalesreport',['op'=>$op,'reg'=>$reg,'cusss'=>$cusss]); 

   }
    function rreport(Request $req){

   if(session('id')!=""){
      $rec =receipt::with('receiptdetail')->leftJoin('customers', 'receipts.customer', '=', 'customers.id')->select('receipts.*','customers.short_name')
      ->orderBy('receipts.id','desc')->get();
      return view('accounts/receipts/receiptreport',['rec'=>$rec]);
      }
else{
 return redirect('/erp'); 

   }
  

    }
 function pageing(Request $req){
$custs =vendor::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('accounts/payments/ageing',['custs'=>$custs]); 

   }
   function getpurageing(Request $req){
     $vend=vendor::select('short_name')
          ->where('id',$req->vendor)->first();
    $pinv = purchaseinvoice::leftJoin('vendors', function($joins) {
      $joins->on('purchaseinvoices.vendor', '=', 'vendors.id');
         })->where('purchaseinvoices.is_deleted','0')
    ->where('purchaseinvoices.paidstatus','!=','1')
    ->where('purchaseinvoices.is_returned','!=','1')
    ->where('purchaseinvoices.vendor',$req->vendor)
    ->select('purchaseinvoices.id','purchaseinvoices.p_invoice','vendors.short_name','purchaseinvoices.totalamount','purchaseinvoices.collected_amount','purchaseinvoices.debit_note_amount','purchaseinvoices.balance','purchaseinvoices.dates')
      ->get();
 
return view('accounts/payments/loadageing',['pinv'=>$pinv,'vend'=>$vend]);
    
   }
   function purageing(Request $req){
$custs =vendor::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('accounts/payments/purchaseageing',['custs'=>$custs]); 

   }
function getallpurageing(Request $req){
   $vend=vendor::select('short_name')
          ->where('id',$req->vendor)->first();
     $pinv = purchaseinvoice::leftJoin('vendors', function($joins) {
      $joins->on('purchaseinvoices.vendor', '=', 'vendors.id');
         })->where('purchaseinvoices.is_deleted','0')
    ->where('purchaseinvoices.paidstatus','!=','1')
    ->where('purchaseinvoices.is_returned','!=','1')
    ->where('purchaseinvoices.vendor',$req->vendor)
    ->select('purchaseinvoices.id','purchaseinvoices.p_invoice','vendors.short_name','purchaseinvoices.totalamount','purchaseinvoices.collected_amount','purchaseinvoices.debit_note_amount','purchaseinvoices.balance','purchaseinvoices.dates')
      ->get(); 
      return view('accounts/payments/allpurageing',['pinv'=>$pinv,'vend'=>$vend]);  
}
function purreport(Request $req){
$custs =vendor::select('id','short_name','account')->orderBy('short_name','Asc')->get();
   return view('accounts/payments/purchasereport',['custs'=>$custs]); 

}
function getpurreport(Request $req){

 $cusss=vendor::select('short_name')->where('account',$req->vendor)->first();
  $op =openingaccountdetail::where('acchead',$req->vendor)
      ->first();
      $reg=regularvoucherentrydetail::where('account_name',$req->vendor)
           ->get();
           return view('accounts/payments/loadpurchsereport',['op'=>$op,'reg'=>$reg,'cusss'=>$cusss]);     
}
function getcashbook(Request $req){
     if(session('id')!=""){
      $acc =account::where('category','cash')
            ->select('printname','id')->get();
        $heading="Cash Book";    
      return view('accounts/reports/cashbook',['acc'=>$acc,'heading'=>$heading]);
      }
else{
 return redirect('/erp'); 

   }

}
function getallbook(Request $req){
  $book=$req->book;
  $dates=$req->startdate;
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->enddate;
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
     $op =openingaccountdetail::where('acchead',$req->account)
      ->first();
     
       $dreg=regularvoucherentrydetail::where('dates', '<', $nddate)
            ->where('debitcredit', 'debt')
      ->select(DB::raw('sum(amount)as sumdamt'))->first();
       $creg=regularvoucherentrydetail::where('dates', '<', $nddate)
            ->where('debitcredit', 'cred')
      ->select(DB::raw('sum(amount)as sumcamt'))->first();
      if(!empty($op->debit) && !empty($dreg->sumdamt) ){
       $opdsum =$op->debit + $dreg->sumdamt;
  }elseif(empty($op->debit) && !empty($dreg->sumdamt)){
      $opdsum =$dreg->sumdamt;
  }elseif(!empty($op->debit) && empty($dreg->sumdamt)){
     $opdsum =$op->debit;
}else{
  $opdsum ='0';  
}
if(!empty($op->credit) && !empty($creg->sumcamt)){
      $opcsum =$op->credit + $dreg->sumcamt;
  }elseif(!empty($op->credit) && empty($creg->sumcamt)){
  $opcsum =$op->credit ;

  }elseif(empty($op->credit) && !empty($creg->sumcamt)){
   $opcsum =$dreg->sumcamt; 
  }
  else{
    $opcsum ='0'; 
  }
         $reg=regularvoucherentrydetail::leftJoin('regularvoucherentries','regularvoucherentries.id','=','regularvoucherentrydetails.voucherid')
        ->leftJoin('accounts','accounts.id','=','regularvoucherentrydetails.account_name')
        ->where('regularvoucherentrydetails.account_name',$req->account)
        ->whereBetween('regularvoucherentrydetails.dates',array($nddate,$nddate1))
        ->select('accounts.printname','regularvoucherentrydetails.dates','regularvoucherentrydetails.narration','regularvoucherentrydetails.amount','regularvoucherentries.voucher_no','regularvoucherentrydetails.debitcredit')
           ->get();
             $totdebt=regularvoucherentrydetail::where('account_name',$req->account)
              ->where('debitcredit','debt')
             ->select(DB::raw('sum(amount) as sumgrand'))
            ->first();
        $totcred=regularvoucherentrydetail::where('account_name',$req->account)
              ->where('debitcredit','cred')
             ->select(DB::raw('sum(amount) as sumccrd'))
            ->first();
            if(!empty($op->debit)){
          $dtotal = $totdebt->sumgrand + $op->debit;
      }else{
        $dtotal = $totdebt->sumgrand;
      }
      if(!empty($op->credit)){
            $ctotal = $totcred->sumccrd +$op->credit;
        }else
        {
$ctotal = $totcred->sumccrd;
        }
      
           return view('accounts/reports/loadallbook',['opdsum'=>$opdsum,'reg'=>$reg,'book'=>$book,'opcsum'=>$opcsum,'dtotal'=>$dtotal,'ctotal'=>$ctotal]); 
        }
function getpanalysis(Request $req){
  $sinv =DB::table('salesinvoices')
        ->leftJoin('customers','customers.id','=','salesinvoices.customer_id')
        ->select(DB::raw('sum(salesinvoices.totcosts-salesinvoices.rtncost) as sumcost,sum(salesinvoices.grand_total-salesinvoices.isslnrtn_amt) as sumgrand,sum((salesinvoices.grand_total-salesinvoices.isslnrtn_amt)-(salesinvoices.totcosts-salesinvoices.rtncost)) as profit'),'customers.short_name')
                ->where('salesinvoices.is_deleted','0')
                ->where('salesinvoices.is_returned','!=','1')
              ->groupBy('salesinvoices.customer_id','customers.short_name')
                ->get();
         $pinv =DB::table('projectinvoices')
          ->leftJoin('customers','customers.id','=','projectinvoices.customerid')
    ->leftJoin('projectexpenseentrydetails','projectexpenseentrydetails.projectid','=','projectinvoices.projectid')
 
    ->select(DB::raw('sum(projectinvoices.totalamount) as sumgrand,sum(projectexpenseentrydetails.amount) as sumcost'),'customers.short_name')

    ->groupBy('projectinvoices.customerid','customers.short_name')
    ->get();
 return view('accounts/reports/loadprofit',['sinv'=>$sinv,'pinv'=>$pinv]); 

}
function itemprofit(Request $req){
if(session('id')!=""){
         $stock =  itemmaster::orderBy('item','asc')
                     ->get();

             
return view('accounts/reports/profititemwise',['stock'=>$stock]);
            }
     else{
             return redirect('/'); 
         }

}
function postdated(Request $req){
  $rec=receipt::leftJoin('accounts','accounts.id','=','receipts.bank')
         ->where('receipts.bank_date','<',now())
       ->select('receipts.cheque_no','receipts.nettotal','accounts.printname')
     ->get();
  $pay=vendorpayment::leftJoin('accounts','accounts.id','=','vendorpayments.bank')
    ->where('vendorpayments.bank_date','<',now())
       ->select('vendorpayments.cheque_no','vendorpayments.nettotal','accounts.printname')
     ->get();
     return view('accounts/reports/loadcheque',['rec'=>$rec,'pay'=>$pay]);

}
function uninvoiceddo(Request $req){
$do =deliverynote::leftJoin('customers','customers.id','=','deliverynotes.customer')
    ->where('deliverynotes.is_deleted','0')
     ->where('deliverynotes.is_dortn','!=','1')
     ->where('deliverynotes.is_invoiced','!=','1')
     ->select('deliverynotes.dates','deliverynotes.deli_note_no','deliverynotes.executive',
       'customers.short_name')
     ->get();
     return view('accounts/reports/loaduninvoiceddo',['do'=>$do]);

}
function undeliveredso(Request $req){
$so=salesorder::leftJoin('customers','customers.id','=','salesorders.customer')
   ->where('salesorders.is_deleted','0')
   ->where('salesorders.call_for_do','!=','1')
   ->select('salesorders.order_no','customers.short_name','salesorders.dates')
   ->get();
   return view('accounts/reports/undeliveredso',['so'=>$so]);
}
function rsummary(Request $req){
   $sinv =DB::table('salesinvoices')
               ->leftJoin('customers','customers.id','=','salesinvoices.customer_id')
               ->leftJoin('executivecommissions','salesinvoices.id','=','executivecommissions.inv_id')
                ->select(DB::raw('sum(salesinvoices.balance) as sumgrand'),'customers.short_name','executivecommissions.executive')
                ->where('salesinvoices.is_deleted','0')
                ->where('salesinvoices.is_returned','!=','1')
                ->where('salesinvoices.paidstatus','!=','1')
                ->groupBy('salesinvoices.customer_id','customers.short_name','executivecommissions.executive')
                ->get();
                 $pinv =DB::table('projectinvoices')
               ->leftJoin('customers','customers.id','=','projectinvoices.customerid')
                ->select(DB::raw('sum((projectinvoices.bal_amount)) as sumpgrand'),'customers.short_name','projectinvoices.executive')
                ->where('projectinvoices.is_deleted','0')
              
                ->where('projectinvoices.paidstatus','!=','1')
                ->groupBy('projectinvoices.customerid','customers.short_name','projectinvoices.executive')
                ->get();
 return view('accounts/reports/receivablesummary',['sinv'=>$sinv,'pinv'=>$pinv]);

}
function cdetails(Request $req){

   if(session('id')!=""){
      $exce =executive::orderBy('short_name','asc')->get();
      return view('accounts/reports/commidetails',['exce'=>$exce]);
      }
else{
 return redirect('/erp'); 

   }

}
function loadcommission(Request $req){
  $action=$req->executive;
$comm= executivecommission::where('executive',$req->executive)
       ->select('total_amount','totcost','profit','invoice_no','profitpay')
       ->get();
return view('accounts/reports/loadcommission',['comm'=>$comm,'action'=>$action]);

}
function stockdetail(Request $req){
 if(session('id')!=""){
  
return view('accounts/reports/stockdetail');
}else{
 return redirect('/erp'); 

   }

}
function loadstock(Request $req){
 $stock=stockmovement::leftJoin('itemmasters','itemmasters.id','=','stockmovements.item_id')
           ->select(DB::raw('sum((stockmovements.stock_value)) as sumgrand,sum(stockmovements.stockout) as sumout'),'itemmasters.item')
           ->groupBy('stockmovements.item_id','itemmasters.item')
           ->get();
return view('accounts/reports/loadstock',['stock'=>$stock]);
}
function getbankbook(Request $req){
if(session('id')!=""){
      $acc =account::where('category','bank')
            ->select('printname','id')->get();
        $heading ="Bank Book";    
      return view('accounts/reports/cashbook',['acc'=>$acc,'heading'=>$heading]);
      }
else{
 return redirect('/erp'); 

   }
}
function getledger(Request $req){
if(session('id')!=""){
      $acc =account::where('accounttype','a1')
            ->select('printname','id')->get();
        $heading ="Ledger";    
      return view('accounts/reports/cashbook',['acc'=>$acc,'heading'=>$heading]);
      }
else{
 return redirect('/erp'); 

   }    
}
function getcheque(Request $req){
    if(session('id')!=""){
$rec =receipt::where('bank_date','>',now())
      ->get();
$pay =vendorpayment::where('bank_date','>',now())
      ->get();
return view('accounts/reports/chequedetail',['rec'=>$rec,'pay'=>$pay]);
 }
else{
 return redirect('/erp'); 

   }    
}
 function getprofitmovement(Request $req){
   $sdate=$req->sdate;
   $edate=$req->edate;
   $nsdate = Carbon::parse($sdate)->format('Y-m-d');
   $nedate = Carbon::parse($edate)->format('Y-m-d');
    $stocks =  salesinvoicedetail::leftJoin('salesinvoices', function ($join) 
                use($nsdate,$nedate)          {
                $join->on('salesinvoices.id', '=' , 'salesinvoicedetails.inv_id') ;
                $join->whereBetween('salesinvoices.dates',[$nsdate,$nedate]);
                })->leftJoin('itemmasters', function ($joins) 
                         {
                $joins->on('itemmasters.id', '=' , 'salesinvoicedetails.item_id');
                })->select(DB::raw('sum(salesinvoicedetails.rate * salesinvoicedetails.penrtn_qnty) as sumamt,sum(salesinvoicedetails.penrtn_qnty) as  sqout'),'salesinvoicedetails.item_name','salesinvoicedetails.item_code','salesinvoicedetails.unit','itemmasters.cost',
                     DB::raw('MAX(salesinvoicedetails.rate) AS max'),DB::raw('MIN(salesinvoicedetails.rate) AS min'))
                 ->groupBy('salesinvoicedetails.item_id','salesinvoicedetails.item_name','salesinvoicedetails.item_code','salesinvoicedetails.unit','itemmasters.cost')
        ->get();
$stocks1 =  projectmaterialissuedetail::leftJoin('projectmaterialissues', function ($join) 
                use($nsdate,$nedate)          {
                $join->on('projectmaterialissues.id', '=' , 'projectmaterialissuedetails.issue_id') ;
                $join->whereBetween('projectmaterialissues.dates',[$nsdate,$nedate]);
                })->leftJoin('itemmasters', function ($joins) 
                         {
                $joins->on('itemmasters.id', '=' , 'projectmaterialissuedetails.item_id');
                })->select(DB::raw('sum(projectmaterialissuedetails.rate * projectmaterialissuedetails.pen_qnty) as pumamt,sum(projectmaterialissuedetails.pen_qnty) as  pqout'),'projectmaterialissuedetails.item','projectmaterialissuedetails.item_code','projectmaterialissuedetails.unit','itemmasters.cost',
                     DB::raw('MAX(projectmaterialissuedetails.rate) AS maxp'),DB::raw('MIN(projectmaterialissuedetails.rate) AS minp'))
                 ->groupBy('projectmaterialissuedetails.item_id','projectmaterialissuedetails.item','projectmaterialissuedetails.item_code','projectmaterialissuedetails.unit','itemmasters.cost')
        ->get();


return view('accounts/reports/itemprofitreport',['stocks'=>$stocks,'stocks1'=>$stocks1]);


   }
   function getitemhistory(Request $req){
if(session('id')!=""){
         $stock =  itemmaster::orderBy('item','asc')
                     ->get();
 $stocks =  salesinvoicedetail::leftJoin('salesinvoices', function ($join)      {
                $join->on('salesinvoices.id', '=' , 'salesinvoicedetails.inv_id') ;
                $join->whereBetween('salesinvoices.dates',['2021-08-01','2021-08-31']);
                })->leftJoin('deliverynotes', function ($joins) 
                         {
                $joins->on('deliverynotes.id', '=' , 'salesinvoices.deli_note_no');
                })->leftJoin('customers', function ($joinss) 
                         {
                $joinss->on('customers.id', '=' , 'salesinvoices.customer_id');
                })->select(DB::raw('sum(salesinvoicedetails.rate * salesinvoicedetails.penrtn_qnty) as sumamt,sum(salesinvoicedetails.penrtn_qnty) as  sqout'),'salesinvoices.dates','deliverynotes.deli_note_no','salesinvoices.invoice_no','customers.short_name')
                ->where('salesinvoicedetails.item_id','243')
                 ->groupBy('salesinvoices.dates','deliverynotes.deli_note_no','salesinvoices.invoice_no','customers.short_name')
        ->get();
             
return view('accounts/reports/itemhistory',['stock'=>$stock]);
            }
     else{
             return redirect('/'); 
         }


   }
   function gethistorymovement(Request $req){
$sdate=$req->sdate;
   $edate=$req->edate;
   $nsdate = Carbon::parse($sdate)->format('Y-m-d');
   $nedate = Carbon::parse($edate)->format('Y-m-d');
  $stock =  salesinvoicedetail::leftJoin('salesinvoices', function ($join) 
                          {
                $join->on('salesinvoices.id', '=' , 'salesinvoicedetails.inv_id') ;
                
                })->leftJoin('deliverynotes', function ($joins) 
                         {
                $joins->on('deliverynotes.id', '=' , 'salesinvoices.deli_note_no');
                })->leftJoin('customers', function ($joinss) 
                         {
                $joinss->on('customers.id', '=' , 'salesinvoices.customer_id');
                })->select(DB::raw('sum(salesinvoicedetails.rate * salesinvoicedetails.penrtn_qnty) as sumamt,sum(salesinvoicedetails.penrtn_qnty) as  sqout'),'salesinvoices.dates','deliverynotes.deli_note_no','salesinvoices.invoice_no','customers.short_name')
                ->where('salesinvoicedetails.item_id',$req->item)
                ->whereBetween('salesinvoices.dates',[$nsdate,$nedate])
                 ->groupBy('salesinvoices.dates','deliverynotes.deli_note_no','salesinvoices.invoice_no','customers.short_name','salesinvoices.customer_id')
        ->get();
        return view('accounts/reports/loaditemhistory',['stock'=>$stock]);
   }
}
