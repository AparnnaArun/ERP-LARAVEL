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
                        <input type="text" class="form-control"  name="code" id="code" value="{{$item->code }}"  readonly="readonly" >

                         <input type="hidden" class="form-control sllno"  name="slno"  id="sllno" value="{{$item->slno }}"  readonly="readonly">
                        <div class="input-group-append">
                          <span class="input-group-text">
                           Is Local<input type="checkbox" class="form-check-input mb-1" name="islocal" id="islocal"   value="1" {{($item->islocal == '1' ? 
                           'checked' : '') }} > </span>
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
                        <input type="text" class="form-control"  name="item" value="{{ $item->item }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Description</span>
                        </div>
                        
                        <textarea class="form-control "  name="description" value="{{ $item->description }}" >
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
                                <input type="radio" class="form-check-input"   name="itemtype" value='Raw Materials' {{($item->item_type == 'Raw Materials' ? 
                           'checked' : '') }}> Raw Materials </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="itemtype"   value="Byproducts" {{($item->item_type == 'Raw Materials' ? 
                           'checked' : '') }} > Byproducts </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                   <label class="form-check-label"></label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="itemtype" value='Intermediate' {{($item->item_type == 'Raw Materials' ? 
                           'checked' : '') }}> Intermediate </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="itemtype" 
                                value="Product" {{($item->item_type == 'Product' ? 
                           'checked' : '') }}> Product  </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                   <label class="form-check-label"></label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="itemtype" value='commodity' {{($item->item_type == 'commodity' ? 
                           'checked' : '') }}> Commodity </label>
                            </div>
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="active"   value="1" {{($item->active == '1' ? 
                           'checked' : '') }} > Active  </label>
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
                        <select class="form-control "  name="brand" required="">
                          <option value="" hidden>Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}" {{($item->brand == $brand->id ? 'checked' : '') }} >{{$brand->brand}}</option>
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
                       <select class="form-control "  name="category" required="">
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" {{($item->category == $cat->id ? 'checked' : '') }}>{{$cat->category}}</option>
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
                        <select class="form-control "  name="group" >
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
                        
                        <select class="form-control "  name="unit" required="">
                            @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" {{($item->basic_unit == $unit->shortname ? 'checked' : '') }} >{{$unit->shortname}}</option>
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
                        
                        <select class="form-control "  name="altunit" >
                           @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" {{($item->alt_unit == $unit->shortname ? 'checked' : '') }} >{{$unit->shortname}}</option>
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
                        
                        <select class="form-control "  name="alt_unit1" >
                           @foreach($units as $unit)
                        <option value="{{$unit->shortname}}" {{($item->alt_unit1 == $unit->shortname ? 'checked' : '') }}>{{$unit->shortname}}</option>
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
                        
                        <input type="text" class="form-control "  name="basic_unit_ratio" value="{{$item->basic_unit_ratio}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt Unit1 Ratio </span>
                        </div>
                        
                        <input type="text" class="form-control "  name="alt_unit_ratio" value="{{$item->alt_unit_ratio}}">
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Alt Unit2 Ratio </span>
                        </div>
                        
                        <input type="text" class="form-control "  name="alt_unit1_ratio" value="{{$item->alt_unit1_ratio}}">
                      
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
                        
                        <input type="text" class="form-control "  name="criticality"  value="{{$item->criticality}}">
                      
                      </div>
                    </div>
                </div>
             
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cost</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="cost"  value="{{$item->cost}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Part#</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="part_no"  value="{{$item->part_no}}">
                      
                      </div>
                    </div>
                </div>
                 </div>
              <div class="row">
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="exp_applicable"   value="1" {{($item->exp_applicable == '1' ? 'checked' : '') }} > Expiry date Applucable </label>
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
                  <input type="radio" class="form-check-input"   name="costing_method" value='acvo' {{($item->costing_method == 'acvo' ? 'checked' : '') }}> AVCO </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="costing_method"   value="fifo"  {{($item->costing_method == 'fifo' ? 'checked' : '') }} > FIFO </label>
                            </div>
                          </div>
                          <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" name="costing_method"   value="lifo" {{($item->costing_method == 'lifo' ? 'checked' : '') }}> LIFO </label>
                            </div>
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="batch_wise"   value="1" {{($item->batch_wise == '1' ? 'checked' : '') }}> Batch-Wise Stock </label>
                            </div>
                            
                          
                        </div>
                        <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="business_item"   value="1" {{($item->business_item == '1' ? 'checked' : '') }}> Business Item </label>
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
                        
                        <input type="text" class="form-control "  name="minstock" value="{{$item->minstock}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Reorder Level</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="reorder_level"  value="{{$item->reorder_level}}">
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Max.Stock</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="maximum_stock" value="{{$item->maximum_stock}}" >
                      
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-4">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="automatic_reorder_level"   value="1" {{($item->automatic_reorder_level == '1' ? 'checked' : '') }}> Automatic Reoreder </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Intervals</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="intervals" value="{{$item->intervals}}"  >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Reordering Days</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="reordering_quantity_days" value="{{$item->reordering_quantity_days}}"  >
                      
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
                                <input type="checkbox" class="form-check-input" name="no_days"   value="{{$item->no_days}}" > No.Of Days </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">No.Of Days</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="noofdays" value="{{$item->noofdays}}"  >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Buffer Stock</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="buffer_stock" value="{{$item->buffer_stock}}" >
                      
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
                        
                        <input type="text" class="form-control "  name="purchase_account" value="{{$item->purchase_account}}"  >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Sales A/c</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="sales_account" value="{{$item->sales_account}}"  >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Purchase Return A/C</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="purchasereturn_account" value="{{$item->purchasereturn_account}}" >
                      
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
                        
                        <input type="text" class="form-control "  name="salesreturn_account" value="{{$item->salesreturn_account}}"  >
                      
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