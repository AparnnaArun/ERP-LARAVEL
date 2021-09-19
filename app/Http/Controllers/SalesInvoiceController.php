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
use App\Models\currency;
use App\Models\header;
use App\Models\projectdetail;
use App\Models\deliverynote;
use App\Models\deliverynotedetail;
use App\Models\ doreturn;
use App\Models\deliveryreturndetail;
use App\Models\stockmovement;
use App\Models\store;
use App\Models\salesinvoice;
use App\Models\salesinvoicedetail;
use App\Models\executivecommission;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\salesreturndetail;
use App\Models\salesreturn;
use App\Models\projectmaterialrequest;
use App\Models\projectinvoice;
use PDF;
use Validator;
use Carbon\Carbon;

class SalesInvoiceController extends Controller
{
    function getsinvoice(){
$priv=privilege::select('pageid','user')
           ->where('pageid','40')
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
                          ///////////////Layout Section Calculation Part/////////////////
  $noti1 =deliverynote::where('is_invoiced','0')
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
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
           ///////////////Layout Section Calculation Part End/////////////////
  $voucher  = vouchergeneration::where('voucherid','40')
              ->select('slno','constants')->first();  
  $slno=salesinvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{

$nslno="";
}
 $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
         ->get();

$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    salesinvoice::leftJoin('customers', function($join) {
      $join->on('salesinvoices.customer_id', '=', 'customers.id');
         })->leftJoin('deliverynotes', function($joins) {
      $joins->on('salesinvoices.deli_note_no', '=', 'deliverynotes.id');
         })->select('salesinvoices.id','salesinvoices.invoice_no','salesinvoices.dates','customers.name','deliverynotes.deli_note_no','salesinvoices.po_number','salesinvoices.is_deleted','salesinvoices.paidstatus','salesinvoices.is_returned')
->orderBy('salesinvoices.id','desc')
          ->get();
//   return $do=deliverynote::whereHas('deliverynotedetail',function ($query) {
//     return $query->where('item_id', '=', 243);
// })
//       ->whereIn('id',['3','4'])
//      ->select('deli_note_no',DB::raw('SUM(bal_qnty) AS sumqnty'))->get();          
return view('inventory/sales/salesinvoice',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function executiveinv(Request $req){
 $cust = customerexecutivedetail::where('customerid',$req->customer)
          ->select('executive')->get();
  $acc = customer::where('id',$req->customer)
          ->select('account')->first();
return view('inventory/sales/executivecust',['cust'=>$cust,'acc'=>$acc]);

}
function getcurrentstockinv(Request $req){
 $item = $req->itemid;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id','currentstocks.qnty_in','currentstocks.qnty_out')
           ->get();
  return view('inventory/sales/currentstockinvview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm]);          



}


function currentstockinvoice(Request $req){
   $item = itemmaster::leftJoin('salesrateupdations', function($joins) {
      $joins->on('salesrateupdations.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id','itemmasters.code','itemmasters.item','itemmasters.basic_unit','itemmasters.cost','salesrateupdations.retail_salesrate','salesrateupdations.wholesale_salesrate')
          ->find($req->itemid);
 $rowCount= $req->rowCount;
  $totqnty=$req->totqnty; 
   $ammt = $totqnty * ($item->retail_salesrate);
   $costt = $totqnty * ($item->cost);
    $stock = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$req->itemid)
                ->where('currentstocks.bal_qnty','!=','0.000')
                ->select('currentstocks.location_id','currentstocks.batch','stores.locationname')->first();
                $customer =customer::where('id',$req->customer)
               ->select('specialprice')->first();
return view('inventory/sales/invoicegridview',['item'=>$item,'stock'=>$stock,'rowCount'=>$rowCount,'totqnty'=>$totqnty,'ammt'=>$ammt,'costt'=>$costt,'customer'=>$customer]);

}
function createsinvoice(Request $req){
     $validator =  $req ->validate([
                'invoice_no'=>'required',
                'item_id'=>'required',
                'customer_id'=>'required',
                'quantity'=>'required',
                'cus_accnt'=>'required',
                'percent'=>'required',
                'comm_pay_account'=>'required',
                'exe_com_exp_ac'=>'required'
            ],
   [ 'invoice_no.required'    => 'Sorry,Please generate an invoice number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'customer_id.required'  => 'Sorry,Please select a customer, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.',
       'cus_accnt.required'=> 'Sorry, Customer account is missing.',
       'percent.required'=> 'Sorry, Executive percentage is missing.',
       'comm_pay_account.required'=> 'Sorry, Executive account is missing.',
       'exe_com_exp_ac.required'   => 'Sorry, Executive account is missing.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $profit = $req->input('net_total') - $req->input('totcosts');
  $percent=$req->input('percent');
  $profitpay = ($profit*$percent)/100;
  if($req->input('totcosts') > $req->input('net_total') ){
$req->session()->flash('failed', 'Sorry , Cost is heigher than net total!');
return redirect('/inventory/sales-invoice');

  }
 
  else{
    
  if($req->input('invoicefrom')=='1'){
    ////////// FOR delivery note implode///////////
    $enquiry = salesinvoice::updateOrCreate(
  ['invoice_no'=>$req->input('invoice_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'po_number'=>$req->input('po_number'),'customer_id'=>$req->input('customer_id'),'manual_do_no'=>$req->input('manual_do_no'),'manual_inv_no'=>$req->input('manual_inv_no'),'currency'=>$req->input('currency'),'ship_to'=>$req->input('ship_to'),'invoicefrom'=>$req->input('invoicefrom'),'payment_mode'=>$req->input('payment_mode'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'totcosts'=>$req->input('totcosts'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'advance'=>$req->input('advance'),'deli_info'=>$req->input('deli_info'),'payment_terms'=>$req->input('payment_terms'),'net_total'=>$req->input('net_total'),'cus_accnt'=>$req->input('cus_accnt'),'vehicle_details'=>$req->input('vehicle_details'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'deli_note_no'=>implode($req->deli_note_no, ', '),'grand_total'=>$req->input('net_total'),'commission_percentage'=>$req->input('percent'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac')]);
}else{
    ////////// Without delivery note implode///////////
$enquiry = salesinvoice::updateOrCreate(
  ['invoice_no'=>$req->input('invoice_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'po_number'=>$req->input('po_number'),'customer_id'=>$req->input('customer_id'),'manual_do_no'=>$req->input('manual_do_no'),'manual_inv_no'=>$req->input('manual_inv_no'),'currency'=>$req->input('currency'),'ship_to'=>$req->input('ship_to'),'invoicefrom'=>$req->input('invoicefrom'),'payment_mode'=>$req->input('payment_mode'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'totcosts'=>$req->input('totcosts'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'advance'=>$req->input('advance'),'deli_info'=>$req->input('deli_info'),'payment_terms'=>$req->input('payment_terms'),'net_total'=>$req->input('net_total'),'balance'=>$req->input('net_total'),'cus_accnt'=>$req->input('cus_accnt'),'vehicle_details'=>$req->input('vehicle_details'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'grand_total'=>$req->input('net_total'),'commission_percentage'=>$req->input('percent'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac')]);


}


    if(isset($enquiry)){
      $item_id=$req->item_id;
      $code = $req->item_code;
      $item_name=$req->item_name;
      $unit=$req->unit;
      $batch=$req->batch;
      $quantity=$req->quantity;
      $rate=$req->rate;
      $discount = $req->discount;
      $freeqnty=$req->freeqnty;
      $amount=$req->amount;
      $totalcost=$req->totalcost;
       $count =count($item_id);
for ($i=0; $i < $count; $i++){

     $qty = $quantity[$i] + $freeqnty[$i];
   
  $bnd =salesinvoicedetail::updateOrCreate(
    
  ['item_id'=>$item_id[$i],
 
  'item_code'=>$code[$i],
  'inv_id'=>$enquiry->id,
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'quantity'=>$quantity[$i],
  'penrtn_qnty'=>$qty,
  'discount'=>$discount[$i],
  'freeqnty'=>$freeqnty[$i],
  'rate'=>$rate[$i],
  'amount'=>$amount[$i],
  'totalcost'=>$totalcost[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
}

    //////// DO REDUCTION ///////

  if($req->input('invoicefrom')=='1'){
$dln_id=$req->dln_id;
$delidetid=$req->dodid;
$doqty=$req->doqty;
$doity=$req->doity;
$dobty=$req->dobty;
$dodrty=$req->dodrty;
$quantity1 =$req->quantity1;
 $counts =count($delidetid);
for ($k=0; $k < $counts; $k++){
$ndoity = $quantity1[$k] + $doity[$k];
$ndobty = $doqty[$k] - ($ndoity + $dodrty[$k]);
  deliverynotedetail::where('id',$delidetid[$k])
  ->update(['inv_qnty'=>$ndoity,'bal_qnty'=>$ndobty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
     $senq = deliverynotedetail::where('dln_id',$dln_id[$k])
                 ->where('bal_qnty','!=','0.000')->count();
    if($senq < 1){

    deliverynote::where('id',$dln_id[$k])
  ->update(['is_invoiced'=>'1']);    
    }
    else{

 deliverynote::where('id',$dln_id[$k])
  ->update(['is_invoiced'=>'2']); 
    }
   }
}
   //////// STOCK MOVEMENTS///////
if($req->input('invoicefrom')=='0'){
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
  ['voucher_id'=>'30','voucher_type'=>'SalesInvoice','voucher_date'=>$nddate,'description'=>$req->input('invoice_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  
 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqntyout,
                       'bal_qnty'=>$bqnty]);

}
}
           }
   //////Executive Commission////////////////
   $exee = executivecommission::updateOrCreate(
  ['invoice_no'=>$req->input('invoice_no'),'inv_id'=>$enquiry->id],
['customer'=>$req->input('customer_id'),'executive'=>$req->input('executive'),'percent'=>$req->input('percent'),'total_amount'=>$req->input('net_total'),'net_total'=>$req->input('net_total'),'profit'=>$profit,'profitpay'=>$profitpay,'totcost'=>$req->input('totcosts'),'from_where'=>'Sinv','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate]);        

 //////ACCOUNTS SETTELING ////////////////
  $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('net_total'),'totcredit'=>$req->input('net_total'),'created_by'=>session('name'),'remarks'=>$req->input('invoice_no'),'approved_by'=>session('name'),'from_where'=>'Sales Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>$req->input('cus_accnt'),'narration'=>$req->input('invoice_no'),'amount'=>$req->input('net_total'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'47','narration'=>$req->input('invoice_no'),'amount'=>$req->input('net_total'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////general A/c///////////////////////////////
  $sql1 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno1 =$sql1->slno;
 $nslno1 = $slno1 + 1;
 $no1 = 'Jr'.$nslno1;
 $data3= regularvoucherentry::Create(

['voucher_no'=>$no1,'slno'=>$nslno1,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totcosts'),'totcredit'=>$req->input('totcosts'),'created_by'=>session('name'),'remarks'=>$req->input('invoice_no'),'approved_by'=>session('name'),'from_where'=>'Sales Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data3){
$data4= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'debt','account_name'=>'24','narration'=>$req->input('invoice_no'),'amount'=>$req->input('totcosts'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data5= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('invoice_no'),'amount'=>$req->input('totcosts'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$profitpay,'totcredit'=>$profitpay,'created_by'=>session('name'),'remarks'=>$req->input('invoice_no'),'approved_by'=>session('name'),'from_where'=>'Sales Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>$req->input('invoice_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('comm_pay_account'),'narration'=>$req->input('invoice_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/sales-invoice'); 
}
}
}
 function getexecomm(Request $req){
     $ee= $req->exec;
     $exe = executive::where('short_name',$ee)->first();
return view('inventory/sales/execomm',['exe'=>$exe]);      

  }
  function dodetailstoinv(Request $req){

 $dos =deliverynote::where('customer',$req->customer)
       ->where('is_invoiced','!=','1')
        ->where('is_dortn','!=','1')
         ->where('is_deleted','!=','1')
         ->select('id','deli_note_no')
         ->get();
         return view('inventory/sales/doselect2',['dos'=>$dos]);      


  }
  function dodetailsfromcart(Request $req){
    $customer =customer::where('id',$req->customer)
               ->select('specialprice')->first();
    $enqno = $req->enqno;
       $eenqs = deliverynotedetail::leftJoin('salesrateupdations', function($joins) {
      $joins->on('salesrateupdations.item_id', '=', 'deliverynotedetails.item_id');
         })->leftJoin('itemmasters', function($join) {
      $join->on('itemmasters.id', '=', 'deliverynotedetails.item_id');
         })->where('deliverynotedetails.bal_qnty','!=','0')
           ->whereIn('dln_id',$enqno)
           ->select('salesrateupdations.retail_salesrate','salesrateupdations.wholesale_salesrate','itemmasters.cost','deliverynotedetails.item_id','deliverynotedetails.code','deliverynotedetails.item','deliverynotedetails.unit', DB::raw('SUM(deliverynotedetails.bal_qnty) AS sumqnty'))
           ->groupBy('deliverynotedetails.item_id','salesrateupdations.retail_salesrate','salesrateupdations.wholesale_salesrate','itemmasters.cost','deliverynotedetails.code','deliverynotedetails.item','deliverynotedetails.unit')
              ->get();

   


return view('inventory/sales/doforinvview',['eenqs'=>$eenqs,'enqno'=>$enqno,'customer'=>$customer]);
}
function getpo(Request $req){
  $enqno = $req->enqno;
       $eenqs = deliverynote::whereIn('id',$enqno)
                     ->get();
    return view('inventory/sales/customerpo',['eenqs'=>$eenqs]);                 

}
function editsinvoice($id,Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','40')
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
  $voucher  = vouchergeneration::where('voucherid','40')
              ->select('slno','constants')->first();  
  $slno=salesinvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{

$nslno="";
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();

$currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    salesinvoice::leftJoin('customers', function($join) {
      $join->on('salesinvoices.customer_id', '=', 'customers.id');
         })->leftJoin('deliverynotes', function($joins) {
      $joins->on('salesinvoices.deli_note_no', '=', 'deliverynotes.id');
         })->select('salesinvoices.id','salesinvoices.invoice_no','salesinvoices.dates','customers.name','deliverynotes.deli_note_no','salesinvoices.po_number','salesinvoices.is_deleted','salesinvoices.paidstatus','salesinvoices.is_returned')
->orderBy('salesinvoices.id','desc')
          ->get();
      $invs =    salesinvoice::with('salesinvoicedetail')
          ->find($id);
           $idd= $invs->deli_note_no;
           $myArray = explode(',', $idd);
             $doo= deliverynote::whereIn('id',$myArray)
                     ->select('deli_note_no')->get();
           $invs1 =    executivecommission::where('inv_id',$id)->first(); 
           $comm = executive::where('short_name',$invs1->executive)
                   ->select('commission_percentage','comm_pay_account','exe_com_exp_ac')
                    ->first();




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
return view('inventory/sales/salesinvoiceedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'invs'=>$invs,'invs1'=>$invs1,'doo'=>$doo,'comm'=>$comm,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function printeinvoice(Request $req,$id){
$iivs =    salesinvoice::find($id);
        $result = DB::table('salesinvoicedetails')
                ->select(DB::raw('sum(quantity) as sum_qty,sum(discount) as sum_disc,sum(amount) as sum_amt'),'item_name','unit','rate')
                ->where('inv_id',$id)
                ->groupBy('item_id','item_name','unit','rate')
                ->get();
                //dd($result);
        $data1 =    salesinvoice::leftJoin('customers', function($join) {
      $join->on('salesinvoices.customer_id', '=', 'customers.id');
         })->find($id);
           $idd= $iivs->deli_note_no;
           $myArray = explode(',', $idd);
             $doo= deliverynote::whereIn('id',$myArray)
                     ->select('deli_note_no')->get();
           $invs1 =   executivecommission::where('inv_id',$id)
                      ->select('executive')->first(); 
return view('inventory/sales/invprint',['iivs'=>$iivs,'invs1'=>$invs1,'doo'=>$doo,'data1'=>$data1,'result'=>$result]);
    $pdf = PDF::loadView('inventory/sales/invprint',['iivs'=>$iivs,'invs1'=>$invs1,'doo'=>$doo,'data1'=>$data1]);
return $pdf->download('SalesInvoice.pdf');
}
function printinvoice(){
  //////For Printing/////
$iivs =    salesinvoice::orderBy('id', 'desc')
            ->take('1')->first();
        $result = DB::table('salesinvoicedetails')
                ->select(DB::raw('sum(quantity) as sum_qty,sum(discount) as sum_disc,sum(amount) as sum_amt'),'item_name','unit','rate')
                ->where('inv_id',$iivs->id)
                ->groupBy('item_id','item_name','unit','rate')
                ->get();
        $data1 =    salesinvoice::leftJoin('customers', function($join) {
      $join->on('salesinvoices.customer_id', '=', 'customers.id');
         })->orderBy('salesinvoices.id', 'desc')
            ->take('1')->first();
           $idd= $iivs->deli_note_no;
           $myArray = explode(',', $idd);
             $doo= deliverynote::whereIn('id',$myArray)
                     ->select('deli_note_no')->get();
           $invs1 =   executivecommission::where('inv_id',$iivs->id)
                      ->select('executive')->first(); 
$pdf = PDF::loadView('inventory/sales/invprint',['iivs'=>$iivs,'invs1'=>$invs1,'doo'=>$doo,'data1'=>$data1,'result'=>$result]);
return $pdf->download('SalesInvoice.pdf');

}
function getreturn(){
$priv=privilege::select('pageid','user')
           ->where('pageid','50')
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
  $voucher  = vouchergeneration::where('voucherid','50')
              ->select('slno','constants')->first();  
  $slno=salesreturn::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{

$nslno="";
}
$store = store::orderBy('id','asc')->get(); 
 $currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    salesreturn::leftJoin('customers', function($join) {
      $join->on('salesreturns.customer_id', '=', 'customers.id');
         })->leftJoin('salesinvoices', function($joins) {
      $joins->on('salesinvoices.id', '=', 'salesreturns.salesid');
         })->select('salesreturns.id','salesreturns.rtn_no','salesreturns.rtndate','customers.name','salesinvoices.invoice_no','salesreturns.net_total')
->orderBy('salesreturns.id','desc')
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
return view('inventory/sales/sreturn',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function getinvoice(Request $req){
  $inv = salesinvoice::where('customer_id',$req->customer)
       ->where('is_deleted','!=','1')
       ->where('paidstatus','=','0')
        ->where('is_returned','!=','1')
       ->select('id','invoice_no','invoicefrom')->get();
    $cus = customer::where('id',$req->customer)
           ->select('account')->first();   
       return view('inventory/sales/invdettt',['inv'=>$inv,'cus'=>$cus]);
     


}

function getexeinv(Request $req){
 $inv = salesinvoice::where('id',$req->invoiceno)
     ->select('dates')->first();
$inv1 = executivecommission::where('inv_id',$req->invoiceno)
     ->select('executive')->first();
  $percent = executive::where('short_name',$inv1->executive)  
             ->select('commission_percentage','comm_pay_account','exe_com_exp_ac')->first();
 return view('inventory/sales/returnexce',['inv'=>$inv,'inv1'=>$inv1,'percent'=>$percent]);    

}
function getinvdetails(Request $req){
    $inv_id =$req->invoiceno;
  $enqno =salesinvoice::where('id',$req->invoiceno)
          ->select('deli_note_no','invoicefrom')->first();
   $invs = salesinvoicedetail::leftJoin('itemmasters', function($join) {
      $join->on('salesinvoicedetails.item_id', '=', 'itemmasters.id');
         })->leftJoin('salesinvoices', function($joins) {
      $joins->on('salesinvoicedetails.inv_id', '=', 'salesinvoices.id');
         })->where('salesinvoicedetails.inv_id',$inv_id)
          ->where('salesinvoicedetails.penrtn_qnty','!=','0')
   ->select('salesinvoicedetails.id','salesinvoicedetails.item_id','salesinvoicedetails.item_code','salesinvoicedetails.item_name','salesinvoicedetails.unit','salesinvoicedetails.batch','salesinvoicedetails.rate','salesinvoicedetails.quantity','salesinvoicedetails.freeqnty','salesinvoicedetails.isslnrtn_qnty','salesinvoicedetails.penrtn_qnty','salesinvoicedetails.rate','itemmasters.cost','salesinvoicedetails.inv_id','salesinvoices.invoicefrom')
     ->get();
return view('inventory/sales/iivdetail',['invs'=>$invs,'enqno'=>$enqno]); 
}
function createsreturn(Request $req){
     $validator =  $req ->validate([
                'rtn_no'=>'required',
                'item_id'=>'required',
                'customer_id'=>'required',
                'rtnqnty'=>'required',
            'cus_accnt'=>'required',
                'percent'=>'required',
                'comm_pay_account'=>'required',
                'exe_com_exp_ac'=>'required'],
   [ 'rtn_no.required'    => 'Sorry,Please generate an Rtn number, Thank You.',
    'item_id.required'=> 'Sorry, Minimum one item is needed to save this task,Thank You.',             
       'customer_id.required'  => 'Sorry,Please select a customer, Thank You.',
       'rtnqnty.required'   => 'Sorry,Quantity is required, Thank You.',
       'cus_accnt.required'=> 'Sorry, Customer account is missing.',
       'percent.required'=> 'Sorry, Executive percentage is missing.',
       'comm_pay_account.required'=> 'Sorry, Executive account is missing.',
       'exe_com_exp_ac.required'   => 'Sorry, Executive account is missing.'
        ]);
     $dates=$req->input('rtndate');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('salesdate');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $profit = $req->input('totcosts')-$req->input('net_total') ;
  $percent=$req->input('percent');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 = $profitpay * (-1);
  $rtn = salesreturn::updateOrCreate(
  ['rtn_no'=>$req->input('rtn_no')],
['slno'=>$req->input('slno'),'rtndate'=>$nddate,'location'=>$req->input('location'),'customer_id'=>$req->input('customer_id'),'salesid'=>$req->input('salesid'),'currency'=>$req->input('currency'),'executive'=>$req->input('executive'),'salesdate'=>$nddate1,'payment_mode'=>$req->input('payment_mode'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'total'=>$req->input('total'),'totcosts'=>$req->input('totcosts'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'deli_info'=>$req->input('deli_info'),'payment_terms'=>$req->input('payment_terms'),'net_total'=>$req->input('net_total'),'vehicle_details'=>$req->input('vehicle_details'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
      if(isset($rtn)){
        $main=$req->mainid;
        $invid=$req->invid;
        $item_id=$req->item_id;
        $item_code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $batch=$req->batch;
        $salesquantity=$req->salesquantity;
        $freeqnty=$req->freeqnty;
        $rtnqnty=$req->rtnqnty;
        $damage=$req->damage;
        $rtnfreeqnty=$req->rtnfreeqnty;
        $rate=$req->rate;
        $discount = $req->discount;
        $total=$req->amount;
        $totalcost=$req->totalcost;
        $isslnrtn_qnty = $req->isslnrtn_qnty;
        $penrtn_qnty=$req->penrtn_qnty;
       $count =count($item_id);
for ($i=0; $i < $count; $i++){
       $qty = $rtnqnty[$i] + $damage[$i] + $rtnfreeqnty[$i];
    $nisslnrtn_qnty = $qty + $isslnrtn_qnty[$i];
    $npenrtn_qnty = ($salesquantity[$i] + $freeqnty[$i]) - $nisslnrtn_qnty;
$bnd =salesreturndetail::Create(
  ['item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'rtn_id'=>$rtn->id,
  'return_no'=>$req->input('rtn_no'),
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'salesquantity'=>$salesquantity[$i],
  'freeqnty'=>$freeqnty[$i],
  'rtnqnty'=>$rtnqnty[$i],
  'rate'=>$rate[$i],
  'damage'=>'0',
  'rtnfreeqnty'=>'0',
  'discount'=>$discount[$i],
  'amount'=>$total[$i],
  'totalcost'=>$totalcost[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
    //////// Invoice REDUCTION ///////
 salesinvoicedetail::where('id',$main[$i])
  ->update(['isslnrtn_qnty'=>$nisslnrtn_qnty,'penrtn_qnty'=>$npenrtn_qnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
     $senq = salesinvoicedetail::where('inv_id',$invid[$i])
                 ->where('penrtn_qnty','!=','0.000')->count();
                 $sinv =salesinvoice::select('balance','isslnrtn_amt')
       ->where('id',$invid[$i])->first();
       $bal = $sinv->balance;
      $rtnamt = $sinv->isslnrtn_amt;
      $nrtrnamt = $rtnamt +$req->input('net_total');
    $nbal = $bal - $req->input('net_total');
    if($senq < 1){

    salesinvoice::where('id',$invid[$i])
  ->update(['is_returned'=>'1','balance'=>$nbal,'isslnrtn_amt'=>$nrtrnamt,'rtncost'=>$req->input('totcosts')]);    
    }
    else{

 salesinvoice::where('id',$invid[$i])
  ->update(['is_returned'=>'2','balance'=>$nbal,'isslnrtn_amt'=>$nrtrnamt,'rtncost'=>$req->input('totcosts')]); 
    }

////// Stock Movement ////////////////////////////
     stockmovement::Create(
  ['voucher_id'=>'50','voucher_type'=>'salesreturn','voucher_date'=>$nddate,'description'=>$req->input('rtn_no'),'location_id'=>$req->input('location'),'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$rate[$i],'quantity'=>$qty,'stock_value'=>$total[$i],'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
      $stock =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty','id')
               ->first();
               if(!empty($stock->qnty_in)){
               $qin=$stock->qnty_in;
               $qout =$stock->qnty_out;
               $bqty =$stock->bal_qnty;
               $iid =$stock->id;
               $nqin=$qin + $qty;
               $nbqty = $nqin- $qout;
 currentstock::where('id',$iid)
              ->update(['qnty_in'=>$nqin,
                       'bal_qnty'=>$nbqty]);
          }else{

        currentstock::create(['item_id'=>$item_id[$i],'qnty_in'=>$qty,
                       'bal_qnty'=>$qty,'location_id'=>$req->input('location'),'batch'=>$batch[$i]]);
                
          }
}
    ///// DO RETURN /////////////////////
  if($req->input('invoicefrom')=='1'){
    $item_ids=$req->itids;
      $code=$req->itcode;
      $item_name=$req->itname;
      $unit=$req->itunit;
      $batch=$req->batch;
      $dnqnty=$req->doity;
      $rate=$req->itrate;
      $rtnqnty=$req->quantity1;
      $doid=$req->dodid;
      $dln_id=$req->dln_id;
      $counts =count($doid);
    for ($k=0; $k < $counts; $k++){
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
    $quote = doreturn::updateOrCreate(
  ['rtn_no'=>$voucher->constants.$nslno],
['slno'=>$nslno,'dates'=>$nddate,'location'=>$req->input('location'),'deli_note_number'=>$dln_id[$k],'customer'=>$req->input('customer_id'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($quote)){
    
for ($k=0; $k < $counts; $k++){
 $amount = $rtnqnty[$k] * $rate[$k];
  $bnd =deliveryreturndetail::Create(
  ['item_id'=>$item_ids[$k],
  'dnrtn_id'=>$quote->id,
  'item_name'=>$item_name[$k],
  'item_code'=>$code[$k],
  'unit'=>$unit[$k],
  'batch'=>$batch[$k],
  'dnqnty'=>$dnqnty[$k],
  'rtnqnty'=>$rtnqnty[$k],
  'rate'=>$rate[$k],
  'amount'=>$amount,
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   ////DO Qnty reduction //////
  
 $qtnn = deliverynotedetail::where('id',$doid[$k])->first();
$qnty = $qtnn->quantity;
 $inv_qnty = $qtnn->inv_qnty;
$dortn_qnty = $qtnn->dortn_qnty;
$bal_qnty = $qtnn->bal_qnty;
 $ndortn_qnty = $rtnqnty[$k] + $dortn_qnty;
 $ninv_qnty = $inv_qnty - $rtnqnty[$k] ;  
   $cqnty = $qnty -($ninv_qnty + $ndortn_qnty) ;
  $upenquiry = deliverynotedetail::where('id',$doid[$k])
            ->update(['dortn_qnty'=>$ndortn_qnty,'inv_qnty'=>$ninv_qnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

  
 
   $senq = deliverynotedetail::where('dln_id',$dln_id[$k])
                 ->where('bal_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = deliverynote::where('id',$dln_id[$k])
             ->update(['is_dortn'=>'1']);
 
   }else{
    $upenquiry = deliverynote::where('id',$dln_id[$k])
             ->update(['is_dortn'=>'2']);
   }
}
}

}
}
 //////Executive Commission////////////////
   executivecommission::Create(
  ['invoice_no'=>$req->input('rtn_no'),
'customer'=>$req->input('customer_id'),'executive'=>$req->input('executive'),'percent'=>$req->input('percent'),'total_amount'=>$req->input('totcosts'),'net_total'=>$req->input('totcosts'),'profit'=>$profit,'profitpay'=>$profitpay,'totcost'=>$req->input('net_total'),'from_where'=>'SRtn','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 

 //////ACCOUNTS SETTELING ////////////////
  $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('net_total'),'totcredit'=>$req->input('net_total'),'created_by'=>session('name'),'remarks'=>$req->input('rtn_no'),'approved_by'=>session('name'),'from_where'=>'Sales return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$req->input('cus_accnt'),'narration'=>$req->input('rtn_no'),'amount'=>$req->input('net_total'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'47','narration'=>$req->input('rtn_no'),'amount'=>$req->input('net_total'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////general A/c///////////////////////////////
  $sql1 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno1 =$sql1->slno;
 $nslno1 = $slno1 + 1;
 $no1 = 'Jr'.$nslno1;
 $data3= regularvoucherentry::Create(

['voucher_no'=>$no1,'slno'=>$nslno1,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totcosts'),'totcredit'=>$req->input('totcosts'),'created_by'=>session('name'),'remarks'=>$req->input('rtn_no'),'approved_by'=>session('name'),'from_where'=>'Sales return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data3){
$data4= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'cred','account_name'=>'24','narration'=>$req->input('rtn_no'),'amount'=>$req->input('totcosts'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data5= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'debt','account_name'=>'272','narration'=>$req->input('rtn_no'),'amount'=>$req->input('totcosts'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$profitpay1,'totcredit'=>$profitpay1,'created_by'=>session('name'),'remarks'=>$req->input('rtn_no'),'approved_by'=>session('name'),'from_where'=>'Sales return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>$req->input('rtn_no'),'amount'=>$profitpay1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('comm_pay_account'),'narration'=>$req->input('rtn_no'),'amount'=>$profitpay1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/sales-return'); 
}
}
function printreturn(){
 $iivs =    salesreturn::with('salesreturndetail')->orderBy('id', 'desc')
            ->take('1')->first();
    $data1 =    salesreturn::leftJoin('customers', function($join) {
      $join->on('salesreturns.customer_id', '=', 'customers.id');
         })->orderBy('salesreturns.id', 'desc')
            ->take('1')->first();
          
             $doo= salesinvoice::where('id',$iivs->salesid)
                     ->select('invoice_no')->first();
           $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
$pdf = PDF::loadView('inventory/sales/rtnprint',['iivs'=>$iivs,'doo'=>$doo,'data1'=>$data1,'cmpid'=>$cmpid]);
return $pdf->download('SalesReturn.pdf');

}
function srturnedit($id,Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','50')
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
  $voucher  = vouchergeneration::where('voucherid','50')
              ->select('slno','constants')->first();  
  $slno=salesreturn::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{

$nslno="";
}
$store = store::orderBy('id','asc')->get(); 
 $currency = currency::orderBy('id','asc')->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    salesreturn::leftJoin('customers', function($join) {
      $join->on('salesreturns.customer_id', '=', 'customers.id');
         })->leftJoin('salesinvoices', function($joins) {
      $joins->on('salesinvoices.id', '=', 'salesreturns.salesid');
         })->select('salesreturns.id','salesreturns.rtn_no','salesreturns.rtndate','customers.name','salesinvoices.invoice_no','salesreturns.net_total')
->orderBy('salesreturns.id','desc')
          ->get();
           $datas1 =    salesreturn::leftJoin('salesinvoices', function($joins) {
      $joins->on('salesinvoices.id', '=', 'salesreturns.salesid');
         })->select('salesinvoices.invoice_no')
->where('salesreturns.id',$id)
          ->first();
          



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
 $rtns=salesreturn::with('salesreturndetail')->find($id);         
return view('inventory/sales/sreturnedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'currency'=>$currency,'store'=>$store,'rtns'=>$rtns,'datas1'=>$datas1,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }


}
function printereturn($id,Request $req){
    $iivs =    salesreturn::with('salesreturndetail')->where('id', $id)
            ->first();
    $data1 =    salesreturn::leftJoin('customers', function($join) {
      $join->on('salesreturns.customer_id', '=', 'customers.id');
         })->orderBy('salesreturns.id', 'desc')
            ->take('1')->first();
          
             $doo= salesinvoice::where('id',$iivs->salesid)
                     ->select('invoice_no')->first();
           $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
$pdf = PDF::loadView('inventory/sales/rtnprint',['iivs'=>$iivs,'doo'=>$doo,'data1'=>$data1,'cmpid'=>$cmpid]);
return $pdf->download('SalesReturn.pdf');

}
function deleteinvoice($id,Request $req){
  salesinvoice::where('id',$id)
  ->update(['is_deleted'=>'1']);
 $sinv = salesinvoice::find($id);
  $profit = $sinv->totcosts-$sinv->net_total ;
   $percent=$sinv->commission_percentage;
  $profitpay = ($profit*$percent)/100;
  $profitpay1 = $profitpay * (-1); 
 executivecommission::where('inv_id',$id)
  ->update(['is_deleted'=>'1']);
 $invs = salesinvoicedetail::where('inv_id',$id)->get();

 if($sinv->invoicefrom=='0'){
     $stcok = stockmovement::where('description',$sinv->invoice_no)->get();
    foreach($stcok  as $row){
$location_id=$row->location_id;
$item_id=$row->item_id;
$batch=$row->batch;
$rate=$row->rate;
$quantity=$row->qntyout;
$stock_value=$row->stockout;
stockmovement::Create(
  ['voucher_id'=>'0','voucher_type'=>'Deleted Sales Invoice','voucher_date'=>date('Y-m-d'),'description'=>'deleted'.$sinv->invoice_no,'location_id'=>$location_id,'item_id'=>$item_id,'batch'=>$batch,'rate'=>$rate,'quantity'=>$quantity,'stock_value'=>$stock_value,'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
      $stock =currentstock::where('item_id',$item_id)
               ->where('batch',$batch)
               ->where('location_id',$location_id)
               ->select('qnty_in','qnty_out','bal_qnty','id')
               ->first();
               $qin=$stock->qnty_in;
               $qout =$stock->qnty_out;
               $bqty =$stock->bal_qnty;
               $iid =$stock->id;
               $nqin=$qin + $quantity;
                $nbqty = $nqin- $qout;
        currentstock::where('id',$iid)
              ->update(['qnty_in'=>$nqin,
                       'bal_qnty'=>$nbqty]);
    }
   


 }
//////ACCOUNTS SETTELING ////////////////
  $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>date('Y-m-d'),'totdebit'=>$sinv->net_total,'totcredit'=>$sinv->net_total,'created_by'=>session('name'),'remarks'=>'Deleted'.$sinv->invoice_no,'approved_by'=>session('name'),'from_where'=>'Deleted Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$sinv->cus_accnt,'narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$sinv->net_total,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'47','narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$sinv->net_total,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////general A/c///////////////////////////////
  $sql1 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno1 =$sql1->slno;
 $nslno1 = $slno1 + 1;
 $no1 = 'Jr'.$nslno1;
 $data3= regularvoucherentry::Create(

['voucher_no'=>$no1,'slno'=>$nslno1,'keycode'=>'Jr','voucher'=>'4','dates'=>date('Y-m-d'),'totdebit'=>$sinv->totcosts,'totcredit'=>$sinv->totcosts,'created_by'=>session('name'),'remarks'=>'Deleted'.$sinv->invoice_no,'approved_by'=>session('name'),'from_where'=>'Deleted Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data3){
$data4= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'cred','account_name'=>'24','narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$sinv->totcosts,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data5= regularvoucherentrydetail::Create(
  ['voucherid'=>$data3->id,'debitcredit'=>'debt','account_name'=>'272','narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$sinv->totcosts,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>date('Y-m-d'),'totdebit'=>$profitpay1,'totcredit'=>$profitpay1,'created_by'=>session('name'),'remarks'=>'Deleted'.$sinv->invoice_no,'approved_by'=>session('name'),'from_where'=>'Deleted Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$sinv->exe_com_exp_ac,'narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$profitpay1,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$sinv->comm_pay_account,'narration'=>'Deleted'.$sinv->invoice_no,'amount'=>$profitpay1,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

$req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();  

}
function loaddoqnties(Request $req){
 $soqty=$req->reqqnty;
 $dlnids = explode(',', $req->dlnid);
 $itemmid =$req->itemid;
$rsrate=$req->rsrate;
$cost=$req->cost;
$action=$req->action;
   $doitem = DB::table('deliverynotes')
        ->leftJoin('deliverynotedetails', function ($join) use ($itemmid) {
            $join->on('deliverynotedetails.dln_id', '=', 'deliverynotes.id')
                ->where('deliverynotedetails.item_id', '=', $itemmid)
                 ->where('deliverynotedetails.bal_qnty', '!=', '0');
              })->whereIn('deliverynotes.id',$dlnids)
      ->select('deliverynotes.deli_note_no','deliverynotedetails.*')
     ->get();
$do=deliverynote::whereIn('id',$dlnids)->get();
  return view('inventory/sales/dotosinv',['doitem'=>$doitem,'soqty'=>$soqty,'do'=>$do,'itemmid'=>$itemmid,'rsrate'=>$rsrate,'cost'=>$cost,'action'=>$action]); 
    
}
function loaddortnqnties(Request $req){
 $soqty=$req->reqqnty;
 $dlnids = explode(',', $req->dlnid);
 $itemmid =$req->itemid;
 $rsrate=$req->rsrate;
 $cost=$req->cost;
 $action=$req->action;
   $doitem = DB::table('deliverynotes')
        ->leftJoin('deliverynotedetails', function ($join) use ($itemmid) {
            $join->on('deliverynotedetails.dln_id', '=', 'deliverynotes.id')
                ->where('deliverynotedetails.item_id', '=', $itemmid)
                 ->where('deliverynotedetails.inv_qnty', '!=', '0');
              })->whereIn('deliverynotes.id',$dlnids)
      ->select('deliverynotes.deli_note_no','deliverynotedetails.*')
     ->get();
$do=deliverynote::whereIn('id',$dlnids)->get();
  return view('inventory/sales/dortntosinv',['doitem'=>$doitem,'soqty'=>$soqty,'do'=>$do,'itemmid'=>$itemmid,'rsrate'=>$rsrate,'cost'=>$cost,'action'=>$action]); 
    
}

}
