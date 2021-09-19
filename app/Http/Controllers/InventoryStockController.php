<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\header;
use App\Models\privilege;
use App\Models\itemtype;
use App\Models\itemcategory;
use App\Models\itemmaster;
use App\Models\openingstock;
use App\Models\openingstockdetail;
use App\Models\unit;
use App\Models\vouchergeneration;
use App\Models\salesinvoice;
use App\Models\customer;
use App\Models\currentstock;
use App\Models\store;
use App\Models\stockissuedetail;
use App\Models\stockissue;
use App\Models\stockmovement;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\stocktransferdetail;
use App\Models\stocktransfer;
use App\Models\User;
use App\Models\projectdetail;
use App\Models\executive;
use App\Models\projectmaterialrequest;
use App\Models\projectmaterialrequestdetail;
use App\Models\projectmaterialissuedetail;
use App\Models\projectmaterialissue;
use App\Models\executivecommission;
use App\Models\projectexpenseentry;
use App\Models\projectexpenseentrydetail;
use App\Models\stockadjustmentdetail;
use App\Models\stockadjustment;
use App\Models\stockissuereturndetail;
use App\Models\stockissuereturn;
use App\Models\deliverynote;
use App\Models\projectinvoice;

use PDF;
use Validator;
use Carbon\Carbon;


