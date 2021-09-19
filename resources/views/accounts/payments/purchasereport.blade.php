@extends('accounts/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Purchase Report 
              
            </div> 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
           
                    <p class="card-description"> 
                    </p>
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
         <div class="row">
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Vendor</span>
                        </div>
                       <select  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="vendor" >
                        <option value="" hidden >Vendor</option>
                        @foreach($custs as $cust)

 <option value="{{$cust->account}}" >{{$cust->short_name}}</option>
                        @endforeach
                      </select>
                      </div>
                    </div>
                </div>
                
         </div>
         <div class="row">
          <div class="col-md-12 result">
            
          </div>
        </div>

              </div>
                  </div>
                </div>

             
             <script src="/assets/js/jquery-3.6.0.min.js"></script>
             
<script type="text/javascript">
                $("#vendor").change(function(){
               vendor = $(this).val();
               token = $("#token").val();
             $.ajax({
         type: "POST",
         url: "{{url('getpurreport')}}", 
         data: {vendor:vendor,_token: token},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".result").html(data);
            

              }
          });

                })
</script>
                @stop