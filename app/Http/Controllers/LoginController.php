<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\companyinformation;
use App\Models\User;
use App\Models\usercompany;
use App\Models\finyear;
use Auth;
use Session;
use Mail;


class LoginController extends Controller
{
    function getlogin(){
   $comps =companyinformation::select('id','short_name')->get(); 	
 $fyears =finyear::select('id','finyear')
          ->OrderBy('defaults','DESC')->get(); 	
return view('login/login',['comps'=>$comps,'fyears'=>$fyears]);
    }

    function createlogin(Request $req){
    	
          $pword = $req->input('password');
    	    $wdate = $req->input('wdate');
          $fyear = $req->input('fyear');
          $compid = $req->input('compid');
          $cname=companyinformation::select('short_name')
                  ->where('id',$compid)->first();
    	 $year = date('Y',strtotime($wdate));
    	 $lname=$req->input('lname');
    	  $count= User::select('login_name')
->where('login_name',$lname)->count();
if($count='1'){
      $user= User::select('usertype','executive')
             ->where('login_name',$lname)->first();
    	  $lname= User::where('login_name','=',$lname)->first();
         $compd =usercompany::where('userid',$lname->id) 
    	          ->where('companyid',$compid)->count();
              }

if($fyear !== $year){
	$req->session()->flash('failed', 'Finyear & working dates are not same!');
return redirect('/');  
}
elseif($count!=='1'){
	$req->session()->flash('failed', 'Sorry this loginname is not exist!');
return redirect('/');  

}
elseif($compd!='1'){

$req->session()->flash('failed', 'Sorry this User is not belongs to this company!');
return redirect('/'); 
    }
  elseif (!Hash::check($pword, $lname->password)) {

$req->session()->flash('failed', 'Wrong credentials!');
return redirect('/'); 
 
}
else{
 $req->session()->put('name', $lname->login_name );
	 $req->session()->put('fyear', $fyear);
	 $req->session()->put('wdate', $wdate );
	 $req->session()->put('cmpid', $compid );
	 $req->session()->put('id', $lname->id );
	 $req->session()->put('cname', $cname->short_name );
   $req->session()->put('utype', $user->usertype );
    $req->session()->put('exec', $user->executive );
   if($user->usertype=='Admin'){

    
     return redirect('/admin/landing-page');
   }
   else{
    return redirect('/inventory/landing-page');
   }
	
}
}
function logout(){
  Auth::logout();
   session::flush();
  return redirect('/');
}
function ajaxforget(Request $req){
     $email=$req->email;
$random = Str::random(40);

  $user= User::where('email',$email)->count();
 if($user > 0){
    $use= User::where('email',$email)->first();
     User::where('email',$email)
    ->update(['divisiton'=>$random]);
 \Mail::send('forgetpassword', array(
            'id' => $random,
          ), function($message) use ($req){
            $message->from('agrimsale@gmail.com');
            $message->to($req->email)->subject('Change Password');
        }); 


 return '<div class="alert alert-success">Please check your email to update password</div>';

}

else{
return '<div class="alert alert-danger">Email does not exist</div>';    
}

}
function viewfor(){
  return  view('forgetpassword');  
}
function uppassword($id){

return view('updatepassword',['id'=>$id]);

}
function updatepass(Request $req){
  $req->validate([
    'password' => 'required|confirmed'

]);
  User::where('divisiton', $req->input('id'))
            ->update(['password' => Hash::make($req->input('password'))]);
$req->session()->flash('status', 'Task was successful!');
return redirect('/'); 

}
}
