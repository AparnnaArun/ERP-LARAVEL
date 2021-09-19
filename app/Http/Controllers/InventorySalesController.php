<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\unit;
use App\Models\itemmaster;
use App\Models\businesstype;
use App\Models\executive;
use App\Models\customer;
use App\Models\customerexecutivedetail;
use App\Models\currentstock;
use App\Models\privilege;
use App\Models\vouchergeneration;
use App\Models\salesenquiry;
use App\Models\salesenquirydetail;
use App\Models\currency;
use App\Models\salesquotation;
use App\Models\salesquotationdetail;
use App\Models\proformainvoice;
use App\Models\proformainvoicedetail;
use App\Models\salesorder;
use App\Models\salesorderdetail;
use App\Models\header;
use App\Models\projectdetail;
use App\Models\deliverynote;
use App\Models\deliverynotedetail;
use App\Models\stockmovement;
use App\Models\store;
use App\Models\doreturn;
use App\Models\deliveryreturndetail;
use App\Models\salesinvoice;
use App\Models\projectmaterialrequest;
use App\Models\projectinvoice;

use PDF;
use Validator;
use Carbon\Carbon;
class InventorySalesController extends Controller
{
    function getenquiry(){
    
       $priv=privilege::select('pageid','user')
           ->where('pageid','49')
           ->where('user',session('id'))
           ->count();
    	   	if(session('id')!="" && ($priv >0)){
        
    	   		//////// For Popups/////////////
    	   		$units = unit::where('active','1')
    	   		        ->select('shortname')
    	   		        ->orderBy('shortname','Asc')
    	   		        ->get();
    	   	    $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','49')
              ->select('slno','constants')->first();  
  $slno=salesenquiry::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesenquiry::leftJoin('customers', function($join) {
      $join->on('salesenquiries.customer', '=', 'customers.id');
         })->select('salesenquiries.id','salesenquiries.enq_no','salesenquiries.dates','customers.name','salesenquiries.is_deleted','salesenquiries.call_for_quote')
->orderBy('salesenquiries.id','desc')
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
return view('inventory/sales/enquiry',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
    }
function addnewitem(Request $req){
 $code=$req->get('code');
 $slno=$req->get('slno');
 $name=$req->get('name');
 $unit=$req->get('unit');
 $description = $req->get('description');


 if(!empty($slno && $unit && $name)){
  itemmaster::updateOrCreate(
  ['code'=>$code,'item'=>$name,],
['localslno'=>$slno,'is_local'=>'1','description'=>$description,'basic_unit'=>$unit,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  return '<div class="alert alert-success">Data updated successfully</div>';
 
}
else{
	return '<div class="alert alert-danger">Sorry, Something went wrong</div>';
    }

}
function addnewcustomer(Request $req){
 $name=$req->get('name');
 $shortname=$req->get('shortname');
 $bustype=$req->get('bustype');
 $executive=$req->get('executive');
if(!empty($name && $shortname && $executive)){
  $cus = customer::updateOrCreate(['short_name'=>$shortname,],
             ['name'=>$name,'businesstype'=>$bustype,'active'=>'1',
             'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),
             'wdate'=>session('wdate'),'createdby'=>session('name')]);
  customerexecutivedetail::create(['customerid'=>$cus->id,'executive'=>$executive,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 return '<div class="alert alert-success">Data updated successfully</div>';
 
     }
else{
	return '<div class="alert alert-danger">Sorry, Something went wrong</div>';
    }


}


function getitemdetails(Request $req){
     $itemid = $req->itemid;
      $item = itemmaster::select('minimum_stock','maximum_stock','reorder_level')
          ->where('id',$itemid)->first();
    $curitem = currentstock::where('item_id',$itemid)->sum('bal_qnty');
 return view('inventory/sales/itemdetailedview',['item'=>$item,'curitem'=>$curitem]);          


}
function itemstogrid(Request $req){
  $rowCount = $req->rowCount;
   $itemid = $req->itemid;
  $item = itemmaster::find($itemid);
  $gridid =$req->gridid;
  
return view('inventory/sales/itemsgridsalesenqview',['item'=>$item,'rowCount'=>$rowCount]);

}
function createenquiry(request $req){
  $validator =  $req ->validate([
                'enq_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],
   [ 'enq_no.required'    => 'Sorry,Please generate an enquiry number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = salesenquiry::updateOrCreate(
  ['enq_no'=>$req->input('enq_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'enq_ref'=>$req->input('enq_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'deli_info'=>$req->input('deli_info'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'executive'=>$req->input('executive')]);
  if(isset($enquiry)){
      $item_id=$req->item_id;
      $code = $req->code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $description=$req->description;
        $quantity=$req->quantity;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =salesenquirydetail::Create(
  ['item_id'=>$item_id[$i],'enq_id'=>$enquiry->id,
  'code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'description'=>$description[$i],
  'quantity'=>$quantity[$i],
  'balqnty'=>$quantity[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/enquiry');

  }

}
function enquiryedit($id){
  $priv=privilege::select('pageid','user')
           ->where('pageid','49')
           ->where('user',session('id'))
           ->count();
      if(session('id')!="" && ($priv >0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','49')
              ->select('slno','constants')->first();  
  $slno=salesenquiry::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesenquiry::leftJoin('customers', function($join) {
      $join->on('salesenquiries.customer', '=', 'customers.id');
         })->select('salesenquiries.id','salesenquiries.enq_no','salesenquiries.dates','customers.name','salesenquiries.is_deleted','salesenquiries.call_for_quote')
->orderBy('salesenquiries.id','desc')
          ->get();
 $enqq =    salesenquiry::with('salesenquirydetails')
             ->where('salesenquiries.id',$id)->first();
  



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
return view('inventory/sales/enquiryedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'enqq'=>$enqq,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function editsenquirys(Request $req){
  $validator =  $req ->validate([
                'enq_no'=>'required',
                
                'customer'=>'required',
                'quantity'=>'required'],
   [   'enq_no.required'    => 'Sorry,Please generate an enquiry number, Thank You.',
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = salesenquiry::where('id',$req->input('id'))
             ->update(['enq_no'=>$req->input('enq_no'),'dates'=>$nddate,'enq_ref'=>$req->input('enq_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'deli_info'=>$req->input('deli_info'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($enquiry)){
      
      $sid=$req->sid;
      $quantity=$req->quantity;
      $count =count($sid);
for ($i=0; $i < $count; $i++){
  $bnd =salesenquirydetail::where('id',$sid[$i])
  ->update(['quantity'=>$quantity[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

  }

  }
  function getsalesquote(){
  $priv=privilege::select('pageid','user')
           ->where('pageid','42')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','42')
              ->select('slno','constants')->first();  
  $slno=salesquotation::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesquotation::leftJoin('customers', function($join) {
      $join->on('salesquotations.customer', '=', 'customers.id');
         })->select('salesquotations.id','salesquotations.qtn_no','salesquotations.dates','customers.name')
->orderBy('salesquotations.id','desc')
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
return view('inventory/sales/salesquotation',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
    }
    function itemstogridsqoute(Request $req){
  $rowCount = $req->rowCount;
  $itemid = $req->itemid;
  $item = itemmaster::find($itemid);
  $gridid =$req->gridid;
  
return view('inventory/sales/itemsgridsalesquoteview',['item'=>$item,'rowCount'=>$rowCount]);

    }
function createsalesquote(Request $req){
   $validator =  $req ->validate([
                'qtn_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'qtn_no.required'    => 'Sorry,Please generate an Quote number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $quote = salesquotation::updateOrCreate(
  ['qtn_no'=>$req->input('qtn_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'qtn_ref'=>$req->input('qtn_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'validity'=>$req->input('validity'),'currency'=>$req->input('currency'),'from_enquiry'=>$req->input('from_enquiry'),'deli_info'=>$req->input('deli_info'),'discount_total'=>$req->input('discount_total'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'paymentinfo'=>$req->input('paymentinfo')]);
  if(isset($quote)){
    $enqid=$req->enqid;
    $menqid=$req->menqid;
      $item_id=$req->item_id;
      $code=$req->code;
        $item_name=$req->item;
        $unit=$req->unit;
        $quantity=$req->quantity;
        $rate=$req->rate;
        $discount=$req->discount;
        $amount=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =salesquotationdetail::Create(
  ['item_id'=>$item_id[$i],
  'qtn_id'=>$quote->id,'enq_id'=>$enqid[$i],
  'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
 
 
 } 
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/sales-quotation');

  }


    }
function enqdetails(Request $req){
    $customer = $req->customer;
   $senq = salesenquiry::where('customer',$customer)
                ->whereNull('is_deleted')
                ->whereNull('call_for_quote')
                 ->select('id','enq_no')->get();
return view('inventory/sales/salesenqviewforquote',['senq'=>$senq]);

}
function enqdetailsfromcart(Request $req){
    $enqno = $req->enqno;
     $eenqs = salesenquirydetail::where('balqnty','!=','0')
              ->whereIn('enq_id',$enqno)->get();
return view('inventory/sales/ennnqqview',['eenqs'=>$eenqs]);
}
function printsalesquote(){
 $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = salesquotation::with('salesquotationdetail')->leftJoin('customers', function($join) {
      $join->on('salesquotations.customer', '=', 'customers.id');
         })->select('salesquotations.id','salesquotations.qtn_no','salesquotations.dates','salesquotations.currency','salesquotations.qtn_ref','salesquotations.enq_ref','customers.name','customers.address','customers.contactperson','salesquotations.total','salesquotations.discount_total','salesquotations.net_total','salesquotations.deli_info','salesquotations.remarks','salesquotations.paymentinfo','salesquotations.designation','salesquotations.validity','salesquotations.authority')
->orderBy('salesquotations.id','desc')
->take('1')
          ->first();
  //return view('inventory/sales/salesquote_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/sales/salesquote_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('SalesQuotation.pdf');
}
function editquote($id, Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','42')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////

 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesquotation::leftJoin('customers', function($join) {
      $join->on('salesquotations.customer', '=', 'customers.id');
         })->select('salesquotations.id','salesquotations.qtn_no','salesquotations.dates','customers.name')
->orderBy('salesquotations.id','desc')
          ->get();
  $quote =   salesquotation::with('salesquotationdetail')
          ->find($id);  




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
return view('inventory/sales/editsalesquotation',['units'=>$units,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'datas'=>$datas,'currency'=>$currency,'quote'=>$quote,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function editsquotes(Request $req){
$validator =  $req ->validate([
                'qtn_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'qtn_no.required'    => 'Sorry,Please generate an Quote number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
$dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $quote = salesquotation::where('id',$req->input('id'))
  ->update(['qtn_no'=>$req->input('qtn_no'),
'dates'=>$nddate,'qtn_ref'=>$req->input('qtn_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'validity'=>$req->input('validity'),'currency'=>$req->input('currency'),'from_enquiry'=>$req->input('from_enquiry'),'deli_info'=>$req->input('deli_info'),'discount_total'=>$req->input('discount_total'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'paymentinfo'=>$req->input('paymentinfo')]);
  if(isset($quote)){
    $enqid=$req->enqid;
    $menqid=$req->menqid;
      $item_id=$req->item_id;
      $code=$req->code;
        $item_name=$req->item;
        $unit=$req->unit;
        $quantity=$req->quantity;
        $rate=$req->rate;
        $discount=$req->discount;
        $amount=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =salesquotationdetail::where('id',$menqid[$i])
  ->update(['item_id'=>$item_id[$i],
  'qtn_id'=>$req->input('id'),'enq_id'=>$enqid[$i],
'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);

 
 } 
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

  }
}
function printeditquote($id){
   $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
   $data = salesquotation::with('salesquotationdetail')->leftJoin('customers', function($join) {
      $join->on('salesquotations.customer', '=', 'customers.id');
         })->select('salesquotations.id','salesquotations.qtn_no','salesquotations.dates','salesquotations.currency','salesquotations.qtn_ref','salesquotations.enq_ref','customers.name','customers.address','customers.contactperson','salesquotations.total','salesquotations.discount_total','salesquotations.net_total','salesquotations.deli_info','salesquotations.remarks','salesquotations.paymentinfo','salesquotations.designation','salesquotations.validity','salesquotations.authority')
->where('salesquotations.id',$id)
->first();
  //return view('inventory/sales/salesquote_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/sales/editquote_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('SalesQuotation.pdf');

}
function deleteenquiry($id,Request $req){
 $data = salesenquiry::where('id',$id)
 ->update(['is_deleted'=>'1']);
 $req->session()->flash('status', 'Successfully deleted the enquiry!');
return redirect()->back();

}
function proinvoice(){

  $priv=privilege::select('pageid','user')
           ->where('pageid','42')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','151')
              ->select('slno','constants')->first();  
  $slno=proformainvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    proformainvoice::leftJoin('customers', function($join) {
      $join->on('proformainvoices.customer', '=', 'customers.id');
         })->select('proformainvoices.id','proformainvoices.pro_no','proformainvoices.dates','customers.name')
->orderBy('proformainvoices.id','desc')
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
return view('inventory/sales/proinvoice',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
    }
    function createproinvoice(Request $req){
       $validator =  $req ->validate([
                'pro_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'pro_no.required'    => 'Sorry,Please generate an Quote number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $proid = proformainvoice::updateOrCreate(
  ['pro_no'=>$req->input('pro_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'customer_ref'=>$req->input('customer_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'paymentmode'=>$req->input('paymentmode'),'currency'=>$req->input('currency'),'from_quote'=>$req->input('from_quote'),'deli_info'=>$req->input('deli_info'),'discount_total'=>$req->input('discount_total'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'paymentinfo'=>$req->input('paymentinfo')]);
  if(isset($proid)){
     $idd =$proid->id;
    $enqid=$req->enqid;
    $menqid=$req->menqid;
    $item_id=$req->item_id;
    $code=$req->code;
    $item_name=$req->item;
        $unit=$req->unit;
        $quantity=$req->quantity;
        $rate=$req->rate;
        $discount=$req->discount;
        $amount=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =proformainvoicedetail::Create(
  ['item_id'=>$item_id[$i],'pro_id'=>$idd,
  'qtnd_id'=>$enqid[$i],
  'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
} 
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/proforma-invoice');

  }

    } 
    function quotedetails(Request $req){
     $customer = $req->customer;
    $senq = salesquotation::where('customer',$customer)
                ->where('is_deleted','0')
                ->select('id','qtn_no')->get();
return view('inventory/sales/squoteviewforquote',['senq'=>$senq]);

}
function quotefromcart(Request $req){
    $enqno = $req->enqno;
      $eenqs = salesquotationdetail::where('quantity','!=','0')
              ->whereIn('qtn_id',$enqno)->get();
return view('inventory/sales/quoteview',['eenqs'=>$eenqs]);

}
function printproinvoice(){
 $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = proformainvoice::with('proformainvoicedetail')->leftJoin('customers', function($join) {
      $join->on('proformainvoices.customer', '=', 'customers.id');
         })->select('proformainvoices.id','proformainvoices.pro_no','proformainvoices.dates','proformainvoices.currency','proformainvoices.customer_ref','customers.name','customers.address','proformainvoices.total','proformainvoices.discount_total','proformainvoices.net_total','proformainvoices.deli_info','proformainvoices.remarks','proformainvoices.paymentinfo','proformainvoices.designation','proformainvoices.authority')
->orderBy('proformainvoices.id','desc')
->take('1')
          ->first();
//return view('inventory/sales/proinv_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/sales/proinv_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('ProformaInvoice.pdf');
}
function editproinvoice($id){

  $priv=privilege::select('pageid','user')
           ->where('pageid','42')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////

 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    proformainvoice::leftJoin('customers', function($join) {
      $join->on('proformainvoices.customer', '=', 'customers.id');
         })->select('proformainvoices.id','proformainvoices.pro_no','proformainvoices.dates','customers.name')
->orderBy('proformainvoices.id','desc')
          ->get();

  $proinv =   proformainvoice::with('proformainvoicedetail')
          ->find($id); 
   



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
return view('inventory/sales/proinvoiceedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'datas'=>$datas,'currency'=>$currency,'proinv'=>$proinv,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function printeditproinv($id){
  $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = proformainvoice::with('proformainvoicedetail')->leftJoin('customers', function($join) {
      $join->on('proformainvoices.customer', '=', 'customers.id');
         })->select('proformainvoices.id','proformainvoices.pro_no','proformainvoices.dates','proformainvoices.currency','proformainvoices.customer_ref','customers.name','customers.address','proformainvoices.total','proformainvoices.discount_total','proformainvoices.net_total','proformainvoices.deli_info','proformainvoices.remarks','proformainvoices.paymentinfo','proformainvoices.designation','proformainvoices.authority')
->where('proformainvoices.id',$id)
->first();
//return view('inventory/sales/proinv_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/sales/proinv_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('ProformaInvoice.pdf');

}
function editsproinvoices(Request $req){
       $validator =  $req ->validate([
                'pro_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'pro_no.required'    => 'Sorry,Please generate an Quote number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $proid = proformainvoice::where('id',$req->input('id'))
  ->update(['pro_no'=>$req->input('pro_no'),
'dates'=>$nddate,'customer_ref'=>$req->input('customer_ref'),'customer'=>$req->input('customer'),'authority'=>$req->input('authority'),'designation'=>$req->input('designation'),'paymentmode'=>$req->input('paymentmode'),'currency'=>$req->input('currency'),'from_quote'=>$req->input('from_quote'),'deli_info'=>$req->input('deli_info'),'discount_total'=>$req->input('discount_total'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'paymentinfo'=>$req->input('paymentinfo')]);
  if(isset($proid)){
    
    $enqid=$req->enqid;
    $menqid=$req->menqid;
    $item_id=$req->item_id;
    $code=$req->code;
    $item_name=$req->item;
        $unit=$req->unit;
        $quantity=$req->quantity;
        $rate=$req->rate;
        $discount=$req->discount;
        $amount=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =proformainvoicedetail::where('id',$menqid[$i])
  ->update(['item_id'=>$item_id[$i],
    'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
} 
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

  }


}
function salesorder(){

  $priv=privilege::select('pageid','user')
           ->where('pageid','41')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','41')
              ->select('slno','constants')->first();  
  $slno=salesorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesorder::leftJoin('customers', function($join) {
      $join->on('salesorders.customer', '=', 'customers.id');
         })->select('salesorders.id','salesorders.order_no','salesorders.dates','customers.name','salesorders.call_for_do')
->orderBy('salesorders.id','desc')
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
return view('inventory/sales/sorder',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }


}
function createsorder(Request $req){
$validator =  $req ->validate([
                'order_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'order_no.required'    => 'Sorry,Please generate an Order number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $purdate=$req->input('purodr_date');
  $npurdate = Carbon::parse($purdate)->format('Y-m-d');
  $quote = salesorder::updateOrCreate(
  ['order_no'=>$req->input('order_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'purodr_date'=>$npurdate,'reference'=>$req->input('reference'),'customer'=>$req->input('customer'),'fob_point'=>$req->input('fob_point'),'currency'=>$req->input('currency'),'ship_to'=>$req->input('ship_to'),'order_from'=>$req->input('order_from'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'total'=>$req->input('total'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'net_total'=>$req->input('net_total'),'deli_info'=>$req->input('deli_info'),'payment_terms'=>$req->input('payment_terms'),'remarks'=>$req->input('remarks'),'dispatch_details'=>$req->input('dispatch_details'),'approved_by'=>$req->input('approved_by'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($quote)){
    $enqid=$req->enqid;
    $menqid=$req->menqid;
    $item_id=$req->item_id;
    $code=$req->code;
    $item_name=$req->item;
    $unit=$req->unit;
    $quantity=$req->quantity;
    $rate=$req->rate;
    $discount=$req->discount;
    $amount=$req->amount;
    $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =salesorderdetail::Create(
  ['item_id'=>$item_id[$i],
  'order_id'=>$quote->id,'dnd_id'=>$enqid[$i],
  'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'bal_qnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
 
 
 } 
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/sales-order');

  }
}
function editsorder($id){

  $priv=privilege::select('pageid','user')
           ->where('pageid','41')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','41')
              ->select('slno','constants')->first();  
  $slno=salesorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    salesorder::leftJoin('customers', function($join) {
      $join->on('salesorders.customer', '=', 'customers.id');
         })->select('salesorders.id','salesorders.order_no','salesorders.dates','customers.name','salesorders.call_for_do')
->orderBy('salesorders.id','desc')
          ->get();
  $sodr = salesorder::with('salesorderdetail')->find($id);
    



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
return view('inventory/sales/sorderedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'sodr'=>$sodr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }  
}
function editssorders(Request $req){
  $validator =  $req ->validate([
                'order_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'order_no.required'    => 'Sorry,Please generate an Order number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $purdate=$req->input('purodr_date');
  $npurdate = Carbon::parse($purdate)->format('Y-m-d');
  $quote = salesorder::where('id',$req->input('id'))
 ->update(['order_no'=>$req->input('order_no'),
 'dates'=>$nddate,'purodr_date'=>$npurdate,'reference'=>$req->input('reference'),'customer'=>$req->input('customer'),'fob_point'=>$req->input('fob_point'),'currency'=>$req->input('currency'),'ship_to'=>$req->input('ship_to'),'order_from'=>$req->input('order_from'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'total'=>$req->input('total'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'net_total'=>$req->input('net_total'),'deli_info'=>$req->input('deli_info'),'payment_terms'=>$req->input('payment_terms'),'remarks'=>$req->input('remarks'),'dispatch_details'=>$req->input('dispatch_details'),'approved_by'=>$req->input('approved_by'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($quote)){
    
    $menqid=$req->main;
      $item_id=$req->item_id;
      $code=$req->code;
        $item_name=$req->item;
        $unit=$req->unit;
        $quantity=$req->quantity;
        $rate=$req->rate;
        $discount=$req->discount;
        $amount=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =salesorderdetail::where('id',$menqid[$i])
  ->update(['item_id'=>$item_id[$i],
  'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'quantity'=>$quantity[$i],
  'bal_qnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'discount'=>$discount[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
 
 
 } 
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}
}
function delivery(){

  $priv=privilege::select('pageid','user')
           ->where('pageid','30')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','30')
              ->select('slno','constants')->first();  
  $slno=deliverynote::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
         ->get();
$pros = projectdetail::select('id', 'project_code')
        ->where('is_deleted','!=','1')
        ->where('is_completed','!=','1')
        ->orderBy('id','desc')
        ->get();
  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    deliverynote::leftJoin('customers', function($join) {
      $join->on('deliverynotes.customer', '=', 'customers.id');
         })->leftJoin('salesorders', function($joins) {
      $joins->on('deliverynotes.so_no', '=', 'salesorders.id');
         })->select('deliverynotes.id','deliverynotes.deli_note_no','deliverynotes.customer_po','customers.name','deliverynotes.so_no','deliverynotes.manual_do','salesorders.order_no','deliverynotes.is_deleted','deliverynotes.is_invoiced','deliverynotes.is_dortn',)
          ->orderBy('deliverynotes.id','desc')
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
return view('inventory/sales/deliverynote',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'pros'=>$pros,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
               }
function getcurrentstock(Request $req){
 $item = $req->itemid;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id','currentstocks.qnty_in','currentstocks.qnty_out')
           ->orderBy('stores.locationname','asc')
           ->get();
  return view('inventory/sales/currentstockview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm]);          


}
function dortnstock(Request $req){
$item = $req->itemid;
$doqnty =$req->doqnty;
  $itemm=itemmaster::select('cost')->where('id',$item)->first();
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id','currentstocks.id','currentstocks.qnty_in','currentstocks.qnty_out')
           ->orderBy('stores.locationname','asc')
           ->get();
  return view('inventory/sales/dortnstock',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm,'doqnty'=>$doqnty]);


}

function getcurrentstockso(Request $req){
 $item = $req->itemid;
 $soqty=$req->soqty;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id','currentstocks.qnty_in','currentstocks.qnty_out')
           ->get();
  return view('inventory/sales/currentstocksoview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm,'soqty'=>$soqty]);          


}

function currentstockdo(Request $req){
   $item = itemmaster::select('id','code','item','basic_unit','cost')
          ->find($req->itemid);
  $rowCount= $req->rowCount;
  $totqnty=$req->totqnty; 
  $stock = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$req->itemid)
                ->where('currentstocks.bal_qnty','!=','0.000')
                ->select('currentstocks.location_id','currentstocks.batch','stores.locationname')->first();
return view('inventory/sales/dogridview',['item'=>$item,'stock'=>$stock,'rowCount'=>$rowCount,'totqnty'=>$totqnty]);

}


function createdeliverynote(Request $req){
  $validator =  $req ->validate([
                'deli_note_no'=>'required|unique:deliverynotes',
                'item_id'=>'required',
                'customer'=>'required',
                'quantity'=>'required'],

        [ 'order_no.required'    => 'Sorry,Please generate an DO number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
 $quote = deliverynote::updateOrCreate(
  ['deli_note_no'=>$req->input('deli_note_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'so_no'=>$req->input('so_no'),'manual_do'=>$req->input('manual_do'),'customer'=>$req->input('customer'),'customer_po'=>$req->input('customer_po'),'project_code'=>$req->input('project_code'),'executive'=>$req->input('executive'),'from_so'=>$req->input('from_so'),'remarks'=>$req->input('remarks'),'total'=>$req->input('total'),'cancelled_reason'=>$req->input('cancelled_reason'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($quote)){
    
      $item_id=$req->item_id;
      $code=$req->code;
      $item_name=$req->item;
      $unit=$req->unit;
      $location_id=$req->location_id;
      $batch=$req->batch;
      $quantity=$req->quantity;
      $rate=$req->rate;
      $soqnty=$req->soqnty;
      $soid=$req->soid;
      $main=$req->main; 
     $count =count($item_id);
for ($i=0; $i < $count; $i++){
 $amount = $quantity[$i] * $rate[$i];
  $bnd =deliverynotedetail::Create(
  ['item_id'=>$item_id[$i],
  'dln_id'=>$quote->id,
  'so_id'=>$soid[$i],
  'item'=>$item_name[$i],
  'code'=>$code[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'location_id'=>$location_id[$i],
  'quantity'=>$quantity[$i],
  'bal_qnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'amount'=>$amount,
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  //////SO Qnty reduction //////
  if(!empty($req->input('so_no'))){
$qtnn = salesorderdetail::where('id',$soid[$i])->first();
$qnty = $qtnn->quantity;
$sqnty = $qtnn->issdn_qnty;
$bqnty = $qtnn->bal_qnty;
$totiss = $quantity[$i] + $sqnty; 
$cqnty = $qnty-$totiss ;
$upenquiry = salesorderdetail::where('id',$soid[$i])
             ->update(['issdn_qnty'=>$totiss,'bal_qnty'=>$cqnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

   }
 
   $senq = salesorderdetail::where('order_id',$main[$i])
                 ->where('bal_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = salesorder::where('id',$main[$i])
             ->update(['call_for_do'=>'1']);
 
   }
   else{
    $upenquiry = salesorder::where('id',$main[$i])
             ->update(['call_for_do'=>'2']);
   }
   /////////////////////////////////////////////////////////
 } 
   //////Stockmovement//////
   $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $qntyin =$req->qntyin;
   $qntyout =$req->qntyout;
   $cost =$req->cost;
   $counts =count($idid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $nqntyout =$qntyout[$j]+$rqnty[$j];
   $bqnty =$qntyin[$j] -$nqntyout;
   if($rqnty[$j] !="0"){

 stockmovement::Create(
  ['voucher_id'=>'30','voucher_type'=>'deliverynote','voucher_date'=>$nddate,'description'=>$req->input('deli_note_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  
 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqntyout,
                       'bal_qnty'=>$bqnty]);

}
}
 ////////////////////////////////

$req->session()->flash('status', 'Data updated successfully!');

return redirect('/inventory/delivery-note');


  }

}
function currentstocktodogrid(Request $req){
   $itemid = $req->itemids;
   $locid = $req->location_id;
   $batch= $req->batchs;
   $balqnty=$req->balqty;
   $reqqnty=$req->reqnty; 
   $bal =$balqnty -$reqqnty;
   $itemmcost=$req->itemmcost;
   $amo= $reqqnty * $itemmcost;
  
 
return view('inventory/sales/dogridstockview',['itemid'=>$itemid,'locid'=>$locid,'batch'=>$batch,'bal'=>$bal,'reqqnty'=>$reqqnty,'itemmcost'=>$itemmcost,'amo'=>$amo]);

}
function getexecutives(Request $req){
  $cust = customerexecutivedetail::where('customerid',$req->customer)
          ->select('executive')->get();
          $output="";
          $output .='<option value="" hidden>Executive</option>';
          foreach($cust as $cus){
            $output .='<option value="'.$cus->executive.'">'.$cus->executive.'</option>'; 
          }
echo $output;
}

function sorderdetails(Request $req){
   $sos = salesorder::where('customer',$req->customer)
         ->select('id','order_no')
         ->where('is_deleted','!=','1')
         ->where('call_for_do','!=','1')->get();
return view('inventory/sales/dosoview',['sos'=>$sos]);
}
function getsodet(Request $req){
   $sod =salesorderdetail::where('order_id',$req->sono)
         ->where('bal_qnty','!=','0.000')
        ->get();
return view('inventory/sales/gridsoview',['sod'=>$sod]);
}
function printdo(){


$cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data1 = deliverynote::with('deliverynotedetail')->leftJoin('customers', function($join) {
      $join->on('deliverynotes.customer', '=', 'customers.id');
         })->select('deliverynotes.id','deliverynotes.deli_note_no','deliverynotes.dates','deliverynotes.customer_po','deliverynotes.manual_do','deliverynotes.remarks','customers.name','customers.address','customers.contactperson','deliverynotes.total','deliverynotes.executive')
->orderBy('deliverynotes.id','desc')
->take('1')
          ->first();
  //return view('inventory/sales/printdoview',['cmpid'=>$cmpid,'data1'=>$data1]);
$pdf = PDF::loadView('inventory/sales/printdoview',['cmpid'=>$cmpid,'data1'=>$data1]);
return $pdf->download('Delivery Note.pdf');
}
function editdo($id, Request $req){
   $priv=privilege::select('pageid','user')
           ->where('pageid','30')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////

 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();
$pros = projectdetail::select('id', 'project_code')
        ->where('is_deleted','!=','1')
        ->where('is_completed','!=','1')
        ->orderBy('id','desc')
        ->get();
  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    deliverynote::leftJoin('customers', function($join) {
      $join->on('deliverynotes.customer', '=', 'customers.id');
         })->leftJoin('salesorders', function($joins) {
      $joins->on('deliverynotes.so_no', '=', 'salesorders.id');
         })->select('deliverynotes.id','deliverynotes.deli_note_no','deliverynotes.customer_po','customers.name','deliverynotes.so_no','deliverynotes.manual_do','salesorders.order_no','deliverynotes.is_deleted','deliverynotes.is_invoiced','deliverynotes.is_dortn',)
          ->orderBy('deliverynotes.id','desc')
          ->get();
    $dos=   deliverynote::with('deliverynotedetail')->where('deliverynotes.id',$id)->first();     
           $so = salesorder::where('id',$dos->so_no)->select('order_no')->first();




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
return view('inventory/sales/deliverynoteedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'datas'=>$datas,'pros'=>$pros,'dos'=>$dos,'so'=>$so,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function printeditdo($id){
  $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data1 = deliverynote::with('deliverynotedetail')->leftJoin('customers', function($join) {
      $join->on('deliverynotes.customer', '=', 'customers.id');
         })->select('deliverynotes.id','deliverynotes.deli_note_no','deliverynotes.dates','deliverynotes.customer_po','deliverynotes.manual_do','deliverynotes.remarks','customers.name','customers.address','customers.contactperson','deliverynotes.total','deliverynotes.executive')
->where('deliverynotes.id',$id)
->first();
  //return view('inventory/sales/printdoview',['cmpid'=>$cmpid,'data1'=>$data1]);
$pdf = PDF::loadView('inventory/sales/printdoview',['cmpid'=>$cmpid,'data1'=>$data1]);
return $pdf->download('Delivery Note.pdf');

}
function deletedo($id,Request $req){
   $dos =deliverynotedetail::where('dln_id',$id)->get();
       deliverynote::where('id',$id)
       ->update(['is_deleted'=>'1']);
   $ddo =deliverynote::select('deli_note_no','dates','from_so')->where('id',$id)->first();    
       //////Stockmovement//////
   $del = 'Deleted'.''.$ddo->deli_note_no;
       foreach($dos as $do){
  $soid =$do->so_id;
   $idid=$do->item_id;
   $locid =$do->location_id;
   $batches =$do->batch;
   $rqnty =$do->quantity;
   $cost =$do->rate;
   $amt =$do->amount;
stockmovement::Create(
  ['voucher_id'=>'30','voucher_type'=>'deleted deliverynote','voucher_date'=>$ddo->dates,'description'=>$del,'location_id'=>$locid,'item_id'=>$idid,'batch'=>$batches,'rate'=>$cost,'quantity'=>$rqnty,'stock_value'=>$amt,'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $cuur =currentstock::where('item_id',$idid)
               ->where('batch',$batches)
               ->where('location_id',$locid)
               ->first();
               $cuur->qnty_in;
               $cuur->qnty_out;
               $cuur->bal_qnty;
               if(!empty($cuur->qnty_in)){
                $qnty =$cuur->qnty_in +$rqnty;
                $bq =$qnty - $cuur->bal_qnty;
 currentstock::where('item_id',$idid)
               ->where('batch',$batches)
               ->where('location_id',$locid)
               ->update(['qnty_in'=>$qnty,
              'bal_qnty'=>$bq]);
             }else{

             currentstock::create(['qnty_in'=>$qnty,
              'bal_qnty'=>$bq,'item_id'=>$idid]); 
             }

if($ddo->from_so=='1'){
  $so = salesorderdetail::where('id',$soid)->first();
 $snqty =$so->quantity;
 $issdn_qnty =$so->issdn_qnty;
 $bal_qnty =$so->bal_qnty;
 $rate =$so->rate;
 $discount =$so->discount;
 $amount =$so->amount;
 $issty = $issdn_qnty - $rqnty;
 $nbal = $snqty - $issty;

 $sso =salesorderdetail::where('id',$soid)
       ->update(['issdn_qnty'=>$issty,'bal_qnty'=>$nbal]);
       $sso1 =salesorder::where('id',$so->order_id)
       ->update(['call_for_do'=>'0']);

}
}
$req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();
 ////////////////////////////////
}
function getdoreturn(){
$priv=privilege::select('pageid','user')
           ->where('pageid','31')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','31')
              ->select('slno','constants')->first();  
  $slno=doreturn::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $store = store::select('id', 'locationname')
         ->orderBy('id','asc')
         ->get();

  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    doreturn::leftJoin('customers', function($join) {
      $join->on('doreturns.customer', '=', 'customers.id');
         })->leftJoin('deliverynotes', function($joins) {
      $joins->on('doreturns.deli_note_number', '=', 'deliverynotes.id');
         })->select('doreturns.id','doreturns.rtn_no','doreturns.dates','customers.name','deliverynotes.deli_note_no')
          ->orderBy('doreturns.id','desc')
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
return view('inventory/sales/deliverynotereturn',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'store'=>$store,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }



}
function dodetails(Request $req){
$customer = $req->customer;
 $do =deliverynote::where('customer',$customer)
            ->where('is_deleted','0')
            ->where('is_invoiced','!=','1')
            ->where('is_dortn','!=','1')
     ->select('id','deli_note_no')
     ->get();
return view('inventory/sales/dedetail',['do'=>$do]);
}
function alldodetails(Request $req){
  $dono = $req->dono;

  $do =deliverynotedetail::leftJoin('stores', function($join) {
      $join->on('deliverynotedetails.location_id', '=', 'stores.id');
         })->where('dln_id',$dono)
       ->select('deliverynotedetails.*','stores.locationname')->get();
  return view('inventory/sales/griddoview',['do'=>$do]);

}
function creatednotertn(Request $req){
 $validator =  $req ->validate([
                'rtn_no'=>'required',
                'item_id'=>'required',
                'customer'=>'required',
                'rtnqnty'=>'required'],
        [ 'rtn_no.required'    => 'Sorry,Please generate an DO Rtn number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer.required'  => 'Sorry,Please select a customer, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
 $quote = doreturn::updateOrCreate(
  ['rtn_no'=>$req->input('rtn_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'location'=>$req->input('location'),'deli_note_number'=>$req->input('deli_note_number'),'customer'=>$req->input('customer'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($quote)){
    
      $item_id=$req->item_id;
      $code=$req->item_code;
      $item_name=$req->item_name;
      $unit=$req->unit;
      $batch=$req->batch;
      $dnqnty=$req->dnqnty;
      $rate=$req->rate;
      $rtnqnty=$req->rtnqnty;
      $amount=$req->amount;
      $location_id=$req->location_id;
     $doid=$req->doid;
     $dln_id=$req->dln_id;
     $so_id=$req->so_id;
     $count =count($item_id);
for ($i=0; $i < $count; $i++){
 $amount = $rtnqnty[$i] * $rate[$i];
  $bnd =deliveryreturndetail::Create(
  ['item_id'=>$item_id[$i],
  'dnrtn_id'=>$quote->id,
  'item_name'=>$item_name[$i],
  'item_code'=>$code[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'dnqnty'=>$dnqnty[$i],
  'rtnqnty'=>$rtnqnty[$i],
  'rate'=>$rate[$i],

  'amount'=>$amount,
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  
  ////DO Qnty reduction //////
  
 $qtnn = deliverynotedetail::where('id',$doid[$i])->first();
$qnty = $qtnn->quantity;
 $inv_qnty = $qtnn->inv_qnty;
$dortn_qnty = $qtnn->dortn_qnty;
$bal_qnty = $qtnn->bal_qnty;
 $ndortn_qnty = $rtnqnty[$i] + $dortn_qnty; 
   $cqnty = $qnty -($inv_qnty + $ndortn_qnty) ;
  $upenquiry = deliverynotedetail::where('id',$doid[$i])
            ->update(['dortn_qnty'=>$ndortn_qnty,'bal_qnty'=>$cqnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

  
 
   $senq = deliverynotedetail::where('dln_id',$dln_id[$i])
                 ->where('bal_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = deliverynote::where('id',$dln_id[$i])
             ->update(['is_dortn'=>'1']);
 
   }else{
    $upenquiry = deliverynote::where('id',$dln_id[$i])
             ->update(['is_dortn'=>'2']);
   }
   /////////////////////////////////////////////////////////
 }
   //////Stockmovement//////
    $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $qntyin =$req->qntyin;
   $qntyout =$req->qntyout;
   $cost =$req->cost;
   $iid =$req->stckid;
   $counts =count($iid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $nqntyout =$qntyout[$j]-$rqnty[$j];
   $balqnty =$qntyin[$j] -$nqntyout;
   //return$rqnty[$j];
   if($rqnty[$j] !="0"){

 stockmovement::Create(
  ['voucher_id'=>'31','voucher_type'=>'Delivery Note Return','voucher_date'=>$nddate,'description'=>$req->input('rtn_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'quantity'=>$rqnty[$j],'stock_value'=>$amount,'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
      
        currentstock::where('item_id',$idid[$j])
           ->where('batch',$batches[$j])
           ->where('location_id',$locid[$j])
              ->update(['qnty_out'=>$nqntyout,
                       'bal_qnty'=>$balqnty]);

}
}
 //////////////////////////////// 
   
 
 //////////////////////////////

$req->session()->flash('status', 'Data updated successfully!');

return redirect('inventory/delivery-return');


  }


}
function editdoreturn($id,Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','31')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
        
            //////// For Popups/////////////
            $units = unit::where('active','1')
                    ->select('shortname')
                    ->orderBy('shortname','Asc')
                    ->get();
              $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
//   $voucher  = vouchergeneration::where('voucherid','31')
//               ->select('slno','constants')->first();  
//   $slno=doreturn::select('slno')
//                        ->orderBy('id','desc')
//                        ->take('1')
//                        ->first();
// if(!empty($slno->slno)){
//   $nslno = $slno->slno +1;
// }
// else{
//   $nslno=$voucher->slno;
// }
 $store = store::select('id', 'locationname')
         ->orderBy('id','asc')
         ->get();

  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    doreturn::leftJoin('customers', function($join) {
      $join->on('doreturns.customer', '=', 'customers.id');
         })->leftJoin('deliverynotes', function($joins) {
      $joins->on('doreturns.deli_note_number', '=', 'deliverynotes.id');
         })->select('doreturns.id','doreturns.rtn_no','doreturns.dates','customers.name','deliverynotes.deli_note_no')
          ->orderBy('doreturns.id','desc')
          ->get();
       $dortn =doreturn::with('deliveryreturndetail')->find($id);
      $do = deliverynote::where('id',$dortn->deli_note_number) 
           ->select('deli_note_no')->first(); 




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
return view('inventory/sales/deliverynotereturnedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'store'=>$store,'customer'=>$customer,'datas'=>$datas,'dortn'=>$dortn,'do'=>$do,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }


}
function printeditdortn($id,Request $req){
  $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = doreturn::with('deliveryreturndetail')->leftJoin('customers', function($join) {
      $join->on('doreturns.customer', '=', 'customers.id');
         })->select('doreturns.id','doreturns.rtn_no','doreturns.dates','customers.name','customers.address','doreturns.remarks','doreturns.deli_note_number')
      ->where('doreturns.id',$id)
      ->first();
      $do = deliverynote::where('id',$data->deli_note_number) 
           ->select('deli_note_no')->first(); 
//return view('inventory/sales/printdortn_view',['cmpid'=>$cmpid,'data'=>$data,'do'=>$do]);
$pdf = PDF::loadView('inventory/sales/printdortn_view',['cmpid'=>$cmpid,'data'=>$data,'do'=>$do]);
return $pdf->download('DeliveynoteReturn.pdf');

}
function printdortn(Request $req){
  $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = doreturn::with('deliveryreturndetail')->leftJoin('customers', function($join) {
      $join->on('doreturns.customer', '=', 'customers.id');
         })->select('doreturns.id','doreturns.rtn_no','doreturns.dates','customers.name','customers.address','doreturns.remarks','doreturns.deli_note_number')
      ->orderBy('doreturns.id','desc')
      ->take('1')->first();
      $do = deliverynote::where('id',$data->deli_note_number) 
           ->select('deli_note_no')->first(); 
//return view('inventory/sales/printdortn_view',['cmpid'=>$cmpid,'data'=>$data,'do'=>$do]);
$pdf = PDF::loadView('inventory/sales/printdortn_view',['cmpid'=>$cmpid,'data'=>$data,'do'=>$do]);
return $pdf->download('DeliveynoteReturn.pdf');

}
function salesgraph(Request $req){
    $month =Carbon::now()->format('m');
     $prmonth =$month-1;
     $prrmonth =$month-2;
    $year =Carbon::now()->format('Y');
    $sinv1 =salesinvoice::whereYear('dates', $year)
   ->whereMonth('dates', $month)
        ->sum('net_total');
        $sinv2 =salesinvoice::whereYear('dates', $year)
   ->whereMonth('dates', $prmonth)
        ->sum('net_total');
        $sinv3 =salesinvoice::whereYear('dates', $year)
   ->whereMonth('dates', $prrmonth)
        ->sum('net_total');




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
return view('inventory/sales/salesgraph',['sinv1'=>$sinv1,'sinv2'=>$sinv2,'sinv3'=>$sinv3,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}

}
