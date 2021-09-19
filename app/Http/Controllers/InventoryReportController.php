<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\vendor;
use App\Models\businesstype;
use App\Models\account;
use App\Models\salesinvoice;
use App\Models\salesinvoicedetail;
use App\Models\deliverynote;
use App\Models\deliverynotedetail;
use App\Models\salesorder;
use App\Models\projectmaterialrequest;
use App\Models\projectmaterialrequestdetail;
use App\Models\projectdetail;
use App\Models\projectexpenseentry;
use App\Models\projectexpenseentrydetail;
use App\Models\projectmaterialissue;
use App\Models\projectmaterialissuedetail;
use App\Models\projectinvoice;
use App\Models\stockissue;
use App\Models\stockissuedetail;
use App\Models\currentstock;
use App\Models\itemmaster;
use App\Models\store;
use App\Models\stockmovement;
use App\Models\crmform;
use App\Models\purchaseorderdetail;
use App\Models\purchaseorder;
use App\Models\goodsreceivednote;
use App\Models\goodsreceivednotedetail;
use App\Models\executive;
use App\Models\User;
use App\Models\salesenquiry;
use App\Models\salesenquirydetail;
use Carbon\Carbon;
use DB;
class InventoryReportController extends Controller
{
   function customerreport(){

   	if(session('id')!=""){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
            $custs = customer::all();
           return view('inventory/masters/customerreport',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }
   }
   function vendorreport(){

   	if(session('id')!=""){
        ///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
            $vends = vendor::all();
           return view('inventory/masters/vendorreport',['vends'=>$vends,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }
   }
   function vendorview($id){
if(session('id')!=""){
                $vend= vendor::leftJoin('accounts', function($join) {
      $join->on('vendors.account', '=', 'accounts.id');
         })->where('vendors.id',$id)
            ->select('vendors.*','accounts.printname')->first();

  $btypes = businesstype::orderBy('btype','Asc')->get();
  $vendors = vendor::orderBy('vendor','Asc')->get();
  $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->where('parentid','15')
                   ->orderBy('printname','Asc')->get();
     



///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////              
  return view('/inventory/masters/vendoredit',['btypes'=>$btypes,'vendors'=>$vendors,'allaccounts'=>$allaccounts,'vend'=>$vend,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

   }

   function customerview (){
     if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
       $btypes=businesstype::select('id','btype')
             ->where('active','1')
              ->get();
        $custs =customer::orderBy('name','Asc')->get();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->orderBy('printname','Asc')->get();
        $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('id',8)
                   ->orderBy('printname','Asc')->get();
                   $acccat ='debtor';
                   $status ='acccust';
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
      return view('admin/inventory/customer',['btypes'=>$btypes,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status,'custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
    }
   else{
 return redirect('/'); 
} 
}
function invoicereport(){
        if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
             $custs = salesinvoice::with('salesinvoicedetail')->leftJoin('customers', function($join) {
      $join->on('salesinvoices.customer_id', '=', 'customers.id');
         })->leftJoin('deliverynotes', function($joins) {
      $joins->on('salesinvoices.deli_note_no', '=', 'deliverynotes.id');
         })->where('salesinvoices.is_deleted','0')
             ->select('salesinvoices.id','salesinvoices.invoice_no','customers.name','deliverynotes.deli_note_no','salesinvoices.grand_total','salesinvoices.dates','salesinvoices.isslnrtn_amt','salesinvoices.customer_id')->get();
           return view('inventory/sales/salesinvoicereport',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }
   }
   function sageing(){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
    $custs =customer::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('inventory/sales/salesageing',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]); 
   }
   function getsageing(Request $req){

        $custs1 = salesinvoice::with('salesinvoicedetail')->leftJoin('deliverynotes', function($joins) {
      $joins->on('salesinvoices.deli_note_no', '=', 'deliverynotes.id');
         })->where('salesinvoices.is_deleted','0')
    ->where('salesinvoices.paidstatus','!=','1')
    ->where('salesinvoices.customer_id',$req->customer)
    ->select('salesinvoices.id','salesinvoices.invoice_no','deliverynotes.deli_note_no','salesinvoices.grand_total','salesinvoices.dates','salesinvoices.isslnrtn_amt','salesinvoices.collected_amount','salesinvoices.balance','salesinvoices.po_number')->get();
     $proinv = projectinvoice::with('projectinvoicedetail')->leftJoin('projectdetails', function($join) {
      $join->on('projectinvoices.projectid', '=', 'projectdetails.id');
         })->where('projectinvoices.is_deleted','0')
    ->where('projectinvoices.paidstatus','!=','1')
    ->where('projectinvoices.customerid',$req->customer)
    ->select('projectinvoices.id','projectinvoices.projinv_no','projectdetails.customer_po','projectinvoices.totalamount','projectinvoices.dates','projectinvoices.collected_amount','projectinvoices.bal_amount')->get();
    $cusss = customer::where('id',$req->customer)->first();
return view('inventory/sales/allsalesageing',['custs1'=>$custs1,'cusss'=>$cusss,'proinv'=>$proinv]); 
   }
   function ageing(Request $req){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
         
           ///////////////Layout Section Calculation Part End/////////////////
 $custs =customer::select('id','short_name')->orderBy('short_name','Asc')->get();
   return view('inventory/sales/ageing',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]); 

   }
   function getageing(Request $req){

        $custs1 = salesinvoice::with('salesinvoicedetail')->leftJoin('deliverynotes', function($joins) {
      $joins->on('salesinvoices.deli_note_no', '=', 'deliverynotes.id');
         })->where('salesinvoices.is_deleted','0')
    ->where('salesinvoices.paidstatus','!=','1')
    ->where('salesinvoices.customer_id',$req->customer)
    ->select('salesinvoices.id','salesinvoices.invoice_no','deliverynotes.deli_note_no','salesinvoices.grand_total','salesinvoices.dates','salesinvoices.isslnrtn_amt','salesinvoices.collected_amount','salesinvoices.balance','salesinvoices.po_number')->get();
     $proinv = projectinvoice::with('projectinvoicedetail')->leftJoin('projectdetails', function($join) {
      $join->on('projectinvoices.projectid', '=', 'projectdetails.id');
         })->where('projectinvoices.is_deleted','0')
    ->where('projectinvoices.paidstatus','!=','1')
    ->where('projectinvoices.customerid',$req->customer)
    ->select('projectinvoices.id','projectinvoices.projinv_no','projectdetails.customer_po','projectinvoices.totalamount','projectinvoices.dates','projectinvoices.collected_amount','projectinvoices.bal_amount')->get();
    $cusss = customer::where('id',$req->customer)->first();
return view('inventory/sales/allageing',['custs1'=>$custs1,'cusss'=>$cusss,'proinv'=>$proinv]);
   }
   function doreport(Request $req){
    if(session('id')!=""){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
            
             if(session('utype')=='Admin' || session('utype')=='Subadmin'){
             $execus = executive::select('id','short_name')
                       ->orderBy('short_name','asc')
                         ->get();
                       }else{
                $execus = User::select('executive')
                          ->where('login_name',session('name'))->get();
                       }
           return view('inventory/sales/doreport',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'execus'=>$execus]);
            }
     else{
             return redirect('/'); 
         }

   }
   function materialreport(Request $req){
if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
             $custs = projectmaterialrequest::with('projectmaterialrequestdetail')->leftJoin('projectdetails', function($join) {
      $join->on('projectmaterialrequests.project_id', '=', 'projectdetails.id');
         })
             ->select('projectmaterialrequests.*','projectdetails.project_code')->get();
           return view('inventory/project/matreport',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }


   }
   function expensereport(Request $req){
    if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
               $custs =customer::select('id','short_name')->orderBy('short_name','Asc')->get();
             
           return view('inventory/project/expensereport',['custs'=>$custs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

   }
   function getexpense(Request $req){
    
      $exppp = projectexpenseentrydetail::with('projectexpenseentry:id,dates,entry_no')
                   ->where('customerid',$req->customer)->get();
                $cuuus =customer::select('name')
                        ->find($req->customer);
             return view('inventory/project/projectexppreport',['exppp'=>$exppp,'cuuus'=>$cuuus]);
   }
   function sissuereport(Request $req){
 if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
               $stock =  stockissue::with('stockissuedetail')->where('is_deleted','0')
                     ->get();
                     $mat =  projectmaterialissue::with('projectmaterialissuedetail')->where('is_deleted','0')
                     ->get();
           return view('inventory/stock/issuereport',['stock'=>$stock,'mat'=>$mat,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

   }
   function curstockreport(Request $req){
    if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
         $stock =  currentstock::leftJoin('itemmasters', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('bal_qnty','!=','0')
         ->select('itemmasters.cost','stores.locationname','currentstocks.batch','currentstocks.bal_qnty','itemmasters.item','itemmasters.code','itemmasters.basic_unit')
         ->orderBy('itemmasters.item','asc')
                     ->get();
                    
           return view('inventory/stock/curstockreport',['stock'=>$stock,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }
   }
   function stockasonreport(Request $req){
    if(session('id')!=""){
        



///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
                    
           return view('inventory/stock/stockasonmain',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

   }
   function loadstockason(Request $req){
    $sdate =$req->sdate;
     $edate =$req->edate;
     $nsdate = Carbon::parse($sdate)->format('Y-m-d');
   $nedate = Carbon::parse($edate)->format('Y-m-d');
 $stock =  currentstock::leftJoin('itemmasters', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('bal_qnty','!=','0')
         ->select('itemmasters.cost','stores.locationname','currentstocks.batch','currentstocks.bal_qnty','itemmasters.item','itemmasters.code','itemmasters.basic_unit')
         ->whereBetween('currentstocks.created_at',array($nsdate,$nedate))
         ->orderBy('itemmasters.item','asc')
                     ->get();
                    
           return view('inventory/stock/stockasonreport',['stock'=>$stock]);


   }
   function stockmovereport(Request $req){
if(session('id')!=""){
         $stock =  itemmaster::orderBy('item','asc')
                     ->get();
            



///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////        
           return view('inventory/stock/stockmovementreportmain',['stock'=>$stock,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

   }
   function getmovereport(Request $req){
      $sdate=$req->sdate;
     $edate=$req->edate;
 $nsdate = Carbon::parse($sdate)->format('Y-m-d');
   $nedate = Carbon::parse($edate)->format('Y-m-d');
  $stocks =  stockmovement::where('item_id',$req->item)
          ->whereBetween('voucher_date',[$nsdate,$nedate])
        ->get();
         $curr =   currentstock::groupBy('item_id')
   ->selectRaw('sum(bal_qnty) as sum')
   ->where('item_id',$req->item)
   ->first(); 
     $items =   itemmaster::select('code','basic_unit','item')
   ->where('id',$req->item)
   ->first();

return view('inventory/stock/stockmovementreport',['stocks'=>$stocks,'curr'=>$curr,'items'=>$items]);


   }
   function nilreport(Request $req){
if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
         $stock =  currentstock::leftJoin('itemmasters', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->where('currentstocks.bal_qnty','0')
                     ->get();
                    
           return view('inventory/stock/nilstockreport',['stock'=>$stock,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }


   }
function getcrmreport(Request $req){
if(session('id')!=""){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
         if(session('utype')=="Admin"){
          $datas =crmform::with('crmdetail')
              ->orderBy('dates','asc')->get();
         }else{
      $datas =crmform::with('crmdetail')
              ->where('executive',session('exec'))->orderBy('dates','asc')->get();
                 }   
           return view('inventory/crm/crmreport',['datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

}
function grnreport(Request $req){
if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
      $datas =purchaseorder::with('purchaseorderdetail')->leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->leftJoin('projectdetails', function($joins) {
      $joins->on('purchaseorders.project_code', '=', 'projectdetails.id');
         })->select('purchaseorders.*','vendors.vendor','projectdetails.project_code')->where('purchaseorders.is_grned','!=','1')
           ->orderBy('purchaseorders.id','desc')->get();
                    
           return view('inventory/purchase/pendinggrnreport',['datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

}
function poreport(Request $req){
if(session('id')!=""){




///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
      $datas =purchaseorder::with('purchaseorderdetail')->leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->leftJoin('projectdetails', function($joins) {
      $joins->on('purchaseorders.project_code', '=', 'projectdetails.id');
         })->select('purchaseorders.*','vendors.vendor','projectdetails.project_code')
           ->orderBy('purchaseorders.id','desc')->get();
                    
           return view('inventory/purchase/poreport',['datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

}
function mgrnreport(Request $req){
  if(session('id')!=""){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
      $datas =goodsreceivednote::with('goodsreceivednotedetail')->leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.*','vendors.vendor','purchaseorders.po_no')
           ->orderBy('goodsreceivednotes.id','desc')->get();
                    
           return view('inventory/purchase/grnreport',['datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }  
}
function stockLedger(Request $req){
if(session('id')!=""){
  ///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
                    
           return view('inventory/stock/stockledger',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         } 


}
function loadstockledger(Request $req){
      $dates=$req->startdate;
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->enddate;
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
    $datas =stockmovement::leftJoin('itemmasters', function($join) {
      $join->on('stockmovements.item_id', '=', 'itemmasters.id');
         })->select(DB::raw('SUM(stockmovements.quantity) AS qtyin,SUM(stockmovements.qntyout) AS qtyout,SUM(stockmovements.stock_value) AS sin,SUM(stockmovements.stockout) AS sout'),'itemmasters.item','itemmasters.code','itemmasters.basic_unit','itemmasters.cost')
    ->whereBetween('stockmovements.voucher_date',array($nddate,$nddate1))
   ->groupBy('stockmovements.item_id','itemmasters.item','itemmasters.code','itemmasters.basic_unit','itemmasters.cost')
  ->get();
   return view('inventory/stock/loadstockledger',['datas'=>$datas]);
}
function pinvreport(Request $req){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
$datas =projectinvoice::where('is_deleted','0')
      ->orderBy('id','desc')->get();
 return view('inventory/project/projinvoicereport',['datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);

}
function loaddoreport(Request $req){
  $dates=$req->startdate;
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->enddate;
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $custs = deliverynote::with('deliverynotedetail')->leftJoin('customers', function($join) {
      $join->on('deliverynotes.customer', '=', 'customers.id');
         })->leftJoin('salesorders', function($joins) {
      $joins->on('salesorders.id', '=', 'deliverynotes.so_no');
         })->where('deliverynotes.is_deleted','0')
          ->whereBetween('deliverynotes.dates',[$nddate,$nddate1])
          ->where('deliverynotes.executive',$req->executive)
             ->select('deliverynotes.id','deliverynotes.deli_note_no','customers.name','salesorders.order_no','deliverynotes.dates','deliverynotes.customer','deliverynotes.so_no')->get();

return view('inventory/sales/loaddoreport',['custs'=>$custs]);
}
   function enquiryreport(Request $req){
    if(session('id')!=""){
///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
           ///////////////Layout Section Calculation Part End/////////////////
            
             if(session('utype')=='Admin' || session('utype')=='Subadmin'){
             $execus = executive::select('id','short_name')
                       ->orderBy('short_name','asc')
                         ->get();
                       }else{
                $execus = User::select('executive')
                          ->where('login_name',session('name'))->get();
                       }
           return view('inventory/sales/enquiryreport',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'execus'=>$execus]);
            }
     else{
             return redirect('/'); 
         }

   }
   function loadenqreport(Request $req){
  $dates=$req->startdate;
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->enddate;
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $custs = salesenquiry::with('salesenquirydetails')->leftJoin('customers', function($join) {
      $join->on('salesenquiries.customer', '=', 'customers.id');
         })->whereNull('salesenquiries.is_deleted')
          ->whereBetween('salesenquiries.dates',[$nddate,$nddate1])
          ->where('salesenquiries.executive',$req->executive)
             ->select('salesenquiries.id','salesenquiries.enq_no','customers.name','salesenquiries.dates')->get();

return view('inventory/sales/loadenqreport',['custs'=>$custs]);

   }
   
}
