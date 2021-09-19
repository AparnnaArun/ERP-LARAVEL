<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use App\Models\account;
use App\Models\currency;
use App\Models\vendor;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\vendoradvance;
use App\Models\purchaseinvoice;
use App\Models\projectexpenseentry;
use App\Models\purchasecostdetail;
use App\Models\vendorpaymentdetail;
use App\Models\vendorpayment;
use App\Models\executive;
use App\Models\customer;
use App\Models\projectexpenseentrydetail;
use App\Models\executivecommission;
use App\Models\purchasecost;
use App\Models\salarycalculationmain;
use App\Models\expensesettlementdetail;
use App\Models\expensesettlement;

class AccountsPaymentController extends Controller
{
    function vadvance(Request $req){
      if(session('id')!=""){
      $vend =vendor::wherenotNull('account')
      ->select('id','short_name')
      ->orderBy('short_name','asc')->get();
      $curr =currency::orderBy('id','asc')->get();
                 $slno=vendoradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
      $datas =vendoradvance::leftJoin('vendors', 'vendoradvances.vendor', '=', 'vendors.id')->select('vendoradvances.*','vendors.short_name')
          ->where('vendoradvances.from_where','vendadv')
          ->orderBy('id','desc')->get();
      return view('accounts/payments/vendoradvance',['vend'=>$vend,'curr'=>$curr,'datas'=>$datas,'nslno'=>$nslno]);
      }
else{
 return redirect('/erp'); 

   }

    }

