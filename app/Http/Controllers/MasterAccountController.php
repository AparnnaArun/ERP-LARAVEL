<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\account;
use App\Models\openingaccountdetail;
use App\Models\openingaccount;
use App\Models\currentstock;
use App\Models\itemmaster;
use App\Models\executive;
use App\Models\executivecommission;
use App\Models\executiveoverhead;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\salesinvoice;
use App\Models\commissioncalculation;
class MasterAccountController extends Controller
{
         function landing(){
 if(session('id')!=""){
return view('accounts/masters/dashboard');
}
else{
 return redirect('/'); 
}

  }
   function getaccount(){
     
    if(session('id')!=""){
    $categories = account::where('parentid', '=', 0)->get();
        $allCategories = account::select('name','id','accounttype','active')
                       ->orderBy('name','Asc')->get();
         $accounts = account::select('printname','id')
        ->where('accounttype','s1')
        ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
        ->orderBy('id','Desc')->take(1)->first();


        return view('accounts/masters/accounts',compact('categories','allCategories','accounts','accid'));
        
    }
   else{
 return redirect('/'); 

   }
}
function createaccount(Request $req){
 $req->validate([
    'seqnumber' => 'required|unique:accounts',
    'name'      => 'required',
    'printname' => 'required',
    'parentid'  =>'required'

]);
 $fcode = $req->input('fullcode').$req->input('idd').'#';
 $acc = account::where('name',$req->input('name'))
       -> orwhere('printname',$req->input('printname'))
       ->where('parentid',$req->input('parentid'))
        ->count();
 if($acc > 0){
  $req->session()->flash('failed', 'Name/Print name already exist under the same parent!');
return redirect('/admin/account-details');

 }
elseif($req->input('fullcode')==""){
  $req->session()->flash('failed', 'Something went wrong. Try again!');
return redirect('/admin/account-details'); 
}
 else{
    $account =account::updateOrCreate(
  ['seqnumber'=>$req->input('seqnumber')],
['accounttype'=>$req->input('accounttype'),'active'=>$req->input('active'),'name'=>$req->input('name'),'printname'=>$req->input('printname'),'parentid'=>$req->input('parentid'),'description'=>$req->input('description'),'fullcode'=>$fcode,'category'=>$req->input('category'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/accounts/account-details');
 }
}
function editaccount($id){
 if(session('id')!=""){
        $acc= account::find($id);
        $pname =account::where('id',$acc->parentid)
                ->select('printname')->first();
        $categories = account::where('parentid', '=', 0)->get();
        $allCategories = account::select('name','id','accounttype','active')
                       ->orderBy('name','Asc')->get();
         $accounts = account::select('printname','id')
        ->where('accounttype','s1')
        ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
        ->orderBy('id','Desc')->take(1)->first();


        return view('accounts/masters/editaccounts',compact('categories','allCategories','accounts','accid','acc','pname'));
      
    }
   else{
 return redirect('/'); 

   }  
   
}
function editsaccountss(Request $req){
account::where('id', $req->input('id'))
              ->update(['active'=>$req->input('active'),'name'=>$req->input('name'),'printname'=>$req->input('printname'),'description'=>$req->input('description'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

   }
   function getopening(Request $req){
if(session('id')!=""){
$pname =account::where('accounttype','s1')
                ->select('printname','id')->get();
return view('accounts/masters/opening',['pname'=>$pname]);
      
    }
   else{
 return redirect('/'); 

   } 
}
function loadaccound(Request $req){
 $acc =account::where('parentid',$req->vid)
          ->where('accounttype','a1')
      ->select('printname','id')->get();
  $op =openingaccount::with('openingaccountdetail')
      ->where('schedule',$req->vid)->first();    
return view('accounts/masters/loadaccount',['acc'=>$acc,'op'=>$op]);

}
function createacopening(Request $req){
    $dates=$req->input('dates');
    $nddate = Carbon::parse($dates)->format('Y-m-d');
 $account =openingaccount::updateOrCreate(
  ['schedule'=>$req->input('schedule')],
['diffopenbal'=>$req->input('diffopenbal'),'totdebit'=>$req->input('totdebit'),'totcredit'=>$req->input('totcredit'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($account)){
      $accountid=$req->accountid;
      $debit = $req->debit;
        $credit=$req->credit;
       $accname=$req->accname;
        $count =count($accountid);
for ($i=0; $i < $count; $i++){
  $bnd =openingaccountdetail::updateOrCreate(
  ['acchead'=>$accountid[$i],
  'opaccid'=>$account->id,],
  ['debit'=>$debit[$i],
  'credit'=>$credit[$i],
  'accname'=>$accname[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/accounts/opening-details');

  }    
}
function getstock(Request $req){
return $item =itemmaster::select(\DB::raw('itemmasters.*, SUM(currentstocks.bal_qnty) as revenue'))
         ->leftJoin('currentstocks', 'currentstocks.item_id', '=', 'itemmasters.id')
         ->groupBy('currentstocks.item_id','revenue')
         ->get();
}
function getexeovr(Request $req){
        $voucher  = vouchergeneration::where('voucherid','149')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
               $newno =   $voucher->constants.$voucher->slno;
   $slno=executiveoverhead::select('slno')
                       ->where('ovr_no',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=executiveoverhead::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $datas =    executiveoverhead::orderBy('id','desc')
          ->get();
$exes =executive::orderBy('short_name','asc')->get();
return view('accounts/masters/executiveoverhead',['exes'=>$exes,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas]);    
}
function loadinvs(Request $req){
   $exes =executivecommission::where('is_deleted','0')
         
         ->where('executive',$req->vid)
         ->where('from_where','LIKE','Sinv')->select('invoice_no')->get();
         
  return view('accounts/masters/loadinvoice',['exes'=>$exes]); 

}
function getbankorcash(Request $req){
  $pay =$req->pay;
  if($req->pay =='1'){
     $account =account::where('category' , 'cash')
              ->get();

  }
  elseif(($req->pay) < '5'){
    $account =account::where('category' , 'bank') 
              ->orWhere('id','45')
              ->get();
  }else{
    return "No Bank Or Cash";
  }

  return view('accounts/masters/getbankorcash',['account'=>$account,'pay'=>$pay]);
}
function createoverhead(Request $req){
   $dates=$req->input('dates');
    $nddate = Carbon::parse($dates)->format('Y-m-d');
 $account =executiveoverhead::updateOrCreate(
  ['ovr_no'=>$req->input('ovr_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'overhead_type'=>$req->input('overhead_type'),'executive'=>$req->input('executive'),'invoice_no'=>$req->input('invoice_no'),'paymentmode'=>$req->input('paymentmode'),'bank'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'amount'=>$req->input('amount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $eec =executive::where('short_name',$req->input('executive'))->first();

  $commission_percentage=$eec->commission_percentage;
  $comm_pay_account=$eec->comm_pay_account;
  $exe_com_exp_ac=$eec->exe_com_exp_ac;
  $amount = 0 - $req->input('amount') ;
  $payprofit = ($amount*$commission_percentage)  /100;
  $payprofit1 =(-1)*$payprofit ;
  $exee = executivecommission::Create(
  ['invoice_no'=>$req->input('ovr_no'),
'executive'=>$req->input('executive'),'percent'=>$commission_percentage,'profit'=>$amount,'profitpay'=>$payprofit,'from_where'=>$req->input('overhead_type'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate,'totcost'=>$req->input('amount')]); 
  if($req->input('overhead_type')=='overhead' && $req->input('paymentmode')!="5"){
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('amount'),'totcredit'=>$req->input('amount'),'created_by'=>session('name'),'remarks'=>$req->input('ovr_no'),'approved_by'=>session('name'),'from_where'=>'Executive OverHead','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
    
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'309','narration'=>$req->input('ovr_no'),'amount'=>$req->input('amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$req->input('bank'),'narration'=>$req->input('ovr_no'),'amount'=>$req->input('amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno')]);

 }


  }
   if($req->input('overhead_type')=='salescommission'){
    //////SALES INVOICE SETTLING/////////////
     $sales =salesinvoice::where('invoice_no', $req->input('invoice_no'))
                   ->first();
   $sales_comm = $sales->sales_commission;
  $cost =$sales->totcosts;
  $profit =$sales->profit;
  $grand_total =$sales->grand_total;
$sales_comm1 = $sales_comm + $req->input('amount');
$cost1 = $sales_comm1 +  $cost;
$profit1 = $grand_total - $cost1;
$sinv = salesinvoice::where('invoice_no',$req->input('invoice_no'))
        ->update(['sales_commission'=>$sales_comm1,
      'totcosts'=>$cost1,
      'profit'=>$profit1]);
        if($req->input('paymentmode')!="5"){
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('amount'),'totcredit'=>$req->input('amount'),'created_by'=>session('name'),'remarks'=>$req->input('ovr_no'),'approved_by'=>session('name'),'from_where'=>'Executive OverHead','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
    
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'25','narration'=>$req->input('ovr_no'),'amount'=>$req->input('amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$req->input('bank'),'narration'=>$req->input('ovr_no'),'amount'=>$req->input('amount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno')]);

 }
   //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$payprofit1,'totcredit'=>$payprofit1,'created_by'=>session('name'),'remarks'=>$req->input('entry_no'),'approved_by'=>session('name'),'from_where'=>'Executive OverHead','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$exe_com_exp_ac,'narration'=>$req->input('ovr_no'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$comm_pay_account,'narration'=>$req->input('ovr_no'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 } 

}
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/accounts/executive-overhead');

}
function editoverhead($id,Request $req){
$datas =    executiveoverhead::orderBy('id','desc')
          ->get();
$exes =executive::orderBy('short_name','asc')->get();
$ovr =executiveoverhead::find($id);
return view('accounts/masters/executiveoverheadedit',['exes'=>$exes,'datas'=>$datas,'ovr'=>$ovr]);


}
function getexcomm(Request $req){
 if(session('id')!=""){
      $voucher  = vouchergeneration::where('voucherid','148')
              ->select('slno','constants')->first();
if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=commissioncalculation::select('slno')
                       ->where('enrty_no',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=commissioncalculation::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
$exes =executive::orderBy('short_name','asc')->get();
$datas =    commissioncalculation::orderBy('id','desc')
          ->get();
return view('accounts/masters/executivecomm',['nslno'=>$nslno,'exes'=>$exes,'datas'=>$datas,'voucher'=>$voucher]);
}
else{
 return redirect('/'); 
}

  }
  function loadcommission(Request $req){
    $exe =executive::where('short_name',$req->vid)
          ->select('comm_pay_account')->first();
   $op =openingaccountdetail::where('acchead',$exe->comm_pay_account) 
        ->select(DB::raw('sum(debit) as sdebit,sum(credit) as scredit')) 
      ->groupBy('acchead')->get();

  $result = DB::table('executivecommissions')
                ->select(DB::raw('sum(total_amount) as income,sum(totcost) as expense,sum(profit) as profit,sum(profitpay) as totcomm,sum(paid_amount) as paidcomm'))
                ->where('executive',$req->vid)
                ->where('is_deleted','!=','1')
                ->groupBy('executive')
                ->get();
return view('accounts/masters/loadallcommission',['result'=>$result,'op'=>$op,'exe'=>$exe]);

  }
function createexcecomm(Request $req){
  $dates=$req->input('dates');
    $nddate = Carbon::parse($dates)->format('Y-m-d');
     $dates1=$req->input('chequedate');
    $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $account =commissioncalculation::updateOrCreate(
  ['enrty_no'=>$req->input('enrty_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'executive'=>$req->input('executive'),'total_income'=>$req->input('total_income'),'total_expense'=>$req->input('total_expense'),'profit'=>$req->input('profit'),'commission_payable'=>$req->input('commission_payable'),'commission_paid'=>$req->input('commission_paid'),'balance'=>$req->input('balance'),'paycommission'=>$req->input('paycommission'),'paymentmode'=>$req->input('paymentmode'),'bankcash'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'chequedate'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 if($account){
  $exee = executivecommission::updateOrCreate(
  ['invoice_no'=>$req->input('enrty_no'),],
['executive'=>$req->input('executive'),'paid_amount'=>$req->input('paycommission'),'from_where'=>'Commission Calculation','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate]); 
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
  $data= regularvoucherentry::UpdateorCreate(['remarks'=>$req->input('enrty_no'),],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('paycommission'),'totcredit'=>$req->input('paycommission'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'commissioncalculation','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['narration'=>$req->input('enrty_no'),'voucherid'=>$data->id,'debitcredit'=>'debt',],
  ['account_name'=>$req->input('comm_pay_account'),'amount'=>$req->input('paycommission'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::UpdateorCreate(['narration'=>$req->input('enrty_no'),'voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>$req->input('bank'),'amount'=>$req->input('paycommission'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);

}
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/accounts/executive-commission');
}
}
function editexcomm(Request $req,$id){
 if(session('id')!=""){
      $voucher  = vouchergeneration::where('voucherid','148')
              ->select('slno','constants')->first();
if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=commissioncalculation::select('slno')
                       ->where('enrty_no',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=commissioncalculation::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
$exes =executive::orderBy('short_name','asc')->get();
$datas =    commissioncalculation::orderBy('id','desc')
          ->get();
          $co =commissioncalculation::leftJoin('executives', 'executives.short_name', '=', 'commissioncalculations.executive')
            ->select('commissioncalculations.*','executives.comm_pay_account')->find($id);
          $account=account::where('category','cash')
                   ->orWhere('category','bank')
                   ->select('id','printname')->get();
return view('accounts/masters/executivecommedit',['nslno'=>$nslno,'exes'=>$exes,'datas'=>$datas,'voucher'=>$voucher,'co'=>$co,'account'=>$account]);
}
else{
 return redirect('/'); 
}

  }
}
