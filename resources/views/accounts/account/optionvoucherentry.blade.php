@extends('accounts/layout')
@section ('content')
<style type="text/css">
  td{
    padding:0px!important;
    height:50%!important;
  }
  td input, td select{
padding:0px!important;
border-color:white!important;
height: 100%!important;
  }
</style>
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Optional Voucher Entry
              </h3>
              
            </div>
 <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
                                                        @if (session('status'))
<div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action ="{{('/createopentry')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row ">
                    <div class="col-md-3 number">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Voucher#</span>
                        </div>
                      <input type="text" class="form-control"  name="voucher_no"  value=""  readonly >
                        <input type="hidden" class="form-control"  name="voucher"  value=""  readonly >
                        <input type="hidden" class="form-control"  name="slno"  value=""  readonly >
                        <input type="hidden" class="form-control"  name="keycode"  value=""  readonly >
                     
                       
                      </div>
                    </div>
                </div>
                   	<div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"   name="dates" value="{{ old('dates') }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vouch.Type </span>
                        </div>
                        <select  class="form-control voucher"  name="" value="{{ old('short_name') }}" required id="voucher">
                           <option value="" hidden>Voucher Type </option>
                         <option value="P" >Payment</option>
                         <option value="R" >Receipt</option>
                         <option value="Con" >Contra</option>
                         <option value="Jr" >Journal</option>
                         <option value="Pv" >Purchase</option>
                          <option value="Sv" >Sales</option>
                          <option value="DN" >Debit Note</option>
                        <option value="CN" >Credit Note</option>
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"id="bankcash">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">From</span>
                        </div>
                        <select  class="form-control borc"  name="froms" value="{{ old('froms') }}" required >
                         
                         <option value="B" >Bank</option>
                         <option value="C" >Cash</option>
                        
                        
                        </select>
                        
                      </div>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body ">
                   
                   <table class="table table-bordered ItemGrid" id="ItemGrid">
                     <thead>
  <tr>
    <th rowspan="2">#</th>
    <th rowspan="2">DR/CR</th>
    <th rowspan="2">Account</th>
<th rowspan="2">Narration</th>
<th colspan="4">Cheque Details</th>
<th rowspan="2">Debit</th>
 <th rowspan="2">Credit</th>
  </tr>
  <tr>
  <th>Cheq.No</th>
<th>Cheque Date</th>
<th>Cheque Bank</th>
<th>Clearance Date</th>
  </tr>
  </thead>
  <tbody>
    
  </tbody>
                   </table>
                   </div>
                   </div>
                   </div>

             </div>
                  <div class="row ">
                    
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Approved By</span>
                        </div>
                        <input type="text" class="form-control "   name="approved_by" value="{{ session('name') }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Debit </span>
                        </div>
                        <input type="text" class="form-control totdebit"   name="totdebit" value="" required >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"id="">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Credit</span>
                        </div>
                        <input type="text" class="form-control totcredit"   name="totcredit" value="" required >
                        
                      </div>
                    </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-md-12 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Remarks</span>
                        </div>
                        

                        <textarea  class="form-control"  name="remarks"   >
                        </textarea>
                     
                       
                      </div>
                    </div>
                </div>
                </div>
              <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
          </div>
        </div>
                    
                  
                </form>
                </div>
                </div>
              </div>
<!-- /////////////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">Regular Voucher Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body ">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Voucher#</th>
      <th scope="col">Date</th>
      <th scope="col">Description</th>
      <th scope="col">Amount</th>
      
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/regular-entry/{{$data->id}}">{{$data->voucher_no}}</a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">
        {{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">@if(!empty($data->remarks)){{$data->remarks}}@else {{$data->from_where}} @endif </a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">{{$data->totcredit}}</a></td>
      
    
    
  
     
    </tr>
   @endforeach
  </tbody>
</table>
                  </div>
                </div>
              </div>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              </div>
    </div>
  </div>
</div>
<!-- ///////Js Start here//////////////////// -->
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  ////////////// Load Invoices////////////////////
$("#voucher,.borc").change(function(){
  voucher = $("#voucher").val();
  csrf=$("#token").val();
  borc=$(".borc").val();
  if(voucher =='P' || voucher =='R'){
    $("#bankcash").show();
   
  }
  
  else{
    $("#bankcash").hide();
  }
   $.ajax({ 
         type: "POST",
         url: "{{url('getvouchernumber')}}", 
         data: {voucher: voucher,_token:csrf,borc:borc},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.number').html(data);
                  }
          });
   $.ajax({ 
         type: "POST",
         url: "{{url('getaccounthead')}}", 
         data: {voucher: voucher,_token:csrf,borc:borc},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.ItemGrid tbody').html(data);
                  }
          });
   });
  ///////////////////// Load Payment Mode/////////
   $('.paymentMode').change(function(){
  pay = $('.paymentMode').val();
   csrf=$("#token").val();
 
  $.ajax({ 
         type: "POST",
         url: "{{url('getbankorcash')}}", 
         data: {pay: pay,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                alert(data);
                $('.results').html(data);
                  }
          });

  });
</script>
@stop