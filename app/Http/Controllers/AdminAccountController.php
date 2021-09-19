<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\account;
class AdminAccountController extends Controller
{
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


        return view('admin/account/accounts',compact('categories','allCategories','accounts','accid'));
    	
    }
   else{
 return redirect('/'); 

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


        return view('admin/account/editaccounts',compact('categories','allCategories','accounts','accid','acc','pname'));
      
    }
   else{
 return redirect('/'); 

   }  
   
}
function editsaccounts(Request $req){
account::where('id', $req->input('id'))
              ->update(['active'=>$req->input('active'),'name'=>$req->input('name'),'printname'=>$req->input('printname'),'description'=>$req->input('description'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

   }

function getutility(){
  if(session('id')!=""){
    
      return view('admin/utility/changepassword');
    }
   else{
 return redirect('/'); 

   } 
}
function updatepassword(Request $req){
$req->validate([
    'password' => 'required|confirmed'
]);

$pword = $req->input('oldpassword');
 $user=User::find(session('id'));
if (!Hash::check($pword, $user->password)) {

$req->session()->flash('failed', 'Old password is incorrect!');
return redirect('/admin/utility'); 
 
}else{
   DB::table('users')
            ->where('id',session('id'))
            ->update(['password' => Hash::make($req->password)                   
                  ]);
$req->session()->flash('status', 'Task was successful!');
return redirect('/');

}
}
function getfullcode(Request $req){
 $und = $req->get('und');
 $accnt = account::select('fullcode')
         ->where('id',$und)->first();
         $output="";
        $output .='<input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="fullcode" id="fullcode" value="'.$accnt->fullcode.'" >'; 
        echo $output;

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
return redirect('/admin/account-details');
 }
}
function getajaxaccount(Request $req){
 $fullcode=$req->get('fullcode');
 $name=$req->get('name');
 $under=$req->get('under');
 $idd=$req->get('idd');
  $acccat = $req->get('acccat');
 $seqnumber=$req->get('seqnumber');
 $fcode = $fullcode.$idd.'#';
 $acc = account::where('name',$name)
       ->where('parentid',$under)
        ->count();
 if($acc > 0){
 return '<div class="alert alert-danger">A/C name exist please try another name</div>'; 

 }
elseif($req->input('fullcode')==""){
  return '<div class="alert alert-danger">Something went wrong please try later</div>';  
}
 else{
$acc1 = account::where('seqnumber',$seqnumber)->count();
if($acc1 > 0){
return '<div class="alert alert-danger">This A/C number exist</div>';
}else{
$account =account::updateOrCreate(
  ['seqnumber'=>$seqnumber],
['accounttype'=>'a1','active'=>'1','name'=>$name,'printname'=>$name,'parentid'=>$under,'fullcode'=>$fcode,'category'=>$acccat,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  return '<div class="alert alert-success">Data updated successfully</div>';
}

 }

}

 public function manageCategory()
    {
        $categories = account::where('parentid', '=', 0)->get();
        $allCategories = account::pluck('name','id')->all();
        return view('admin/account/testtree',compact('categories','allCategories'));
    }
}