  function createvadvance(Request $req){
$dates=$req->input('dates');
$nddate = Carbon::parse($dates)->format('Y-m-d');
$dates1=$req->input('chequedate');
$nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $account =vendoradvance::UpdateorCreate(['advanceno'=>$req->input('advanceno'),],
  ['vendor'=>$req->input('vendor'),'slno'=>$req->input('slno'),
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('advance'),'remarks'=>$req->input('remarks'),'bankcash'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'chequedate'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$req->input('advance'),'from_where'=>'vendadv','currency'=>$req->input('currency'),'erate'=>$req->input('erate')]);
 if(isset($account)){
     //////ACCOUNTS SETTELING ////////////////
     $vend=vendor::where('id',$req->input('vendor'))
                 ->select('account','short_name')->first();
    if($req->input('paymentmode')=='1'){
  $sql = regularvoucherentry::where('keycode','PC')
       ->orderBy('id','desc')
       ->take(1)->first();
             if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PC';   
}
   }else{
   $sql = regularvoucherentry::where('keycode','PB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PB';   
}
   }

 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$req->input('advanceno'),],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('advance'),'totcredit'=>$req->input('advance'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'VendorAdv','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'is_vendoradnce'=>'1']); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['narration'=>$req->input('advanceno'),'voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$vend->account,'amount'=>$req->input('advance'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['narration'=>$req->input('advanceno'),'voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'amount'=>$req->input('advance'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('accounts/vendor-advance'); 
 }
  }
  function editvadvance(Request $req,$id){
if(session('id')!=""){
      $vend =vendor::wherenotNull('account')
      ->select('id','short_name')
      ->orderBy('short_name','asc')->get();

      $curr =currency::orderBy('id','asc')->get();
      $datas =vendoradvance::leftJoin('vendors', 'vendoradvances.vendor', '=', 'vendors.id')->select('vendoradvances.*','vendors.short_name')
          ->where('vendoradvances.from_where','vendadv')
          ->orderBy('id','desc')->get();
       $vadv = vendoradvance::find($id);
       $account=account::orderBy('id','desc')->get();  
      return view('accounts/payments/vendoradvanceedit',['vend'=>$vend,'curr'=>$curr,'datas'=>$datas,'vadv'=>$vadv,'account'=>$account]);
      }
else{
 return redirect('/erp'); 

   }

  } 

function vpayment(Request $req){
    if(session('id')!=""){
            $vend =vendor::wherenotNull('account')
                   ->orderBy('short_name','asc')->get();
                    $curr =currency::orderBy('id','asc')->get();
           $slno=vendorpayment::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
$proo =projectexpenseentry::where('expense_type','2')
       ->where('paidstatus','!=','1')->get();
$datas =vendorpayment::with('vendorpaymentdetail')->leftJoin('vendors', 'vendorpayments.vendor', '=', 'vendors.id')->select('vendorpayments.*','vendors.short_name')
        ->orderBy('id','desc')->get();
      return view('accounts/payments/vendorpayment',['vend'=>$vend,'curr'=>$curr,'nslno'=>$nslno,'datas'=>$datas,'proo'=>$proo]);
      }
else{
 return redirect('/erp'); 

   }
}
function getpinvoice(Request $req) 
{
 $pinv =purchaseinvoice::where('is_returned','!=','1')
       ->where('is_deleted','!=','1')
       ->where('paidstatus','!=','1')
       ->where('vendor',$req->vendor)
       ->orderBy('id','desc')->get();
        $pexc =projectexpenseentry::where('is_deleted','!=','1')
       ->where('paidstatus','!=','1')
       ->where('vendor_id',$req->vendor)
        ->orderBy('id','desc')->get();
     $vendacc =vendor::where('id',$req->vendor)
               ->select('account')->first();   
         $pcost=purchasecostdetail::where('unsettledamt','!=','0')
                ->where('vendoracc',$vendacc->account)->get();
return view('accounts/payments/loadpayment',['pexc'=>$pexc,'pinv'=>$pinv,'pcost'=>$pcost]);

} 
function getsumpadvance(Request $req){
$result = DB::table('vendoradvances')
                ->select(DB::raw('sum(bal_advnce) as sum_adv'))
                ->where('vendor',$req->vendor)
                ->groupBy('vendor')
                ->first();
       $vend=vendor::select('short_name','account')
            ->where('id',$req->vendor)->first();        
return view('accounts/payments/getsumadvance',['vend'=>$vend,'result'=>$result]);


}
function createpayment(Request $req){
 $dates=$req->input('dates');
$nddate = Carbon::parse($dates)->format('Y-m-d');
$dates1=$req->input('chequedate');
$nddate1 = Carbon::parse($dates1)->format('Y-m-d');

 $account =vendorpayment::UpdateorCreate(
    ['pymt_no'=>$req->input('pymt_no')],
  ['slno'=>$req->input('slno'),'vendor'=>$req->input('vendor'),
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('advance'),'totalamount'=>$req->input('totalamount'),'bank'=>$req->input('bank'),'cheque_no'=>$req->input('chequeno'),'bank_date'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'roundoff'=>$req->input('roundoff'),'totaladvace'=>$req->input('totaladvace'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'nettotal'=>$req->input('nettotal'),'erate'=>$req->input('erate'),'currency'=>$req->input('currency')]);
  if(isset($account)){
   $dates11=$req->gdates;
      $invoiceno = $req->invoiceno;
        $purchaseid=$req->purchaseid;
        $grandtotal=$req->grandtotal;
        $nettotals=$req->ntotal;
        $collected=$req->collected;
        $debitnote=$req->debitnote;
        $balance=$req->balance;
        $amount=$req->amount;
        $pcostmid=$req->pcostmid;
        $count =count($amount);
for ($i=0; $i < $count; $i++){
    if(!empty($amount[$i])){
    $nddate11 = Carbon::parse($dates11[$i])->format('Y-m-d');
    $ncoll =$collected[$i] + $amount[$i];
       $nbal = $nettotals[$i] - $ncoll ;
  $bnd =vendorpaymentdetail::UpdateorCreate(
  ['invoiceno'=>$invoiceno[$i],'payid'=>$account->id,],
  ['dates'=>$nddate11,
  'vendor'=>$req->input('vendor'),
  'purchaseid'=>$purchaseid[$i],
  'grandtotal'=>$grandtotal[$i],
  'collected'=>$collected[$i],
  'debitednote'=>$debitnote[$i],
  'balance'=>$balance[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   
   ////////////////PURCHASE INVOICE / PROJECT EXPENSE ENTRY UPDATE/////////////
if($nbal <= 0){
           purchaseinvoice::where('p_invoice',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal,
                    'paidstatus'=>'1']);
           projectexpenseentry::where('entry_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance_amount'=>$nbal,
                    'paidstatus'=>'1']);
          purchasecostdetail::where('id',$purchaseid[$i])
        ->update(['settledamt'=>$ncoll,
                   'unsettledamt'=>$nbal
                    ]);
        // purchasecost::where('id',$pcostmid[$i])
        // ->update(['paidstatus'=>'1']);
          }else{
             purchaseinvoice::where('p_invoice',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal,
                    'paidstatus'=>'2']);
                projectexpenseentry::where('entry_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance_amount'=>$nbal,
                    'paidstatus'=>'2']);
        purchasecostdetail::where('id',$purchaseid[$i])
        ->update(['settledamt'=>$ncoll,
                   'unsettledamt'=>$nbal
                    ]);
        //  purchasecost::where('id',$pcostmid[$i])
        // ->update(['paidstatus'=>'2']);
          }
                  }
     
}
     //////ACCOUNTS SETTELING ////////////////
    $bname=account::where('id',$req->input('bank'))->select('printname')->first();
    if(!empty($bname->printname)){
    $remarks =$bname->printname.','. $req->input('vendname').','. $req->input('pymt_no');
   }
   else{
    $remarks =$req->input('vendname').','. $req->input('pymt_no');
   }
    if($req->input('paymentmode')=='1'){
  $sql = regularvoucherentry::where('keycode','PC')
       ->orderBy('id','desc')
       ->take(1)->first();
             if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PC';   
}
   }else{
   $sql = regularvoucherentry::where('keycode','PB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PB';   
}
   }

 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
 if($req->input('paymentmode')!='5'){
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Payments','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$req->input('vendaccount'),'narration'=>$remarks,'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
 ///////// Vendor Advance ///////////////////
 $badvn = $req->input('totalamount') -$req->input('nettotal');
 $vslno =vendoradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($vslno->slno)){
  $nvslno = $vslno->slno +1;
}
else{

$nvslno="1";

}
$kkey = 'Vadv'.$nvslno;
  $account =vendoradvance::UpdateorCreate(['remarks'=>$req->input('pymt_no').'Advance',],
  ['vendor'=>$req->input('vendor'),'slno'=>$nvslno,'advanceno'=>$kkey,
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('totalamount'),'bankcash'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$badvn,'from_where'=>'Payments']);
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('accounts/vendor-payment');
}
}
function editvpayment($id,Request $req){
    if(session('id')!=""){
            $vend =vendor::wherenotNull('account')
                   ->orderBy('short_name','asc')->get();
                    $curr =currency::orderBy('id','asc')->get();
  $vpay =vendorpayment::with('vendorpaymentdetail')->find($id);
$datas =vendorpayment::with('vendorpaymentdetail')->leftJoin('vendors', 'vendorpayments.vendor', '=', 'vendors.id')->select('vendorpayments.*','vendors.short_name')
        ->orderBy('id','desc')->get();
         $account=account::where('category','bank')
                  ->orWhere('category','cash')
                  ->orderBy('id','desc')->get(); 
           $vends=vendor::select('account','short_name') 
                 ->where('id',$vpay->vendor)->first();      
      return view('accounts/payments/vendorpaymentedit',['vend'=>$vend,'curr'=>$curr,'vpay'=>$vpay,'datas'=>$datas,'account'=>$account,'vends'=>$vends]);
      }
else{
 return redirect('/erp'); 

   }
}
function getexpentry(Request $req){
if(session('id')!="" ){
        
  $voucher  = vouchergeneration::where('voucherid','54')
              ->select('slno','constants')->first(); 
               
  $slno=projectexpenseentry::select('slno')
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
 $execs = executive::select('id', 'short_name')
        ->orderBy('short_name','asc')
         ->get();  
    
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    projectexpenseentry::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectexpenseentries.projectid');
         })->leftJoin('vendors', function($join) {
      $join->on('vendors.id', '=', 'projectexpenseentries.vendor_id');
         })->select('projectdetails.project_code','vendors.vendor','projectexpenseentries.*')
       
