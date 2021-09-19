@extends('inventory/layout')
@section ('content')

@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history  menu-icon"></i>
                </span>Stock Transfer Details
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
                    <form class="forms-sample" action ="{{('/createtransfer')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Transfer#</span>
                        </div>
                       
                        <input type="text" class="form-control"  name="transfer_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="transfer_date" value="{{ old('transfer_date') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Transfer To</span>
                        </div>
                        <select class="form-control"  name="transfer_to" required="" >
                          <option value="" hidden>Location</option>
                     @foreach($store as $cust)
                        <option value="{{$cust->id,old('transfer_to')}}" >{{$cust->locationname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            </div>
          
                
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required add-on">Item</span>
                       
                         <select class="form-control mySelect2 itemvalue "  name="" id="item" >
                          <option value="" hidden>Item</option>
                          @foreach($item as $row)
                         <option value="{{$row->id}}" >{{$row->code}}/{{$row->item}}/{{$row->part_no}}/({{$row->sumqnty}})</option>
                        @endforeach
                    
                        </select>
                           </div> 
                        
                      </div>
                    </div>
                </div>
               <div class="col-md-1 poppup">
                              
                
                 </div>
                 </div>
                 <div class="row">
                  <div class="col-md-12">
                  <div class="alert alert-danger" role="alert" id="myalertdiv" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">×</button></div>
</div>
                 </div>
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>

                           <th>Batch</th>
                            <th> Qnty</th>
                            
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div class="row" >
                <div class="col-md-12">
                <table class="table table-striped stocktable" id="stocktable" style="display:none;"  >
                      <thead>
                       
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-8">
                  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Remarks</span>
                        </div>
                        <textarea class="form-control"  name="remarks" value="{{ old('remarks') }}" >
                        </textarea>
                        
                      </div>
                    </div>
                 
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Amount</span>
                        </div>
                        <input type="text" class="form-control totalcost" aria-label="Amount (to the nearest dollar)" name="total_amount" value="{{ old('total_amount') }}" required="required"  readonly="">
                        
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
        <h5 class="modal-title" id="companyModalLabel">Stock Issue Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Transfer#</th>
      <th scope="col">Date</th>
      <th scope="col">Transfer To</th>
   
  
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/transfer/{{$data->id}}">{{$data->transfer_no}}</a></td>
      <td><a href="/inventory/transfer/{{$data->id}}">{{ \Carbon\Carbon::parse($data->transfer_date)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/transfer/{{$data->id}}">{{$data->locationname}}</a></td>
     
  
     
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
 <script type="text/javascript">
     $(function(){
 $(".itemvalue").change(function(){
               itemid = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getcurrentstockissue')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(result){
            $(".poppup").html(result);
                $('.currenytstock').modal('show')

              }
          });
   });
                })
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
item_id = row.find("th input.doitemid").val();
   ntotal = $(".totalcost").val();
   qty = row.find("td input.ammt").val();
$(".totalcost").val((ntotal - qty).toFixed(3));
  $(".stocktable tr").each(function(){
       $(this).find('td input.idid').each(function(){
          var currentText = $(this).val();
 if(currentText == item_id){
              $(this).parents('tr').remove();
          }
      });
   });
   });
              </script>
@stop