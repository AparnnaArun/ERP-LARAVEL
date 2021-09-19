@extends('admin/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Item Master Details
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
                    <form class="forms-sample" action ="{{('/createitem')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                        <div id="localcode">

                      <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Code</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="code" id="code" value="{{$nslno, old('code') }}"  readonly="readonly" >

                         <input type="hidden" class="form-control sllno" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="slno"  id="sllno" value="{{$nslno}}"  readonly="readonly">
                        <div class="input-group-append">
                          <span class="input-group-text">
                           Is Local<input type="checkbox" class="form-check-input mb-1" name="islocal" id="islocal"   value="1" > </span>
                           </div>
                        </div>
                      </div>
                    </div>
                   
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Item</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="item" value="{{ old('item') }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Description</span>
                        </div>
                        
                        <textarea class="form-control " aria-label="Amount (to the nearest dollar)" name="description" value="{{ old('description') }}" >
                      </textarea>
                      </div>
                    </div>
                </div>
            </div>
             <div class="row">
              
                <div class="col-md-3">
                   <label class="form-check-label required ">Item Type</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="itemtype" value='Raw Materials'> Raw Materials </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="itemtype"   value="Byproducts" > Byproducts </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                   <label class="form-check-label"></label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="itemtype" value='Intermediate'> Intermediate </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="itemtype" 
                                value="Product" > Product  </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                   <label class="form-check-label"></label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" checked  name="itemtype" value='commodity'> Commodity </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="active" checked  value="1" > Active  </label>
                            </div>
                          </div>
                          
                           </div>
            <div class="row mt-2">
             <div class="template-demo">
                      <a href="#popup"  class="btn btn-dark btn-sm btn-fw ibutton">Item </a>
                      <a href="#popup"  class="btn btn-dark btn-sm btn-fw  vbutton">Vendor </a>
                      <a href="#popup" class="btn btn-dark btn-sm btn-fw  sbutton">Stock </a>
                       <a href="#popup" class="btn btn-dark btn-sm btn-fw  abutton">Account </a>
                      
                    </div>
            </div>
            <div class="items" >
            <div class="row mt-3">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">Brand</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="brand" required="">
                          <option value="" hidden>Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}" >{{$brand->brand}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">Category</span>
                        </div>
                       <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="category" required="">
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" >{{$cat->category}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Group</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="group" >
                           @foreach($groups as $group)
                        <option value="{{$group->id}}" >{{$group->group}}</option>
                        @endforeach
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
                          <span class="input-group-text bg-gradient-info text-white required">Unit</span>
                        </div>
                        
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="unit" required="">
                            @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" >{{$unit->shortname}}</option>
                        @endforeach
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt.Unit1</span>
                        </div>
                        
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="altunit" >
                           @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" >{{$unit->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt.Unit2</span>
                        </div>
                        
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="alt_unit1" >
                           @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" >{{$unit->shortname}}</option>
                        @endforeach
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
                          <span class="input-group-text bg-gradient-info text-white ">Unit Ratio</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="basic_unit_ratio" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt Unit1 Ratio </span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="alt_unit_ratio" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt Unit2 Ratio </span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="alt_unit1_ratio" >
                      
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Criticality</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="criticality" >
                      
                      </div>
                    </div>
                </div>
             
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cost</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="cost" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Part#</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="part_no" >
                      
                      </div>
                    </div>
                </div>
                 </div>
              <div class="row">
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="exp_applicable"   value="1" > Expiry date Applucable </label>
                            </div>
                          </div>
             
                <div class="col-md-3">
              <div class="form-check form-check-info">
                              <label class="form-check-label ">Costing Method</label>
                            </div>
                          </div>
                <div class="col-md-2">
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                  <input type="radio" class="form-check-input"   name="costing_method" value='acvo'> AVCO </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="costing_method"   value="fifo"  checked="" > FIFO </label>
                            </div>
                          </div>
                          <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="costing_method"   value="lifo" > LIFO </label>
                            </div>
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="batch_wise"   value="1" > Batch-Wise Stock </label>
                            </div>
                            
                          
                        </div>
                        <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="business_item"   value="1" > Business Item </label>
                            </div>
                          </div>
                          
                           </div>
                         </div>
                       <div class="stock" style="display: none;">
                           <div class="row mt-3">
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Min.Stock</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="minstock" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Reorder Level</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="reorder_level" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Max.Stock</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="maximum_stock" >
                      
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-4">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="automatic_reorder_level"   value="1" > Automatic Reoreder </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Intervals</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="intervals" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Reordering Days</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="reordering_quantity_days" >
                      
                      </div>
                    </div>
                </div>
            </div>
             <div class="row">
              <div class="col-md-4">
                <label class="form-check-label ">Demands On</label>
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="demand"   value="1" > All Demand </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="no_days"   value="1" > No.Of Days </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">No.Of Days</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="noofdays" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Buffer Stock</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="buffer_stock" >
                      
                      </div>
                    </div>
                </div>
            </div>
          </div>
            <div class="account" style="display:none ;">
                           <div class="row mt-3"> 
                            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Purchase A/C</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="purchase_account" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Sales A/c</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="sales_account" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Purchase Return A/C</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="purchasereturn_account" >
                      
                      </div>
                    </div>
                </div>
                           </div>
                           <div class="row">
                            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Sales Return A/C</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="salesreturn_account" >
                      
                      </div>
                    </div>
                </div>
                           </div>

                         </div>
             <div class="vendor" style="display:none;">
                          
                             <div id="dynamic_field1">
                   <div class="row mt-3" >
                    <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Vendor</span>
                        </div>
                        <select class="form-control "  name="vendor[]" id="brand"  >
                        </select>
                          
                      </div>
                    </div>
                </div>
            
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white">Max</span>
                        </div>
                        <input type="text"  class="form-control"  name="max[]" id="description"  >
                         
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white">Min</span>
                        </div>
                        <input type="text"  class="form-control"  name="min[]" id="description" >
                         
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white">rate</span>
                        </div>
                        <input type="text"  class="form-control"  name="rate[]" id="description" >
                         
                        
                      </div>
                    </div>
                </div>
                 <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white">Date</span>
                        </div>
                        <input type="text"  class="form-control datepicker"  name="dates[]" id="description" >
                         
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
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
        <h5 class="modal-title" id="companyModalLabel">Item Details</h5>
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
      <th scope="col">Code#</th>
      <th scope="col">Name</th>
      <th scope="col">Part No</th>
     <th scope="col">Category</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/item-edit/{{$item->id}}">{{$item->code}}</a></td>
      <td><a href="/admin/item-edit/{{$item->id}}">{{$item->item}}</a></td>
      <td><a href="/admin/item-edit/{{$item->id}}">{{$item->part_no}}</a></td>
      <td><a href="/admin/item-edit/{{$item->id}}">{{$item->category}}</a></td>
     
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
  //////////////////////////// Dynamic Fied For Vendors//////////////////////
  $(document).ready(function(){  
      var i=1;  
       $('#adds').click(function(){  
           i++;  
           $('#dynamic_field1').append('<div class="row" id="dynamic_field'+i+'"> <div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white ">Vendor</span></div><select class="form-control "  name="vendor[]" id="brand"  ></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend "><span class="input-group-text bg-gradient-info text-white">Max</span></div><input type="text"  class="form-control"  name="max[]" id="description"  ></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend "><span class="input-group-text bg-gradient-info text-white">Min</span></div><input type="text"  class="form-control"  name="min[]" id="description" ></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend "><span class="input-group-text bg-gradient-info text-white">rate</span></div><input type="text"  class="form-control"  name="rate[]" id="description" ></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend "><span class="input-group-text bg-gradient-info text-white">Date</span></div><input type="text"  class="form-control datepicker"  name="dates[]" id="description" ></div></div></div><div class="col-md-1 "><button type="button" class="btn btn-gradient-danger btn-sm btn_remove" id="'+i+'"><i class="mdi mdi-delete-forever"  ></i></button></div></div>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");
           //alert(button_id);  
           $('#dynamic_field'+button_id+'').remove();  
      });
    });
 //////////////////////// details tabs show/hide////////////////////////////
  $('.ibutton').addClass('actives');  
  $(".vbutton").click(function(){
  $(".vendor").show(); 
  $(".items").hide();
  $(".stock").hide();
  $(".account").hide();
  $('.vbutton').addClass('actives');   
$('.sbutton').removeClass('actives');
$('.ibutton').removeClass('actives');
$('.abutton').removeClass('actives');
  })
  $(".ibutton").click(function(){
  $(".items").show(); 
  $(".stock").hide();
  $(".account").hide();
  $(".vendor").hide();
  $('.ibutton').addClass('actives');   
$('.vbutton').removeClass('actives');
$('.sbutton').removeClass('actives'); 
$('.abutton').removeClass('actives');   
  })
  $(".sbutton").click(function(){
  $(".stock").show(); 
  $(".items").hide();
  $(".account").hide();
  $(".vendor").hide();
  $('.sbutton').addClass('actives');   
  $('.abutton').removeClass('actives');
  $('.ibutton').removeClass('actives');  
  $('.vbutton').removeClass('actives');  
  })
      $(".abutton").click(function(){
  $(".stock").hide(); 
  $(".items").hide();
  $(".account").show();
  $(".vendor").hide();
  $('.abutton').addClass('actives');   
$('.sbutton').removeClass('actives');
$('.ibutton').removeClass('actives');  
$('.vbutton').removeClass('actives');  
  })
      ////////////////////////// 

$("#islocal").click(function(){
  token=$("#token").val();
  sno =$(".sllno").val();
  //alert(sno);
 if($('input[name=islocal]:checked')){
   $.ajax({
         type: "POST",
         url: "../get_localcode", 
         data: {_token: token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $("#localcode").html(data);

              }
          });
 }
 else{

alert(sno);
$("#code").val(sno);
 }
})
</script>
@stop