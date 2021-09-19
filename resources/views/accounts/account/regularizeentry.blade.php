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
                </span>Regularize Voucher Entry
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
                    <form class="forms-sample" action ="{{('/createreguentry')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row ">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="enddate" >
                        
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
  <th>#</th>
<th>Voucher#</th>
<th>Particular</th>
<th>Amount</th>
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
                          <span class="input-group-text bg-gradient-info text-white required">Regularized By</span>
                        </div>
                        <input type="text" class="form-control "   name="approved_by" value="{{ session('name') }}" required >
                       
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
$("#startdate,#enddate").keyover(function(){
  startdate = $("#startdate").val();
  csrf=$("#token").val();
  enddate=$("#enddate").val();
  //alert(startdate);
   $.ajax({ 
         type: "POST",
         url: "{{url('getoptional')}}", 
         data: {startdate: startdate,_token:csrf,enddate:enddate},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.number').html(data);
                  }
          });
   
   });
 
</script>
@stop