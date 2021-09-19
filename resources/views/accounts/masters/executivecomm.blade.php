@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span>Executive Commission Calculation
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
                    <form class="forms-sample" action ="{{('/createexcecomm')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Entry#</span>
                        </div>
                        @if(!empty($voucher->slno) )
                        <input type="text" class="form-control"  name="enrty_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                        @else

                        <input type="text" class="form-control"  name="" id="code" value=""  readonly >
                         @endif
                       
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dates" value="{{ old('name') }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                          <select  class="form-control"  name="executive" value="{{ old('short_name') }}" required id="executive">
                          <option value="" hidden>Executive</option>
                          @foreach($exes as $cat)
                          <option value="{{$cat->short_name}}" >{{$cat->short_name}}</option>
                          @endforeach
                        </select>
                       
                      </div>
                    </div>
                </div>
                
                
            </div>
            <div class="resultss">
            <div class="row">
               
                    <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Income</span>
                        </div>
                      <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                       
                      </div>
                    </div>
                </div>
                   <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Expense</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Profit</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Comm.Payable</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Comm Paid</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
                 <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Balance</span>
                        </div>
                          <input type="text"  class="form-control"  name="amount" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
              </div>
            </div>
              <div class="row">

              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Payment Mode </span>
                        </div>
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Payment Mode</option>
                         
  <option value="1" >Cash</option>
 <option value="2" >Bank</option>
 <!--  <option value="3" >DD</option>
   <option value="4" >Online Transfer</option>
   <option value="5" >None</option> -->
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pay Balance Amt</span>
                        </div>
                          <input type="text"  class="form-control"  name="paycommission" value="{{ old('short_name') }}" required>
                         
                       
                      </div>
                    </div>
                </div>
                
                
            </div>
             <div class="row results">

               
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
        <h5 class="modal-title" id="companyModalLabel">Executive Commission Details</h5>
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
      <th scope="col">Paid Amount</th>
     
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/commission/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/commission/{{$data->id}}">{{ $data->executive }}</a></td>
      <td><a href="/accounts/commission/{{$data->id}}">{{$data->paycommission}}</a></td>
    
    
     
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
 $("#executive").change(function(){
   vid=$("#executive").val();
   csrf=$("#token").val();
   
    $.ajax({
         type: "POST",
         url: "{{url('loadexccommission')}}",
         data: {vid: vid,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
              $(".resultss").html(data);
               }
          });



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
                //alert(data);
                $('.results').html(data);
                  }
          });

  });
</script>
@stop