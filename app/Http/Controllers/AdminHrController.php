<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\vouchergeneration;
use App\Models\module;
use App\Models\User;
use App\Models\businesstype;
use App\Models\currency;
use App\Models\customer;
use App\Models\customerexecutivedetail;
use App\Models\employee;
use App\Models\contract;
use App\Models\indemnity;
use App\Models\leavesalary;
use App\Models\overtime;
use App\Models\vehicle;
use App\Models\account;
use App\Models\salarycalculation;
use App\Models\salarycalculationmain;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
class AdminHrController extends Controller
{
       function getemployee(){
    if(session('id')!=""){
     $emps =employee::select('id','empid','name','curposition')->get();
     $emp =employee::select('slno')->orderBy('id' ,'Desc')->take(1)->first();
     $no =1;
     if(empty($emp->slno))
     {
     $nepm=1;
      
    $empid = 'APS'.$nepm;
          }
      else
      {
  $nepm =$emp->slno + 1;
  $empid = 'APS'.$nepm;
    }
 $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('active','1')
                   ->whereIn('id',array(10, 64, 310))
                   ->orderBy('printname','Asc')->get();
                    $acccat ='others';
  $accountslist = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->whereIn('parentid',array(10, 64, 310))
                   ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->orderBy('printname','Asc')->get();
              $status ='accemp';
    	return view('admin/hr/employee',['emps'=>$emps,'empid'=>$empid,'nepm'=>$nepm,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'accountslist'=>$accountslist,'acccat'=>$acccat,'status'=>$status]);
 
    }
   else{
 return redirect('/'); 
}
}
function createemployee(Request $req){
	$validator =  $req ->validate([
'empid'=>'required',
'name'=>'required',
'dob'=>'required|date',
'bsalary'=>'required',
'accname'=>'required|unique:employees'
],['accname.unique'=>'Sorry this A/C name already taken']);
	$emp =employee::updateOrCreate(
  ['empid'=>$req->input('empid'),'name'=>$req->input('name'),],
['slno'=>$req->input('slno'),'dob'=>$req->input('dob'),'dateofjoining'=>$req->input('dateofjoining'),'joiningposition'=>$req->input('joiningposition'),'department'=>$req->input('department'),'curposition'=>$req->input('curposition'),'salaried'=>$req->input('salaried'),'approve'=>$req->input('approve'),'bsalary'=>$req->input('bsalary'),'allowance'=>$req->input('allowance'),'vehicleno'=>$req->input('vehicleno'),'accname'=>$req->input('accname'),'address'=>$req->input('address'),'actualdob'=>$req->input('actualdob'),'homeaddr'=>$req->input('homeaddr'),'kwttel1'=>$req->input('kwttel1'),'kwttel2'=>$req->input('kwttel2'),'hometel'=>$req->input('hometel'),'email'=>$req->input('email'),'emergency1'=>$req->input('emergency1'),'emergency1no'=>$req->input('emergency1no'),'emergency2'=>$req->input('emergency2'),'emergency2no'=>$req->input('emergency2no'),'spouse'=>$req->input('spouse'),'spouseno'=>$req->input('spouseno'),'nochildren'=>$req->input('nochildren'),'education'=>$req->input('education'),'passportno'=>$req->input('passportno'),'weddate'=>$req->input('weddate'),'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/employee-details');

} 
function editemployee($id){
 if(session('id')!=""){
    $emmp =employee::leftJoin('accounts', function($join) {
      $join->on('employees.accname', '=', 'accounts.id');
        })->select('employees.*','accounts.printname')
    ->where('employees.id',$id)->first();
     $emps =employee::select('id','empid','name','curposition')->get();
    return view('admin/hr/employeeedit',['emps'=>$emps,'emmp'=>$emmp]);
 
    }
   else{
 return redirect('/'); 
}


}

function editsemployees(Request $req){
$emp =employee::where('id', $req->input('id'))->update(
['dob'=>$req->input('dob'),'dateofjoining'=>$req->input('dateofjoining'),'joiningposition'=>$req->input('joiningposition'),'department'=>$req->input('department'),'curposition'=>$req->input('curposition'),'approve'=>$req->input('approve'),'bsalary'=>$req->input('bsalary'),'allowance'=>$req->input('allowance'),'vehicleno'=>$req->input('vehicleno'),'address'=>$req->input('address'),'actualdob'=>$req->input('actualdob'),'homeaddr'=>$req->input('homeaddr'),'kwttel1'=>$req->input('kwttel1'),'kwttel2'=>$req->input('kwttel2'),'hometel'=>$req->input('hometel'),'email'=>$req->input('email'),'emergency1'=>$req->input('emergency1'),'emergency1no'=>$req->input('emergency1no'),'emergency2'=>$req->input('emergency2'),'emergency2no'=>$req->input('emergency2no'),'spouse'=>$req->input('spouse'),'spouseno'=>$req->input('spouseno'),'nochildren'=>$req->input('nochildren'),'education'=>$req->input('education'),'passportno'=>$req->input('passportno'),'weddate'=>$req->input('weddate'),'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}
function getcontract(){
          if(session('id')!=""){

$contracts=contract::orderBy('empname','Asc')->get();
$emp=employee::select('empid','id')->get();

    return view('admin/hr/contract',['contracts'=>$contracts,'emp'=>$emp]);
    }
   else{
 return redirect('/'); 
} 
}
function getempcontract(Request $req){
  $emp = $req->get('emp');
   $emp = employee::find($emp);
 return view('admin/hr/getempdetails',['emp'=>$emp]);
}
function editcontract($id){
            if(session('id')!=""){
 $con =contract::find($id);
$contracts=contract::orderBy('empname','Asc')->get();
$emp=employee::select('empid','id')->get();

    return view('admin/hr/contractedit',['contracts'=>$contracts,'emp'=>$emp,'con'=>$con]);
    }
   else{
 return redirect('/'); 
}
 

}
function createcontract(Request $req){
  $djoin=$req->input('dateofjoin');
  $pjoin=$req->input('probperiodstart');
  $pejoin=$req->input('probperiodend');
  $nddate = Carbon::parse($djoin)->format('Y-m-d');
  $npdate = Carbon::parse($pjoin)->format('Y-m-d');
  $npedate = Carbon::parse($pejoin)->format('Y-m-d');
  $contract =contract::updateOrCreate(
  ['empno'=>$req->input('empno'),'empname'=>$req->input('empname'),],
['position'=>$req->input('position'),'dateofjoin'=>$nddate,'contractperiod'=>$req->input('contractperiod'),'probperiodstart'=>$npdate,'probperiodend'=>$npedate,'probsalary'=>$req->input('probsalary'),'ticket'=>$req->input('ticket'),'moballowance'=>$req->input('moballowance'),'vehicle'=>$req->input('vehicle'),'fuelallowance'=>$req->input('fuelallowance'),'accommodation'=>$req->input('accommodation'),'food'=>$req->input('food'),'leavedetails'=>$req->input('leavedetails'),'penality'=>$req->input('penality'),'confirmsalary'=>$req->input('confirmsalary'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/contract-details');
}
function editscontracts(Request $req){
$djoin=$req->input('dateofjoin');
  $pjoin=$req->input('probperiodstart');
  $pejoin=$req->input('probperiodend');
  $nddate = Carbon::parse($djoin)->format('Y-m-d');
  $npdate = Carbon::parse($pjoin)->format('Y-m-d');
  $npedate = Carbon::parse($pejoin)->format('Y-m-d');
  contract::where('id',$req->input('id'))
  ->update(['empno'=>$req->input('empno'),'empname'=>$req->input('empname'),
'position'=>$req->input('position'),'dateofjoin'=>$nddate,'contractperiod'=>$req->input('contractperiod'),'probperiodstart'=>$npdate,'probperiodend'=>$npedate,'probsalary'=>$req->input('probsalary'),'ticket'=>$req->input('ticket'),'moballowance'=>$req->input('moballowance'),'vehicle'=>$req->input('vehicle'),'fuelallowance'=>$req->input('fuelallowance'),'accommodation'=>$req->input('accommodation'),'food'=>$req->input('food'),'leavedetails'=>$req->input('leavedetails'),'penality'=>$req->input('penality'),'confirmsalary'=>$req->input('confirmsalary'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}
function getindemnity(){
          if(session('id')!=""){

$inds=indemnity::orderBy('id','Asc')->get();

    return view('admin/hr/indemnity',['inds'=>$inds]);
    }
   else{
 return redirect('/'); 
} 
}
function updateindemnity(Request $req){
 $id=$req->id;
        $rate=$req->rate;
          $count =count($id);
for ($i=0; $i < $count; $i++){
 $indemnity =indemnity::updateOrCreate(
  ['id'=>$id[$i],],
['rate'=>$rate[$i],'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
}
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/indemnity-details');
}
function getleavesalary(){
          if(session('id')!=""){

$leaves =leavesalary::orderBy('id','Asc')->get();

    return view('admin/hr/leavesalary',['leaves'=>$leaves ]);
    }
   else{
 return redirect('/'); 
}  
}
function editleavesalary($id){
          if(session('id')!=""){
$leave =leavesalary::find($id);
$leaves =leavesalary::orderBy('id','Asc')->get();

    return view('admin/hr/leavesalaryedit',['leaves'=>$leaves,'leave'=>$leave ]);
    }
   else{
 return redirect('/'); 
}


}
function createleavesalary(Request $req){
$leavesalary =leavesalary::updateOrCreate(
  ['leavesalary'=>$req->input('leavesalary'),],
['cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/leave-salary');
}
function editsleavesalarys(Request $req){
leavesalary::where('id', $req->input('id'))
              ->update(['leavesalary'=>$req->input('leavesalary'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();



}
function getovertime(){
if(session('id')!=""){

$overs =overtime::orderBy('id','Asc')->get();

    return view('admin/hr/overtime',['overs'=>$overs ]);
    }
   else{
 return redirect('/'); 
}   
}
function createovertime(Request $req){
  $id=$req->id;
        $rate=$req->rate;
          $count =count($id);
for ($i=0; $i < $count; $i++){
 overtime::updateOrCreate(
  ['id'=>$id[$i],],
['rate'=>$rate[$i],'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
}
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/overtime');
}
function getvehicle(){
 if(session('id')!=""){

$overs =vehicle::orderBy('vehicletype','Asc')->get();

    return view('admin/hr/vehicle',['overs'=>$overs ]);
    }
   else{
 return redirect('/'); 
}  
}
function editvehicle($id){
 if(session('id')!=""){
$veh =vehicle::find($id);
$overs =vehicle::orderBy('vehicletype','Asc')->get();

    return view('admin/hr/vehicleedit',['overs'=>$overs,'veh'=>$veh ]);
    }
   else{
 return redirect('/'); 
}



}
function createvehicle(Request $req){
  $purchasedate=$req->input('purchasedate');
  $registrationexpiry=$req->input('registrationexpiry');
  $insuranceexpiry=$req->input('insuranceexpiry');
  $salesdate=$req->input('salesdate');
  $purchasedates = Carbon::parse($purchasedate)->format('Y-m-d');
  $registrationexpirys = Carbon::parse($registrationexpiry)->format('Y-m-d');
  $insuranceexpirys = Carbon::parse($insuranceexpiry)->format('Y-m-d');
  $salesdates = Carbon::parse($salesdate)->format('Y-m-d');
$vehicle =vehicle::updateOrCreate(
  ['vehicleno'=>$req->input('vehicleno'),],
['vehicletype'=>$req->input('vehicletype'),'manufactyear'=>$req->input('manufactyear'),'purchasedate'=>$purchasedates,'purchaseamount'=>$req->input('purchaseamount'),'registrationexpiry'=>$registrationexpirys,'insurance'=>$req->input('insurance'),'insuranceexpiry'=>$insuranceexpirys,'salesdate'=>$salesdates,'active'=>$req->input('active'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/vehicle-details');
}

function editsvehicles(Request $req){
$purchasedate=$req->input('purchasedate');
  $registrationexpiry=$req->input('registrationexpiry');
  $insuranceexpiry=$req->input('insuranceexpiry');
  $salesdate=$req->input('salesdate');
  $purchasedates = Carbon::parse($purchasedate)->format('Y-m-d');
  $registrationexpirys = Carbon::parse($registrationexpiry)->format('Y-m-d');
  $insuranceexpirys = Carbon::parse($insuranceexpiry)->format('Y-m-d');
  $salesdates = Carbon::parse($salesdate)->format('Y-m-d');

  vehicle::where('id', $req->input('id'))
              ->update(['vehicleno'=>$req->input('vehicleno'),'vehicletype'=>$req->input('vehicletype'),'manufactyear'=>$req->input('manufactyear'),'purchasedate'=>$purchasedates,'purchaseamount'=>$req->input('purchaseamount'),'registrationexpiry'=>$registrationexpirys,'insurance'=>$req->input('insurance'),'insuranceexpiry'=>$insuranceexpirys,'salesdate'=>$salesdates,'active'=>$req->input('active'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}
function getcalsalary(){
if(session('id')!=""){

$contracts=contract::orderBy('empname','Asc')->get();
$emp=employee::orderBy('name','asc')->get();
 $over1 = overtime::find(1);
  $over2 = overtime::find(2);
  $over3 = overtime::find(3);
    return view('admin/hr/salarycalculation1',['contracts'=>$contracts,'emp'=>$emp,'over1'=>$over1,'over2'=>$over2,'over3'=>$over3,]);
    }
   else{
 return redirect('/'); 
}  
}
function getcalsssalary(Request $req){
  $name =$req->name;
  $month =$req->month;
  $year =$req->year;
   $emp =employee::find($name);
    $salcal =salarycalculation::where('name',$name)
        ->where('month',$month)
        ->where('year',$year)->first();

    $net =$emp->bsalary + $emp->allowance;
   $over1 = overtime::find(1);
  $over2 = overtime::find(2);
  $over3 = overtime::find(3);
  return view('admin/hr/employeeview',['emp'=>$emp,'year'=>$year,'month'=>$month,'over1'=>$over1,'over2'=>$over2,'over3'=>$over3,'net'=>$net,'salcal'=>$salcal]);
}
function createsalarycalculation(Request $req){
  $balance =$req->input('totalnetsalary') +$req->input('totaladvance');
  $nddate = Carbon::parse(now())->format('Y-m-d');
  $salary =salarycalculationmain::updateOrCreate(
  ['voucher'=>$req->input('voucher'),],
  ['keycode'=>$req->input('keycode'),'workingdays'=>$req->input('workingdays'),'totalnetsalary'=>$req->input('totalnetsalary'),'totaladvance'=>$req->input('totaladvance'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'month'=>$req->input('month'),'year'=>$req->input('year'),'balance'=>$req->input('totalnetsalary'),'dates'=>$nddate,'advncebalnce'=>$req->input('totaladvance')]);
if($salary){
        $name =$req->name;
        $bsalary=$req->bsalary;
        $allowance = $req->allowance;
        $addallowance=$req->addallowance;
        $workeddays=$req->workeddays;
        $norover=$req->norover;
        $frover=$req->frover;
        $holover=$req->holover;
        $nrrate = $req->nrrate;
        $frrate=$req->frrate;
        $hrrate=$req->hrrate;
        $thissalary=$req->thissalary;
        $deduction = $req->deduction;
        $nettotal=$req->nettotal;
        $advance=$req->advance;
        $amount=$req->amount;
       $count =count($name);
for ($i=0; $i < $count; $i++){
  $nramount=$nrrate[$i] *$norover[$i];
  $framount=$frrate[$i] *$frover[$i];
  $holamount=$hrrate[$i] *$holover[$i];
  salarycalculation::updateOrCreate(
  ['name'=>$name[$i],'slid'=>$salary->id,'bsalary'=>$bsalary[$i],],
['allowance'=>$allowance[$i],'addallowance'=>$addallowance[$i],'norover'=>$norover[$i],'frover'=>$frover[$i],'holover'=>$holover[$i],'nramount'=>$nramount,'framount'=>$framount,'holamount'=>$holamount,'thissalary'=>$thissalary[$i],'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'deduction'=>$deduction[$i],'nettotal'=>$nettotal[$i],'advance'=>$advance[$i],'amount'=>$amount[$i],'workeddays'=>$workeddays[$i]]);
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalnetsalary'),'totcredit'=>$req->input('totalnetsalary'),'created_by'=>session('name'),'remarks'=>$req->input('voucher'),'approved_by'=>session('name'),'from_where'=>'Salary Calculation','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'59','narration'=>$req->input('voucher'),'amount'=>$req->input('totalnetsalary'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'357','narration'=>$req->input('voucher'),'amount'=>$req->input('totalnetsalary'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
  $req->session()->flash('status', 'Data updated successfully!');
  return redirect()->back();
}
}

function accload(Request $req){
    $status = $req->get('status');
  if($status == 'acccust'){
     $accounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->where('parentid',8)
                   ->orderBy('printname','Asc')->get();
$output="";
foreach($accounts as $row){
$output .='<option value="'.$row->id.'">'.$row->printname.'</option>';

}
echo $output;

}elseif($status == 'accemp' || $status == 'accexce'){

  
$accounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->whereIn('parentid',array(10, 64, 310))
                   ->orderBy('printname','Asc')->get();
$output="";
foreach($accounts as $row){
$output .='<option value="'.$row->id.'">'.$row->printname.'</option>';

}
echo $output;

}
elseif( $status == 'accvend'){
$accounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->where('parentid','15')
                   ->orderBy('printname','Asc')->get();
$output="";
foreach($accounts as $row){
$output .='<option value="'.$row->id.'">'.$row->printname.'</option>';

}
echo $output;

}
}
function getvouchernumber(Request $req){
 $month =$req->month;
$year = $req->year;
$mmonth =substr($month,0,3);
 $gen1 = $mmonth.'/'.$year.'/';
 $slno =salarycalculationmain::select('slno')
        ->where('keycode',$gen1)->first();
        if(empty($slno)){
$gen = $mmonth.'/'.$year.'/'.'1';
$nslno='1';
}else{
 $nslno =$slno->slno + 1; 
 $gen =$mmonth.'/'.$year.'/'.$nslno;
}
$output="";

$output .='<div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vchr#</span>
                        </div>
                       <input type="text" class="form-control "  name="voucher" value="'.$gen.'" readonly >
                       <input type="hidden" class="form-control "  name="keycode" value="'.$gen1.'" readonly >';

echo $output;
}
}
