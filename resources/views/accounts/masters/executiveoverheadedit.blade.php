@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Executive Overhead / Sales Commission
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
                    <form class="forms-sample" action ="{{('/createoverhead')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Voucher#</span>
                        </div>
                      
                        <input type="text" class="form-control"  name="ovr_no" id="code" value="{{ $ovr->ovr_no }}"  readonly >
                       
                        
                       
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dates" value="{{ \Carbon\Carbon::parse($ovr->dates)->format('j -F- Y')  }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">OverHead Type </span>
                        </div>
                        <select  class="form-control OverHead"  name="overhead_type" value="{{ old('short_name') }}" required id="OverHead">
                          <option value="" hidden>OverHead Type </option>
                         
                          <option value="overhead" {{($ovr->overhead_type == 'overhead' ? 
                             'selected' : '') }}>Overhead</option>
                          <option value="salescommission" {{($ovr->overhead_type == 'salescommission' ? 
                             'selected' : '') }}>Sales Commission</option>
                        
                        </select>
                        
                      </div>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                          <select  class="form-control"  name="executive" value="{{ old('short_name') }}" required id="executive">
                          <option value="" hidden>Executive</option>
                          @foreach($exes as $cat)
                          <option value="{{$cat->short_name}}" {{($ovr->executive == $cat->short_name ? 
                             'selected' : '') }} >{{$cat->short_name}}</option>
                          @endforeach
                        </select>
                       
                      </div>
                    </div>
                </div>
                    <div class="col-md-4 resultss">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Invoice</span>
                        </div>
                       <input type="text"  class="form-control "  name="invoice_no" value="{{ $ovr->invoice_no }}"  id="catid">
                          
                        
                       
                      </div>
                    </div>
                </div>
                   
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Payment Mode </span>
                        </div>
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Payment Mode</option>
                         
  <option value="1" {{($ovr->paymentmode == '1' ? 
                             'selected' : '') }}>Cash</option>
 <option value="2" {{($ovr->paymentmode == '2' ? 
                             'selected' : '') }} >Cheque</option>
  <option value="3" {{($ovr->paymentmode == '3' ? 
                             'selected' : '') }} >DD</option>
   <option value="4" {{($ovr->paymentmode == '4' ? 
                             'selected' : '') }}>Online Transfer</option>
   <option value="5" {{($ovr->paymentmode == '5' ? 
                             'selected' : '') }}>None</option>
                        </select>
                        
                      </div>
                    </div>
                </div>
                
                
            </div>
             <div class="row results">

               
             </div>
             <div class="row">
              <div class="col-md-4">
              </div>
               <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Amount</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ $ovr->amount }}" required>
                         
                       
                      </div>
                    </div>
                </div>
             </div>
                 
              <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
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
        <h5 class="modal-title" id="companyModalLabel">Over Head / Sales Commission Details</h5>
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
      <th scope="col">Date</th>
      <th scope="col">Executive</th>
      <th scope="col">Overhead Type</th>
      <th scope="col">Amunt</th>
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/executive-overhead/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/executive-overhead/{{$data->id}}">{{ $data->executive }}</a></td>
      <td><a href="/accounts/executive-overhead/{{$data->id}}">{{$data->overhead_type}}</a></td>
      <td><a href="/accounts/executive-overhead/{{$data->id}}">{{$data->amount}}</a></td>
    
     
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
 $("#executive,#OverHead").change(function(){
   vid=$("#executive").val();
   csrf=$("#token").val();
   OverHead =$(".OverHead").val();
   if(OverHead =='salescommission'){
  $.ajax({
         type: "POST",
         url: "{{url('loadinvs')}}",
         data: {vid: vid,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
              $(".resultss").html(data);
               }
          });
}


})
 ///////////////////// Load Payment Mode/////////
   $('.paymentMode').change(function(){
  pay = $('.paymentMode').val();
   csrf=$("#token").val();
   //alert(pay);
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