        ->orderBy('projectexpenseentries.id','desc')
          ->get();
   $vendor = vendor::where('approve','1')
            ->orderBy('short_name','asc')->get();       
           
            
return view('accounts/payments/projectexpenseentry',['execs'=>$execs,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'vendor'=>$vendor]);
}
           else{
                  return redirect('/'); 
                 }

}
function createproexps(Request $req){
        $validator =  $req ->validate([
                'entry_no'=>'required'
                
               ],
   [ 'entry_no.required'    => 'Sorry,Please generate an entry number, Thank You.'
  
        ]);
   $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = projectexpenseentry::updateOrCreate(
  ['entry_no'=>$req->input('entry_no'),'slno'=>$req->input('slno'),'dates'=>$nddate,'vendor_id'=>$req->input('vendor_id'),'executive'=>$req->input('executives'),'paymentmode'=>$req->input('paymentmode'),'expense_type'=>$req->input('expense_type'),'totalamount'=>$req->input('totalamount'),'balanceamount'=>$req->input('totalamount'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'keycode'=>$req->input('constants'),'projectid'=>$req->input('projectids'),'balance_amount'=>$req->input('totalamount')]);
  if(isset($enquiry)){
    $amount = 0 - $req->input('totalamount') ;
  $percents =$req->input('commission_percentage');
  $payprofit = ($amount*$percents)  /100;
  $payprofit1 =(-1)*$payprofit ;

      $projectcode=$req->projectcode;
      $projectid = $req->projectid;
      $projectname=$req->projectname;
      $customerid=$req->customerid;
      $customer=$req->customer;
      $executive=$req->executive;
      $amount=$req->amount;
      $count =count($projectid);
        for ($i=0; $i < $count; $i++){
  $bnd =projectexpenseentrydetail::UpdateorCreate(['expense_id'=>$enquiry->id,'projectid'=>$projectid[$i],
  'projectcode'=>$projectcode[$i],
  
  'projectname'=>$projectname[$i],
  'customerid'=>$customerid[$i],
  'customer'=>$customer[$i],
  'executive'=>$executive[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  $profit = 0 - $amount[$i] ;
  $percent =$req->input('commission_percentage');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 =(-1)*$profitpay ;
      //////Executive Commission////////////////
   $exee = executivecommission::UpdateorCreate(
  ['invoice_no'=>$req->input('entry_no'),
'customer'=>$customerid[$i],'executive'=>$executive[$i],'percent'=>$req->input('commission_percentage'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate,'totcost'=>$amount[$i]]); 
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
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$req->input('entry_no'),'voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
////// PROJECT EXP & CREDIT////////////////////////////
if($req->input('paymentmode')=='credit' && $req->input('expense_type')=='1'){

$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('entry_no'),'account_name'=>$req->input('vendaccount'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$req->input('entry_no'),'account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
}

////// PROJECT EXP & CHEQUE////////////////////////////
elseif(($req->input('paymentmode')=='cheque' ||$req->input('paymentmode')=='cash') && $req->input('expense_type')=='1'){
 
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('entry_no'),'account_name'=>$req->input('bank'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$req->input('entry_no'),'account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 
}elseif($req->input('paymentmode')=='credit'  && $req->input('expense_type')=='2'){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('entry_no'),'account_name'=>'321','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$req->input('entry_no'),'account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);


}
elseif($req->input('paymentmode')=='credit'  && $req->input('expense_type')=='3'){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('entry_no'),'account_name'=>'28','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$req->input('entry_no'),'account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

}else{

}
}
  //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::UpdateorCreate(
['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$payprofit1,'totcredit'=>$payprofit1,'created_by'=>session('name'),'remarks'=>'executivecommission'.$req->input('entry_no'),'approved_by'=>session('name'),'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::UpdateorCreate(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>'executivecommission'.$req->input('entry_no'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::UpdateorCreate(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('comm_pay_account'),'narration'=>'executivecommission'.$req->input('entry_no'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
  
    
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/accounts/expense-entry');
}
}
function deletepayment(Request $req,$id){
 vendorpayment::where('id',$id)
  ->update(['is_deleted'=>'1']);
  $sql =vendorpayment::where('id',$id)
        ->select('pymt_no')->first();
  $sql1 =vendorpaymentdetail::where('payid',$id)->get();
  foreach($sql1 as $sq1) {
    /// NOT EMPTY PURCHASE INVOICE NO/////
$pur =purchaseinvoice::where('p_invoice',$sq1->invoiceno)->first();
if(!empty($pur->p_invoice)){
 $tamtpur =$pur->totalamount;
 $collamtpur =$pur->collected_amount;
 $debamtpur =$pur->debit_note_amountl;
 $newcollamtpur =$collamtpur - ($sq1->amount);
  $newbalpur =$tamtpur -($debamtpur + $newcollamtpur);
if($newbalpur <= 0){
    purchaseinvoice::where('p_invoice',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtpur,
'balance'=>$newbalpur,'paidstatus'=>'1']);
        }
    else{
      purchaseinvoice::where('p_invoice',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtpur,
'balance'=>$newbalpur,'paidstatus'=>'2']);    
    }

}
   /// NOT EMPTY PROJECT EXPENSE NO/////
$exp =projectexpenseentry::where('entry_no',$sq1->invoiceno)->first();
if(!empty($exp->entry_no)){
 $tamtexp =$exp->totalamount;
 $collamtexp =$exp->collected_amount;
 $debamtexp =$exp->debitnote_amount;
 $newcollamtexp =$collamtexp - ($sq1->amount);
  $newbalexp =$tamtexp -($debamtexp + $newcollamtexp);
if($newbalexp <= 0){
    projectexpenseentry::where('entry_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'balance_amount'=>$newbalexp,'paidstatus'=>'1']);
        }
    else{
      projectexpenseentry::where('entry_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'balance_amount'=>$newbalexp,'paidstatus'=>'2']);    
    }

}
   /// NOT EMPTY PURCHASE ADDITIONAL COST NO/////
$cost =purchasecostdetail::where('addnos',$sq1->invoiceno)->first();
if(!empty($cost->addnos)){
 $tamtcost =$cost->amount;
 $collamtcost =$cost->settledamt;
 // $debamtcost =$cost->debitnote_amount;
 $newcollamtcost =$collamtcost - ($sq1->amount);
  $newbalcost =$tamtcost -$newcollamtcost;
purchasecostdetail::where('addnos',$sq1->invoiceno)
->update(['settledamt'=>$newcollamtcost,
'unsettledamt'=>$newbalcost]);
      }
  }
$vpay =vendorpayment::leftJoin('vendors', 'vendorpayments.vendor', '=', 'vendors.id')
            ->leftJoin('accounts', 'vendorpayments.bank', '=', 'accounts.id')->select('vendorpayments.pymt_no','vendors.short_name','accounts.printname','vendorpayments.paymentmode','vendorpayments.dates','vendorpayments.totalamount','vendorpayments.bank','vendors.account','vendorpayments.nettotal','vendorpayments.vendor')->where('vendorpayments.id',$id)->first();

 if(!empty($vpay->printname)){
     $remarks ='Deleted '.$vpay->printname.','. $vpay->short_name.','. $vpay->pymt_no;
   }
   else{
     $remarks ='Deleted '.$vpay->short_name.','. $vpay->pymt_no;
   }
   $dt = now();
   $nddate =$dt->format('Y-m-d');
 if($vpay->paymentmode=='1'){
$sqlss = regularvoucherentry::where('keycode','PC')
       ->orderBy('id','desc')
       ->take(1)->first();
       if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='PC';   
}
   }else{
   $sqlss = regularvoucherentry::where('keycode','PB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='PB';   
}
   }
    if(!empty($sqlss->slno)){
    $slno =$sqlss->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
  if($vpay->paymentmode!='5'){
 $data= regularvoucherentry::Create(['remarks'=>$remarks,
'voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->totalamount,'totcredit'=>$vpay->totalamount,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Deleted Payments','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'debt',
  'account_name'=>$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->totalamount,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'cred',
  'account_name'=>$vpay->account,'narration'=>$remarks,'amount'=>$vpay->totalamount,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
 ///////// Vendor Advance Return///////////////////
 $badvn = $vpay->nettotal - $vpay->totalamount;
 $vslno =vendoradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($vslno->slno)){
  $nvslno = $vslno->slno +1;
}
else{

$nvslno="1";

}
$kkey = 'Vadv'.$nvslno;
  $account =vendoradvance::Create(['remarks'=>'Deleted'.$vpay->pymt_no.'Advance',
  'vendor'=>$vpay->vendor,'slno'=>$nvslno,'advanceno'=>$kkey,
'paymentmode'=>$vpay->paymentmode,'dates'=>$nddate,'advance'=>$vpay->totalamount,'bankcash'=>$vpay->bank,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$badvn,'from_where'=>'Deleted Payments']);    
$req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();
}
function expsettle(Request $req){
   if(session('id')!=""){
    $slno=expensesettlement::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
$datas =expensesettlement::with('expensesettlementdetail')
        ->orderBy('id','desc')->get();
      return view('accounts/payments/expsettle',['nslno'=>$nslno,'datas'=>$datas]);
      }
else{
 return redirect('/erp'); 

   }

}
function getalldatas(Request $req){
    $settle =$req->settle;
    if($req->settle=='1'){
$proo =projectexpenseentry::where('expense_type','2')
       ->where('paidstatus','!=','1')->get();
   }
   elseif($req->settle=='2'){
   $proo =projectexpenseentry::where('expense_type','3')
       ->where('paidstatus','!=','1')->get(); 
   }
   elseif($req->settle=='3'){
     $proo =salarycalculationmain::where('balance','!=','0')->get();
   }
   elseif($req->settle=='4'){
   $proo =salarycalculationmain::where('advncebalnce','!=','0')
           ->get(); 
   }
return view('accounts/payments/loadprsal',['proo'=>$proo,'settle'=>$settle]);
}
function createsettlement(Request $req){
$dates=$req->input('dates');
$nddate = Carbon::parse($dates)->format('Y-m-d');
$dates1=$req->input('chequedate');
$nddate1 = Carbon::parse($dates1)->format('Y-m-d');
$account =expensesettlement::UpdateorCreate(
    ['settle_no'=>$req->input('settle_no')],
  ['slno'=>$req->input('slno'),'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'bank'=>$req->input('bank'),'cheque_no'=>$req->input('chequeno'),'bank_date'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'remarks'=>$req->input('remarks'),'nettotal'=>$req->input('nettotal'),'settle_type'=>$req->input('settle_type')]);
  if(isset($account)){
    
        $dates11=$req->gdates;
        $invoiceno = $req->invoiceno;
        $purchaseid=$req->purchaseid;
        $grandtotal=$req->grandtotal;
        $nettotals=$req->ntotal;
        $collected=$req->collected;
        $balance=$req->balance;
        $amount=$req->amount;
        $count =count($amount);
for ($i=0; $i < $count; $i++){
    if(!empty($amount[$i])){
    $nddate11 = Carbon::parse($dates11[$i])->format('Y-m-d');
    $ncoll =$collected[$i] + $amount[$i];
       $nbal = $nettotals[$i] - $ncoll ;
  $bnd =expensesettlementdetail::UpdateorCreate(
  ['invoiceno'=>$invoiceno[$i],'sttlid'=>$account->id,],
  ['dates'=>$nddate11,
  'purchaseid'=>$purchaseid[$i],
  'grandtotal'=>$grandtotal[$i],
  'collected'=>$collected[$i],
  'balance'=>$balance[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   ////////////////PRO SALARY  / PROJECT COMMISSION /STAFF SALARY UPDATE/////////////
if($nbal <= 0){
    if($req->input('settle_type')=='1' || $req->input('settle_type')=='2'){
         projectexpenseentry::where('id',$purchaseid[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance_amount'=>$nbal,
                    'paidstatus'=>'1']);
    }elseif($req->input('settle_type')=='3'){
           salarycalculationmain::where('id',$purchaseid[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal
                   ]);
        
    }elseif($req->input('settle_type')=='4'){
salarycalculationmain::where('id',$purchaseid[$i])
        ->update(['collectedadvnce'=>$ncoll,
                   'advncebalnce'=>$nbal
                   ]);
    }
    else{
      
          }
          }else{
    
        if($req->input('settle_type')=='1' || $req->input('settle_type')=='2'){
         projectexpenseentry::where('id',$purchaseid[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance_amount'=>$nbal,
                    'paidstatus'=>'2']);
    }elseif($req->input('settle_type')=='3'){
           salarycalculationmain::where('id',$purchaseid[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal
                   ]);
        
    }elseif($req->input('settle_type')=='4'){
salarycalculationmain::where('id',$purchaseid[$i])
        ->update(['collectedadvnce'=>$ncoll,
                   'advncebalnce'=>$nbal
                   ]);
    }
    else{

    }
          }
                  }
     
}
     //////ACCOUNTS SETTELING ////////////////
    $bname=account::where('id',$req->input('bank'))->select('printname')->first();
   $remarks =$bname->printname.','. $req->input('settle_no');
 
   
    if($req->input('paymentmode')=='1'){
  $sql = regularvoucherentry::where('keycode','PC')
       ->orderBy('id','desc')
       ->take(1)->first();
             if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PC';   
}
   }else{
   $sql = regularvoucherentry::where('keycode','PB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='PB';   
}
   }

 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
 if($req->input('settle_type')=='1'){
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('nettotal'),'totcredit'=>$req->input('nettotal'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>'321','narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
elseif($req->input('settle_type')=='2'){
$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('nettotal'),'totcredit'=>$req->input('nettotal'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>'28','narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }    
}elseif($req->input('settle_type')=='3'){

$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('nettotal'),'totcredit'=>$req->input('nettotal'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'357',],
  ['narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

}
elseif($req->input('settle_type')=='4'){

$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('nettotal'),'totcredit'=>$req->input('nettotal'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'409',],
  ['narration'=>$remarks,'amount'=>$req->input('nettotal'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

}
else{}

 $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}

}
function editexpsettle(Request $req,$id){
   if(session('id')!=""){
    $slno=expensesettlement::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
$datas =expensesettlement::with('expensesettlementdetail')
        ->orderBy('id','desc')->get();
    $account =account::where('category','bank')
             ->orwhere('category','cash')
             ->orderBy('printname','asc')->get();     
 $set =  expensesettlement::with('expensesettlementdetail')->find($id);     
      return view('accounts/payments/expsettleedit',['nslno'=>$nslno,'datas'=>$datas,'set'=>$set,'account'=>$account]);
      }
else{
 return redirect('/erp'); 

   } 

}
function deletesettlement(Request $req,$id){
 expensesettlement::where('id',$id)
  ->update(['is_deleted'=>'1']);
  $sql =expensesettlement::where('id',$id)
        ->select('settle_type')->first();
  $sql1 =expensesettlementdetail::where('sttlid',$id)->get();
  foreach($sql1 as $sq1) {
    /// NOT EMPTY PURCHASE INVOICE NO/////
    if($sql->settle_type=='3'){
$pur =salarycalculationmain::where('voucher',$sq1->invoiceno)->first();
$tamtpur =$pur->totalnetsalary;
 $collamtpur =$pur->collected_amount;
 $newcollamtpur =$collamtpur - ($sq1->amount);
  $newbalpur =$tamtpur - $newcollamtpur;
salarycalculationmain::where('voucher',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtpur,
'balance'=>$newbalpur]);
   }
   /// NOT EMPTY PROJECT EXPENSE NO/////
if($sql->settle_type=='1' || $sql->settle_type=='2'){
$exp =projectexpenseentry::where('entry_no',$sq1->invoiceno)->first();
$tamtexp =$exp->totalamount;
 $collamtexp =$exp->collected_amount;
 $debamtexp =$exp->debitnote_amount;
 $newcollamtexp =$collamtexp - ($sq1->amount);
  $newbalexp =$tamtexp -($debamtexp + $newcollamtexp);
if($newbalexp <= 0){
    projectexpenseentry::where('entry_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'balance_amount'=>$newbalexp,'paidstatus'=>'1']);
        }
    else{
      projectexpenseentry::where('entry_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'balance_amount'=>$newbalexp,'paidstatus'=>'2']);    
    }

}
   /// NOT EMPTY PURCHASE ADDITIONAL COST NO/////
 if($sql->settle_type=='4'){
$cost =salarycalculationmain::where('voucher',$sq1->invoiceno)->first();
$tamtcost =$cost->totaladvance;
 $collamtcost =$cost->collectedadvnce;
 $newcollamtcost =$collamtcost - ($sq1->amount);
  $newbalcost =$tamtcost -$newcollamtcost;
salarycalculationmain::where('voucher',$sq1->invoiceno)
->update(['collectedadvnce'=>$newcollamtcost,
'advncebalnce'=>$newbalcost]);
      }
  }
$vpay =expensesettlement::leftJoin('accounts', 'expensesettlements.bank', '=', 'accounts.id')->select('expensesettlements.settle_no','accounts.printname','expensesettlements.paymentmode','expensesettlements.nettotal','expensesettlements.bank','expensesettlements.settle_type')->where('expensesettlements.id',$id)->first();

$remarks ='Deleted '.$vpay->printname.','. $vpay->settle_no;
   
   $dt = now();
   $nddate =$dt->format('Y-m-d');
 if($vpay->paymentmode=='1'){
$sqlss = regularvoucherentry::where('keycode','PC')
       ->orderBy('id','desc')
       ->take(1)->first();
       if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='PC';   
}
   }else{
   $sqlss = regularvoucherentry::where('keycode','PB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='PB';   
}
   }
    if(!empty($sqlss->slno)){
    $slno =$sqlss->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
if($vpay->settle_type=='1'){
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->nettotal,'totcredit'=>$vpay->nettotal,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Deleted Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>'321','narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
elseif($vpay->settle_type=='2'){
$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->nettotal,'totcredit'=>$vpay->nettotal,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Deleted Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>'28','narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }    
}elseif($vpay->settle_type=='3'){

$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->nettotal,'totcredit'=>$vpay->nettotal,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Deleted Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'357',],
  ['narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

}
elseif($vpay->settle_type=='4'){

$data= regularvoucherentry::UpdateorCreate(['remarks'=>$remarks,],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->nettotal,'totcredit'=>$vpay->nettotal,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Expense Settlement','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'409',],
  ['narration'=>$remarks,'amount'=>$vpay->nettotal,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }

}
else{}
    return redirect()->back();
}
}