class InventoryStockController extends Controller
{
    function getopening(){
    	$priv=privilege::select('pageid','user')
           ->where('pageid','51')
           ->where('user',session('id'))
           ->count();
    	   	if(session('id')!="" && ($priv >0)){
    	   		$type = itemtype::all();
                $store=store::all();
    	   		$cats = itemcategory::orderBy('category','Asc')->get();




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
return view('inventory/stock/opening',['type'=>$type,'cats'=>$cats,'store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
    	   	}
    	   	else{
                  return redirect('/'); 
                 }


    }

    function getallitems(Request $req){
    	 $items = itemmaster::leftJoin('openingstockdetails', function($join) {
      $join->on('openingstockdetails.item_id', '=', 'itemmasters.id');
         })->where('itemmasters.category',$req->id)
    	         ->select('itemmasters.id','itemmasters.item','itemmasters.basic_unit','itemmasters.cost','openingstockdetails.opening_qnty','openingstockdetails.opening_rate','openingstockdetails.stock_value')
    	         ->orderBy('item','asc')->get();
 return view('inventory/stock/itemsopening',['items'=>$items]);

    }
    function createopening(Request $req){
 $dates=$req->input('issue_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
   $rtn = openingstock::updateOrCreate(
  ['location_id'=>$req->input('location'),'category_id'=>$req->input('category'),],
['itemtype'=>$req->input('itemtype'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
   if(isset($rtn)){
 $item_id=$req->itemid;
      $unit = $req->unit;
        $batch=$req->batch;
        $opening_qnty=$req->qnty;
        $opening_rate=$req->rate;
        $exp_date=$req->expirydate;
        $inward_date=$req->inwarddate;
        $stock_value=$req->amount;
       
       $count =count($item_id);
for ($i=0; $i < $count; $i++){
     $nddate = Carbon::parse($exp_date[$i])->format('Y-m-d');
     $nddate1 = Carbon::parse($inward_date[$i])->format('Y-m-d');
if(!empty($opening_qnty[$i])){
    openingstockdetail::updateOrCreate(['item_id'=>$item_id[$i],],
  ['opening_id'=>$rtn->id,
   'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'opening_qnty'=>$opening_qnty[$i],
  'opening_rate'=>$opening_rate[$i],
  'exp_date'=>$nddate,
  'inward_date'=>$nddate1,
  'stock_value'=>$stock_value[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
 // if($rqnty[$j] !="0"){

 stockmovement::UpdateorCreate(['voucher_type'=>'Opening Stock','description'=>'Opening Stock of '.now()->year.$item_id[$i],],
  ['voucher_id'=>'43','voucher_date'=>$nddate1,'location_id'=>$req->input('location'),'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$opening_rate[$i],'quantity'=>$opening_qnty[$i],'stock_value'=>$stock_value[$i],'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

        $ccur1 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqin1 =   $opening_qnty[$i] + $ccur2->qnty_in; 
               $nbalqnty =$nqin1 -$ccur2->qnty_out;
               currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->update(['qnty_in'=>$nqin1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$item_id[$i],
               'batch'=>$batch[$i],
               'location_id'=>$req->input('location'),
               'qnty_in'=>$opening_qnty[$i],
               'bal_qnty'=>$opening_qnty[$i] ]);
               
               }
            
          
}
}
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/opening-stock');
}


    }
    function getstock(Request $req){
        $priv=privilege::select('pageid','user')
           ->where('pageid','43')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','43')
              ->select('slno','constants')->first();  
  $slno=stockissue::select('slno')
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
$datas =    stockissue::leftJoin('customers', function($join) {
      $join->on('stockissues.issue_to', '=', 'customers.id');
         })->select('stockissues.id','stockissues.issue_no','stockissues.issue_date','customers.name','stockissues.issue_for','stockissues.is_returned')
->orderBy('stockissues.id','desc')
          ->get();
$customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
          $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
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
        return view('inventory/stock/getstock',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'customer'=>$customer,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
    }

function currentstockissue(Request $req){
    $item = $req->itemid;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id')
           ->get();
  return view('inventory/stock/currentstockissueview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm]);  

}
function currentstockiisuevieww(Request $req){
     $item = itemmaster::select('itemmasters.id','itemmasters.code','itemmasters.item','itemmasters.basic_unit','itemmasters.cost')
          ->find($req->itemid);
 $rowCount= $req->rowCount;
  $totqnty=$req->totqnty; 
  $amt =$totqnty *$item->cost;
   
    $stock = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$req->itemid)
                ->where('currentstocks.bal_qnty','!=','0.000')
                ->select('currentstocks.location_id','currentstocks.batch','stores.locationname')->first();
return view('inventory/stock/stockgridview',['item'=>$item,'stock'=>$stock,'rowCount'=>$rowCount,'totqnty'=>$totqnty,'amt'=>$amt]);

}
function createstockissue(Request $req){
$validator =  $req ->validate([
                'issue_no'=>'required',
                'item_id'=>'required',
                'issue_to'=>'required',
                'issue_qnty'=>'required'],
   [ 'issue_no.required'    => 'Sorry,Please generate an Issue number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'issue_to.required'  => 'Sorry,Please select a customer, Thank You.',
       'issue_qnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
    $dates=$req->input('issue_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
   $rtn = stockissue::updateOrCreate(
  ['issue_no'=>$req->input('issue_no')],
['slno'=>$req->input('slno'),'issue_date'=>$nddate,'issue_to'=>$req->input('issue_to'),'issue_for'=>$req->input('issue_for'),'total_amount'=>$req->input('total_amount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
   if(isset($rtn)){
 $item_id=$req->item_id;
      $item_code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $batch=$req->batch;
        $rate=$req->rate;
        $batch=$req->batch;
        $issue_qnty=$req->issue_qnty;
        $stockissue_value=$req->stockissue_value;
       $count =count($item_id);
for ($i=0; $i < $count; $i++){
    stockissuedetail::Create(
  ['item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'stockissue_id'=>$rtn->id,
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'issue_qnty'=>$issue_qnty[$i],
  'pen_qnty'=>$issue_qnty[$i],
  'rate'=>$rate[$i],
  'stockissue_value'=>$stockissue_value[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);

}
////// Stock Movement ////////////////////////////
     $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $cqnty =$req->cqnty;
   $cost =$req->cost;
   $counts =count($idid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $ncqnty =$cqnty[$j]-$rqnty[$j];
 if($rqnty[$j] !="0"){
 stockmovement::Create(
  ['voucher_id'=>'43','voucher_type'=>'Stock Issue','voucher_date'=>$nddate,'description'=>$req->input('issue_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 $ccur =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->select('qnty_out')->first();
            $nqout =   $rqnty[$j] + $ccur->qnty_out;
 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqout,
                       'bal_qnty'=>$ncqnty]);
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
 if($req->input('issue_for')=='Rental'){
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Stock Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'273','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }            

}
elseif($req->input('issue_for')=='Maintenance'){
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Stock Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'274','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }    
}
elseif($req->input('issue_for')=='ScrapOut' || $req->input('issue_for')=='Sample'){
 $data= regularvoucherentry::Create(


['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Stock Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'275','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
 elseif($req->input('issue_for')=='OfficeOverhead')
 {
     $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Stock Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'276','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 }else{

 }
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/stock-issues');
}

}
function editstock($id,Request $req){
            $priv=privilege::select('pageid','user')
           ->where('pageid','43')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
            ////Popups////////////
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
              /////////////////////////////
   
$datas =    stockissue::leftJoin('customers', function($join) {
      $join->on('stockissues.issue_to', '=', 'customers.id');
         })->select('stockissues.id','stockissues.issue_no','stockissues.issue_date','customers.name','stockissues.issue_for','stockissues.is_returned')
->orderBy('stockissues.id','desc')
          ->get();
$customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();




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
         $stockkk =stockissue::with('stockissuedetail')->find($id);       
        return view('inventory/stock/editstock',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'customer'=>$customer,'datas'=>$datas,'stockkk'=>$stockkk,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function gettransfer(Request $req){
        $priv=privilege::select('pageid','user')
           ->where('pageid','45')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','45')
              ->select('slno','constants')->first();  
  $slno=stocktransfer::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno) && !empty($voucher->constants)){
  $nslno=$voucher->slno;
}else{

$nslno="";
}
$datas =    stocktransfer::with('stocktransferdetail')->leftJoin('stores', function($join) {
      $join->on('stocktransfers.transfer_to', '=', 'stores.id');
         })->select('stocktransfers.*','stores.locationname')->orderBy('stocktransfers.id','desc')
          ->get();
          $store=store::orderBy('id','asc')->get();

          $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
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
        return view('inventory/stock/stocktransfer',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}

function createtransfer(Request $req){
    $validator =  $req ->validate([
                'transfer_no'=>'required',
                'item_id'=>'required',
                'transfer_to'=>'required',
                'issue_qnty'=>'required'],
   [ 'transfer_no.required'    => 'Sorry,Please generate an Transfer number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'transfer_to.required'  => 'Sorry,Please select a location, Thank You.',
       'issue_qnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
    $dates=$req->input('transfer_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
   $rtn = stocktransfer::updateOrCreate(
  ['transfer_no'=>$req->input('transfer_no')],
['slno'=>$req->input('slno'),'transfer_date'=>$nddate,'transfer_to'=>$req->input('transfer_to'),'remarks'=>$req->input('remarks'),'total_amount'=>$req->input('total_amount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
   if(isset($rtn)){
 $item_id=$req->item_id;
      $item_code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $batch=$req->batch;
        $rate=$req->rate;
        $batch=$req->batch;
        $issue_qnty=$req->issue_qnty;
        $stockissue_value=$req->stockissue_value;
       $count =count($item_id);
for ($i=0; $i < $count; $i++){
    stocktransferdetail::Create(
  ['item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'transfer_id'=>$rtn->id,
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'qnty'=>$issue_qnty[$i],
  
  'rate'=>$rate[$i],
  'stock_value'=>$stockissue_value[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);

}
////// Stock Movement ////////////////////////////
     $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $cqnty =$req->cqnty;
   $cost =$req->cost;
   $counts =count($idid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $ncqnty =$cqnty[$j]-$rqnty[$j];
   if($rqnty[$j] !="0"){
 stockmovement::Create(
  ['voucher_id'=>'43','voucher_type'=>'Stock Transfer','voucher_date'=>$nddate,'description'=>$req->input('transfer_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 stockmovement::Create(
  ['voucher_id'=>'43','voucher_type'=>'Stock Transfer','voucher_date'=>$nddate,'description'=>$req->input('transfer_no'),'location_id'=>$req->input('transfer_to'),'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'quantity'=>$rqnty[$j],'stock_value'=>$amt,'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 $ccur =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->select('qnty_out')->first();
            $nqout =   $rqnty[$j] + $ccur->qnty_out;

 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqout,
                       'bal_qnty'=>$ncqnty]);
        $ccur1 =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('transfer_to'))
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('transfer_to'))
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqout1 =   $rqnty[$j] + $ccur2->qnty_in; 
               $nbalqnty =$nqout1 -$ccur2->qnty_out;
               currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('transfer_to'))
               ->update(['qnty_in'=>$nqout1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$idid[$j],
               'batch'=>$batches[$j],
               'location_id'=>$req->input('transfer_to'),
               'qnty_in'=>$rqnty[$j],
               'bal_qnty'=>$rqnty[$j] ]);
               
               }
            
               }
           }
                $req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/stock-transfer');
           }

}
function edittransfer($id,Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','45')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
              $datas =    stocktransfer::with('stocktransferdetail')->leftJoin('stores', function($join) {
      $join->on('stocktransfers.transfer_to', '=', 'stores.id');
         })->select('stocktransfers.*','stores.locationname')->orderBy('stocktransfers.id','desc')
          ->get();
          $store=store::orderBy('id','asc')->get();

          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();




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
          $tran =stocktransfer::with('stocktransferdetail')->find($id);      
        return view('inventory/stock/stocktransferedit',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'datas'=>$datas,'store'=>$store,'tran'=>$tran,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function getmatissue(Request $req){
   $priv=privilege::select('pageid','user')
           ->where('pageid','34')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','34')
              ->select('slno','constants')->first();  
  $slno=projectmaterialissue::select('slno')
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
$datas =    projectmaterialissue::leftJoin('projectdetails', function($join) {
      $join->on('projectmaterialissues.project_id', '=', 'projectdetails.id');
         })->select('projectmaterialissues.*','projectdetails.project_code')
->orderBy('projectmaterialissues.id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();




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
        return view('inventory/stock/projectmaterialissue',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function alldetails(Request $req){
    $pro =projectdetail::leftJoin('customers', function($join) {
      $join->on('projectdetails.customer_id', '=', 'customers.id');
         })->where('projectdetails.id',$req->pid)
       ->select('projectdetails.*','customers.name')->first();
    $exe =executive::where('short_name',$pro->executive)->first();
  $matreq =projectmaterialrequest::where('project_id',$req->pid)
 ->select('id','matreq_no')->where('status','!=','1')->get();
 $action=$req->action;
return view('inventory/stock/getallprodet',['pro'=>$pro,'exe'=>$exe,'matreq'=>$matreq,'action'=>$action]);

}
function getmatreqdetails(Request $req){
  $matreq =projectmaterialrequestdetail::leftJoin('itemmasters', function($join) {
      $join->on('projectmaterialrequestdetails.item_id', '=', 'itemmasters.id');
         })->where('projectmaterialrequestdetails.matreq_id',$req->reqno)
           ->where('projectmaterialrequestdetails.bal_qnty','!=','0')
         ->select('projectmaterialrequestdetails.*','itemmasters.cost')
        ->get();
return view('inventory/stock/matreqtogrid',['matreq'=>$matreq]);        
}
function getcurrentstockmatreq(Request $req){
    $item = $req->itemid;
 $soqty=$req->reqqnty;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id')
           ->get();
  return view('inventory/stock/currentstockreqview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm,'soqty'=>$soqty]);  

}
function createproissue(Request $req){
 $validator =  $req ->validate([
                'issue_no'=>'required',
                'project_id'=>'required',
                'executive'=>'required',
                'commission_percentage'=>'required',
                'comm_pay_account'=>'required',
                'exe_com_exp_ac'=>'required'],
   ['issue_no.required'    => 'Sorry,Please generate an issue number, Thank You.',
    'project_id.required'  => 'Sorry,Please select a project code, Thank You.',
    'executive.required'   => 'Sorry,executive is required, Thank You.',
   'commission_percentage.required'=> 'Sorry, Executive percentage is missing.',
       'comm_pay_account.required'=> 'Sorry, Executive account is missing.',
       'exe_com_exp_ac.required'   => 'Sorry, Executive account is missing.'
        ]);
   $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = projectmaterialissue::updateOrCreate(
  ['issue_no'=>$req->input('issue_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'project_id'=>$req->input('project_id'),'customer'=>$req->input('customer'),'customerpo'=>$req->input('customerpo'),'executive'=>$req->input('executive'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'requisitionid'=>$req->input('requisitionid'),'issue_from'=>$req->input('issue_from'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'total_amount'=>$req->input('total_amount'),'customer_id'=>$req->input('customer_id')]);
  $profit = 0 - $req->input('total_amount') ;
  $percent =$req->input('commission_percentage');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 =$profitpay * (-1);
  if(isset($enquiry)){
    $mainid=$req->mainid;
      $item_id=$req->item_id;
      $item_code = $req->item_code;
      $item=$req->item;
      $unit=$req->unit;
      $batch=$req->batch;
      $reqq_qnty=$req->reqq_qnty;
      $issue_qnty=$req->issue_qnty;
      $rate=$req->rate;
      $total=$req->total;
      $count =count($item);
        for ($i=0; $i < $count; $i++){
  $bnd =projectmaterialissuedetail::Create(
  ['matreqid'=>$mainid[$i],
  'issue_id'=>$enquiry->id,
  'item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'item'=>$item[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'req_qnty'=>$reqq_qnty[$i],
  'issue_qnty'=>$issue_qnty[$i],
  'pen_qnty'=>$issue_qnty[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   
   
   /////Mat req Reduction///////////////////
$qtnn = projectmaterialrequestdetail::where('id',$mainid[$i])->first();
$qnty = $qtnn->req_qnty;
$matreq_id =$qtnn->matreq_id;
$sqnty = $qtnn->iss_qnty;
$bqnty = $qtnn->bal_qnty;
$totiss = $issue_qnty[$i] + $sqnty; 
  $cqnty = $qnty-$totiss ;
   $upenquiry = projectmaterialrequestdetail::where('id',$mainid[$i])
             ->update(['iss_qnty'=>$totiss,'bal_qnty'=>$cqnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
        
          $senq = projectmaterialrequestdetail::where('matreq_id',$matreq_id)
                 ->where('bal_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = projectmaterialrequest::where('id',$matreq_id)
             ->update(['status'=>'1']);
 
   }
   else{
    $upenquiry = projectmaterialrequest::where('id',$matreq_id)
             ->update(['status'=>'2']);
   }
}

     //////Executive Commission////////////////
   $exee = executivecommission::Create(
  ['invoice_no'=>$req->input('issue_no'),
'customer'=>$req->input('customer_id'),'executive'=>$req->input('executive'),'percent'=>$req->input('commission_percentage'),'totcost'=>$req->input('total_amount'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'ProjMatIssue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate]);
 //////Stockmovement//////
    $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $cqnty =$req->cqnty;
   $cost =$req->cost;
       $counts =count($idid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $ncqnty =$cqnty[$j]-$rqnty[$j];
   if($rqnty[$j] !="0"){

 stockmovement::Create(
  ['voucher_id'=>'34','voucher_type'=>'Project Material Issue','voucher_date'=>$nddate,'description'=>$req->input('issue_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $ccur =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->select('qnty_out')->first();
            $nqout =   $rqnty[$j] + $ccur->qnty_out;
 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqout,
                       'bal_qnty'=>$ncqnty]);

}
}
/////////////// Project Expense Entry ///////////////
$exxp =projectexpenseentry::orderBy('id','desc')->take('1')->first();
if(!empty($exxp)){
$slno1 =$exxp->slno;
$slno2 =$slno1 + 1;
$key =$exxp->keycode;
}else{
 $slno2 =1; 
 $key ='PR- EXP -'  ;
}
$nslmo=$key.$slno2;
$exp = projectexpenseentry::updateOrCreate(
  ['entry_no'=>$nslmo],
['slno'=>$slno2,'dates'=>$nddate,'keycode'=>$key,'executive'=>$req->input('executive'),'paymentmode'=>'credit','expense_type'=>'1','totalamount'=>$req->input('total_amount'),'balanceamount'=>$req->input('total_amount'),'remarks'=>'FromMaterialIssue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'expensefrom'=>'1']);
if(isset($enquiry)){
$epdet =projectexpenseentrydetail::Create(
  ['projectcode'=>$req->input('project_code'),
  'expense_id'=>$exp->id,
  'projectid'=>$req->input('project_id'),
  'projectname'=>$req->input('project_name'),
  'customerid'=>$req->input('customer_id'),
  'customer'=>$req->input('customer'),
  'executive'=>$req->input('executive'),
  'amount'=>$req->input('total_amount'),
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Project Material Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'27','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'272','narration'=>$req->input('issue_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
   //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$profitpay1,'totcredit'=>$profitpay1,'created_by'=>session('name'),'remarks'=>$req->input('issue_no'),'approved_by'=>session('name'),'from_where'=>'Project Material Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>$req->input('issue_no'),'amount'=>$profitpay1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('comm_pay_account'),'narration'=>$req->input('issue_no'),'amount'=>$profitpay1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/material-issue'); 
}
}
function editmatissue($id,Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','34')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','34')
              ->select('slno','constants')->first();  
  $slno=projectmaterialissue::select('slno')
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
$datas =    projectmaterialissue::leftJoin('projectdetails', function($join) {
      $join->on('projectmaterialissues.project_id', '=', 'projectdetails.id');
         })->select('projectmaterialissues.*','projectdetails.project_code')
->orderBy('projectmaterialissues.id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();
         $iss =projectmaterialissue::with('projectmaterialissuedetail')->find($id); 
         $reqq =projectmaterialrequest::where('id',$iss->requisitionid)
                ->select('matreq_no')->first();


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
        return view('inventory/stock/projectmaterialissueedit',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'iss'=>$iss,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'reqq'=>$reqq]);
}
           else{
                  return redirect('/'); 
                 }



}
function eprintmatissue($id,Request $req){
 $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = projectmaterialissue::with('projectmaterialissuedetail')->leftJoin('projectmaterialrequests', function($join) {
      $join->on('projectmaterialissues.requisitionid', '=', 'projectmaterialrequests.id');
         })->leftJoin('projectdetails', function($joins) {
      $joins->on('projectmaterialissues.project_id', '=', 'projectdetails.id');
         })->select('projectmaterialissues.*','projectmaterialrequests.matreq_no','projectmaterialrequests.req_by','projectdetails.project_code')
->where('projectmaterialrequests.id',$id)
   ->first();
  
 // return view('inventory/stock/matissue_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/stock/matissue_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('MaterialIssue.pdf');

}
function printmatissue(Request $req){
 $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = projectmaterialissue::with('projectmaterialissuedetail')->leftJoin('projectmaterialrequests', function($join) {
      $join->on('projectmaterialissues.requisitionid', '=', 'projectmaterialrequests.id');
         })->leftJoin('projectdetails', function($joins) {
      $joins->on('projectmaterialissues.project_id', '=', 'projectdetails.id');
         })->select('projectmaterialissues.*','projectmaterialrequests.matreq_no','projectmaterialrequests.req_by','projectdetails.project_code')
->orderBy('projectmaterialrequests.id','desc')
   ->take('1')->first();
  
 // return view('inventory/stock/matissue_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/stock/matissue_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('MaterialIssue.pdf');

}
function getstockadjst(Request $req){
  $priv=privilege::select('pageid','user')
           ->where('pageid','53')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','53')
              ->select('slno','constants')->first();  
  $slno=stockadjustment::select('slno')
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
$datas =    stockadjustment::leftJoin('stores', function($join) {
      $join->on('stockadjustments.location', '=', 'stores.id');
         })->select('stockadjustments.*','stores.locationname')
->orderBy('stockadjustments.id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
         ->get();
                 $store=store::orderBy('id','asc')->get();
            



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
        return view('inventory/stock/stockadjustment',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function createadjustment(Request $req){
    $validator =  $req ->validate([
                'voucher_no'=>'required',
                'item_id'=>'required',
                'location'=>'required',
                'issue_qnty'=>'required'],
   [ 'voucher_no.required'    => 'Sorry,Please generate an  number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'location.required'  => 'Sorry,Please select a location, Thank You.',
       'issue_qnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
    $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
   $rtn = stockadjustment::updateOrCreate(
  ['voucher_no'=>$req->input('voucher_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'location'=>$req->input('location'),'remarks'=>$req->input('remarks'),'total_amount'=>$req->input('total_amount'),'voucher_type'=>$req->input('voucher_type'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
   if(isset($rtn)){
 $item_id=$req->item_id;
      $item_code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $batch=$req->batch;
        $rate=$req->rate;
        $batch=$req->batch;
        $issue_qnty=$req->issue_qnty;
        $stockissue_value=$req->stockissue_value;
       $count =count($item_id);
for ($i=0; $i < $count; $i++){
    stockadjustmentdetail::updateOrCreate(['stockid'=>$rtn->id,],
  ['item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'item'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'qnty'=>$issue_qnty[$i],
  'rate'=>$rate[$i],
  'stock_value'=>$stockissue_value[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);

}
////// Stock Movement ////////////////////////////
 $idid=$req->itemid;
   $locid =$req->locid;
   $batches =$req->batches;
   $rqnty =$req->reqqnty;
   $cqnty =$req->cqnty;
   $cost =$req->cost;
   $counts =count($idid);
for ($j=0; $j < $counts; $j++){
  $amt =$rqnty[$j] * $cost[$j];
   $ncqnty =$cqnty[$j]-$rqnty[$j];
   if($rqnty[$j] !="0"){
if($req->input('voucher_type')=='addstock'){
     stockmovement::Create(
  ['voucher_id'=>'53','voucher_type'=>'Stock Adjustment','voucher_date'=>$nddate,'description'=>$req->input('voucher_no'),'location_id'=>$req->input('location'),'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'quantity'=>$rqnty[$j],'stock_value'=>$amt,'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$ccur1 =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 > 0){
               $nqout1 =   $rqnty[$j] + $ccur2->qnty_in; 
               $nbalqnty =$nqout1 -$ccur2->qnty_out;
               currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$req->input('location'))
               ->update(['qnty_in'=>$nqout1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$idid[$j],
               'batch'=>$batches[$j],
               'location_id'=>$req->input('location'),
               'qnty_in'=>$rqnty[$j],
               'bal_qnty'=>$rqnty[$j] ]);
               
               }

}else{
    
 stockmovement::Create(
  ['voucher_id'=>'53','voucher_type'=>'Stock Adjustment','voucher_date'=>$nddate,'description'=>$req->input('voucher_no'),'location_id'=>$locid[$j],'item_id'=>$idid[$j],'batch'=>$batches[$j],'rate'=>$cost[$j],'qntyout'=>$rqnty[$j],'stockout'=>$amt,'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 $ccur =currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->select('qnty_in','qnty_out')->first();
            $nqout =   $rqnty[$j] + $ccur->qnty_out;

 currentstock::where('item_id',$idid[$j])
               ->where('batch',$batches[$j])
               ->where('location_id',$locid[$j])
               ->update(['qnty_out'=>$nqout,
                       'bal_qnty'=>$ncqnty]);
        
            
               }
           }
       }
                $req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/stock-adjustment');
           }
}
function getcurrentstockadj(Request $req){
 $item = $req->itemid;
 $type =$req->type;
 $itemm=itemmaster::select('cost')->where('id',$item)->first();
 if($type=='addstock'){
 $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id')
           ->get();
       }else{
        $curitem = currentstock::leftJoin('stores', function($join) {
      $join->on('currentstocks.location_id', '=', 'stores.id');
         })->where('currentstocks.item_id',$item)
          ->where('currentstocks.bal_qnty','!=','0.000')
           ->select('currentstocks.batch','stores.locationname','currentstocks.bal_qnty','currentstocks.location_id')
           ->get();
       }
  return view('inventory/stock/currentstockadjview',['item'=>$item,'curitem'=>$curitem,'itemm'=>$itemm,'type'=>$type]); 
}
function editstockadjs($id,Request $req){
  $priv=privilege::select('pageid','user')
           ->where('pageid','53')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','53')
              ->select('slno','constants')->first();  
  $slno=stockadjustment::select('slno')
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
$datas =    stockadjustment::leftJoin('stores', function($join) {
      $join->on('stockadjustments.location', '=', 'stores.id');
         })->select('stockadjustments.*','stores.locationname')
->orderBy('stockadjustments.id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();
                 $store=store::orderBy('id','asc')->get();
        $adjs =stockadjustment::with('stockadjustmentdetail')->find($id);




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
        return view('inventory/stock/stockadjustmentedit',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'store'=>$store,'adjs'=>$adjs,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function printadjst(Request $req){
$cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = stockadjustment::with('stockadjustmentdetail')
->orderBy('id','desc')
   ->take('1')->first();
  
 //return view('inventory/stock/stockadjs_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/stock/stockadjs_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('StockAdjustment.pdf');
}
function eprintadjst($id,Request $req){
$cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = stockadjustment::with('stockadjustmentdetail')
->find($id);
  
 //return view('inventory/stock/stockadjs_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/stock/stockadjs_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('StockAdjustment.pdf');
}
function getissuertn(Request $req){
  $priv=privilege::select('pageid','user')
           ->where('pageid','44')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','44')
              ->select('slno','constants')->first();  
  $slno=stockissuereturn::select('slno')
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
$datas =    stockissuereturn::orderBy('id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();
                 $store=store::orderBy('id','asc')->get();




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
        return view('inventory/stock/stockissuereturn',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function issuedetails(Request $req){
    $stock=$req->itemid;
    if($stock == 'StockIssue'){
 $datas =stockissue::select('id','issue_no')
        ->where('is_returned','!=','1')
        ->where('is_deleted','0')
        ->orderBy('id','desc')
          ->get();

    }else{
      $datas =projectmaterialissue::select('id','issue_no')
        ->where('is_returned','!=','1')
        ->where('is_deleted','0')
        ->orderBy('id','desc')
          ->get();   
    }
$output="";
$output .= '<option value="" hidden>Issue No</option>';
foreach($datas as $data){

    $output .= '<option value="'.$data->id.'" >'.$data->issue_no.'</option>';
}
echo $output;
}
function allissuedetails(Request $req){
     $stock=$req->stock;
    $issueid =$req->issueid;
if($stock == 'StockIssue'){
 $datas =stockissue::with('stockissuedetail')
        ->where('id',$issueid)
        ->first();  
}else{
  $datas =projectmaterialissue::with('projectmaterialissuedetail')->leftJoin('projectdetails', function($join) {
      $join->on('projectmaterialissues.project_id', '=', 'projectdetails.id');
         })->select('projectmaterialissues.*','projectdetails.project_code','projectdetails.project_name')
        ->where('projectmaterialissues.id',$issueid)
        ->first();


}
return view('inventory/stock/gridissuereturn',['datas'=>$datas,'stock'=>$stock]);
}
function createissurtn(Request $req){
 $validator =  $req ->validate([
                'issuertn_no'=>'required',
                 'location'=>'required',
                'stockissueno'=>'required',
                // 'issueacc'=>'required',
                // 'commission_percentage'=>'required',
                // 'comm_pay_account'=>'required',
                // 'exe_com_exp_ac'=>'required'
            ],
   [ 'issuertn_no.required'    => 'Sorry,Please generate an issue rtn number, Thank You.',
    'location.required'  => 'Sorry,Please select a location, Thank You.',
       'stockissueno.required'   => 'Sorry,Issue No is required, Thank You.',
       // 'issueacc.required'=> 'Sorry, Customer account is missing.',
       // 'commission_percentage.required'=> 'Sorry, Executive percentage is missing.',
       // 'comm_pay_account.required'=> 'Sorry, Executive account is missing.',
       // 'exe_com_exp_ac.required'   => 'Sorry, Executive account is missing.'
        ]);
   $dates=$req->input('issuertn_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = stockissuereturn::updateOrCreate(
  ['issuertn_no'=>$req->input('issuertn_no')],
['slno'=>$req->input('slno'),'issuertn_date'=>$nddate,'location'=>$req->input('location'),'return_type'=>$req->input('return_type'),'stockissueno'=>$req->input('stockissueno'),'issuertn_from'=>$req->input('issuertn_from'),'remarks'=>$req->input('remarks'),'total_amount'=>$req->input('total_amount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $profit = $req->input('total_amount') ;
  $percent =$req->input('commission_percentage');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 =$profitpay ;
     if(isset($enquiry)){
      $item_id=$req->item_id;
      $item_code = $req->item_code;
      $item_name=$req->item;
      $unit=$req->unit;
      $batch=$req->batch;
      $rate=$req->rate;
      $issqnty=$req->pen_qnty;
      $rtnqnty=$req->rtn_qnty;
      $total=$req->amount;
      $issue_id=$req->issue_id;
      $iissue_qnty=$req->iissue_qnty;
      $irtn_qnty=$req->irtn_qnty;
      $mainid=$req->mainid;
      $count =count($item_id);
for ($i=0; $i < $count; $i++){
    stockissuereturndetail::Create(
  ['item_id'=>$item_id[$i],
  'item_code'=>$item_code[$i],
  'stissrtn_id'=>$enquiry->id,
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'issqnty'=>$issqnty[$i],
  'rtnqnty'=>$rtnqnty[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
////// Stock return/////////////////
if($req->input('return_type')=='StockIssue'){
$nrtnqnty =$irtn_qnty[$i] + $rtnqnty[$i];
$npqnty =$iissue_qnty[$i] -$nrtnqnty;
 $upenquiry = stockissuedetail::where('id',$issue_id[$i])
             ->update(['rtn_qnty'=>$nrtnqnty,'pen_qnty'=>$npqnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
        
          $senq = stockissuedetail::where('stockissue_id',$mainid[$i])
                 ->where('pen_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = stockissue::where('id',$mainid[$i])
             ->update(['is_returned'=>'1']);
 
   }
   else{
    $upenquiry = stockissue::where('id',$mainid[$i])
             ->update(['is_returned'=>'2']);
   }
}
////// Mat return/////////////////
if($req->input('return_type')=='MatIssue'){
$nrtnqnty =$irtn_qnty[$i] + $rtnqnty[$i];
$npqnty =$iissue_qnty[$i] -$nrtnqnty;
 $upenquiry = projectmaterialissuedetail::where('id',$issue_id[$i])
             ->update(['rtn_qnty'=>$nrtnqnty,'pen_qnty'=>$npqnty,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
        
          $senq = projectmaterialissuedetail::where('issue_id',$mainid[$i])
                 ->where('pen_qnty','!=','0')->count();
    
 if($senq < 1){
  $upenquiry = projectmaterialissue::where('id',$mainid[$i])
             ->update(['is_returned'=>'1']);
 
   }
   else{
    $upenquiry = projectmaterialissue::where('id',$mainid[$i])
             ->update(['is_returned'=>'2']);
   }
}

////// Stock Movement//////////////////
    stockmovement::Create(
  ['voucher_id'=>'44','voucher_type'=>'Stock Issue Return','voucher_date'=>$nddate,'description'=>$req->input('issuertn_no'),'location_id'=>$req->input('location'),'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$rate[$i],'quantity'=>$rtnqnty[$i],'stock_value'=>$total[$i],'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$ccur1 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqout1 =   $rtnqnty[$i] + $ccur2->qnty_in; 
               $nbalqnty =$nqout1 -$ccur2->qnty_out;
               currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('location'))
               ->update(['qnty_in'=>$nqout1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$item_id[$i],
               'batch'=>$batch[$i],
               'location_id'=>$req->input('location'),
               'qnty_in'=>$rtnqnty[$i],
               'bal_qnty'=>$rtnqnty[$i] ]);
               
               }
}
if($req->input('return_type')=='MatIssue'){
//////Executive Commission////////////////
    $ammmmt = (-1)*$req->input('total_amount');
   $exee = executivecommission::Create(
  ['invoice_no'=>$req->input('issuertn_no'),
'customer'=>$req->input('customer_id'),'executive'=>$req->input('executive'),'percent'=>$req->input('commission_percentage'),'total_amount'=>$req->input('total_amount'),'net_total'=>$req->input('total_amount'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'Issue Return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate]);
/////////////// Project Expense Entry Return ///////////////
$exxp =projectexpenseentry::orderBy('id','desc')->take('1')->first();
if(!empty($exxp)){
$slno1 =$exxp->slno;
$slno2 =$slno1 + 1;
$key =$exxp->keycode;
}else{
 $slno2 =1; 
 $key ='PR- EXP -'  ;
}
$nslmo=$key.$slno2;
$exp = projectexpenseentry::updateOrCreate(
  ['entry_no'=>$nslmo],
['slno'=>$slno2,'dates'=>$nddate,'keycode'=>$key,'executive'=>$req->input('executive'),'paymentmode'=>'credit','expense_type'=>'1','totalamount'=>$ammmmt,'balanceamount'=>$ammmmt,'remarks'=>'FromMaterialIssueReturn','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'expensefrom'=>'2']);
if(isset($enquiry)){
$epdet =projectexpenseentrydetail::Create(
  ['projectcode'=>$req->input('project_code'),
  'expense_id'=>$exp->id,
  'projectid'=>$req->input('project_id'),
  'projectname'=>$req->input('project_name'),
  'customerid'=>$req->input('customer_id'),
  'customer'=>$req->input('customer'),
  'executive'=>$req->input('executive'),
  'amount'=>$ammmmt,
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issuertn_no'),'approved_by'=>session('name'),'from_where'=>'Project Material Issue Return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'27','narration'=>$req->input('issuertn_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'272','narration'=>$req->input('issuertn_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
   //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$profitpay1,'totcredit'=>$profitpay1,'created_by'=>session('name'),'remarks'=>$req->input('issuertn_no'),'approved_by'=>session('name'),'from_where'=>'Project Material Issue Return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>$req->input('issuertn_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('comm_pay_account'),'narration'=>$req->input('issuertn_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
if($req->input('return_type')=='StockIssue'){
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
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('total_amount'),'totcredit'=>$req->input('total_amount'),'created_by'=>session('name'),'remarks'=>$req->input('issuertn_no'),'approved_by'=>session('name'),'from_where'=>'Stock Issue','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'272','narration'=>$req->input('issuertn_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$req->input('issueacc'),'narration'=>$req->input('issuertn_no'),'amount'=>$req->input('total_amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }            


    }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/stock-issue-return');
}
}
function editissuertn(Request $req,$id){
  $priv=privilege::select('pageid','user')
           ->where('pageid','44')
           ->where('user',session('id'))
           ->count();
          if(session('id')!="" && ($priv > 0)){
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
               $voucher  = vouchergeneration::where('voucherid','44')
              ->select('slno','constants')->first();  
  $slno=stockissuereturn::select('slno')
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
$datas =    stockissuereturn::orderBy('id','desc')
          ->get();
$user =User::where('login_name',session('name'))
->select('executive')->first();
$pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get(); 
          $item = itemmaster::select('id','item','basic_unit','code','part_no')
                 ->orderBy('item','asc')->get();
                 $store=store::orderBy('id','asc')->get();
        $rtns =stockissuereturn::with('stockissuereturndetail')->find($id); 
if($rtns->return_type=='MatIssue'){
    $mat =projectmaterialissue::where('id',$rtns->stockissueno)
          ->select('issue_no')->first();
}else{
$mat =stockissue::where('id',$rtns->stockissueno)
          ->select('issue_no')->first();
}



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
        return view('inventory/stock/stockissuereturnedit',['item'=>$item,'units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'store'=>$store,'rtns'=>$rtns,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'mat'=>$mat]);
}
           else{
                  return redirect('/'); 
                 }

}
function printissuertn(Request $req){
$cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = stockissuereturn::with('stockissuereturndetail')
->orderBy('id','desc')
->take('1')
   ->first();
   if($data->return_type=='MatIssue'){
    $datt =projectmaterialissue::find($data->stockissueno);
   }
   else{
    $datt =stockissue::find($data->stockissueno);
   }
  
 //return view('inventory/stock/issuertn_view',['cmpid'=>$cmpid,'data'=>$data,'datt'=>$datt]);
$pdf = PDF::loadView('inventory/stock/issuertn_view',['cmpid'=>$cmpid,'data'=>$data,'datt'=>$datt]);
return $pdf->download('MaterialIssueReturn.pdf');


}
function eprintissuertn(Request $req,$id){
$cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = stockissuereturn::with('stockissuereturndetail')
->find($id);
   if($data->return_type=='MatIssue'){
    $datt =projectmaterialissue::find($data->stockissueno);
   }
   else{
    $datt =stockissue::find($data->stockissueno);
   }
  
 //return view('inventory/stock/issuertn_view',['cmpid'=>$cmpid,'data'=>$data,'datt'=>$datt]);
$pdf = PDF::loadView('inventory/stock/issuertn_view',['cmpid'=>$cmpid,'data'=>$data,'datt'=>$datt]);
return $pdf->download('MaterialIssueReturn.pdf');


}
}