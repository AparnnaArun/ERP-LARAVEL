@extends('inventory/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Opening Stock Details
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
                    <form class="forms-sample" action ="{{('/createopening')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Location Name</span>
                        </div>
                       
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="location" required="" >
                          <option value="" hidden>Location</option>
                  @foreach($store as $stt)
                          <option value="{{$stt->id}}"  >{{$stt->locationname}}</option>
                           @endforeach
                        </select>
                       
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Item Type</span>
                        </div>
                        
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="itemtype" required="" >
                          @foreach($type as $tp)
                          <option value="{{$tp->type}}" {{($tp->type == 'Commodity' ? ' Selected' : '') }} >{{$tp->type}}</option>
                           @endforeach
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Category</span>
                        </div>
                        
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="category" required="" id="category">
                          <option value=""  hidden>category</option>
                          @foreach($cats as $cat)
                          <option value="{{$cat->id}}"  >{{$cat->category}}</option>
                           @endforeach
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Item</th>
                          <th>Unit</th>
                          <th>Batch</th>
                          <th>Quantity</th>
                          <th>Rate</th>
                          <th>Expiry</th>
                          <th>Inward Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
             
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled>Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
          </div>
        </div>
                    
                  
                </form>
                </div>
                </div>
              </div>
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<!-- ///////Js Start here//////////////////// -->
 <script type="text/javascript">
$("#category").change(function(){
               id = $(this).val();
               token = $("#token").val();
               //alert(id);
              $.ajax({
         type: "POST",
         url: "{{url('getallitems')}}", 
         data: {_token: token,id:id},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".ItemGrid tbody").html(result);

              }
          });

                })

$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotal = $(".nettotal").val();
   qty = row.find("td input.qnty").val();
$(".nettotal").val((ntotal - qty).toFixed(3));
      });
              </script>
@stop