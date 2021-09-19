@extends('accounts/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Account Details
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
                    <form class="forms-sample" action ="{{('/editsaccountss')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="id" value="{{$acc->id}}" />
                        <div class="row">
                         <div class="col-md-9"> 
                        <div class="row">
                
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input sched" name="accounttype"   value="s1" {{($acc->accounttype == 's1'? ' checked' : 'disabled') }}> Schedule </label>
                            </div>
                          </div>
                          <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input acco" name="accounttype"   value="a1" {{($acc->accounttype == 'a1'? ' checked' : 'disabled') }}> Account </label>
                            </div>
                          </div>
                          <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="active"   value="1" {{($acc->active == '1'? ' checked' : '') }}> Active </label>
                            </div>
                          </div>
              </div>
                   <div class="row mt-3">
                   	<div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          @if($acc->accounttype =='a1')
                          <span class="input-group-text bg-gradient-info text-white required anum" >A/C#</span>
                          @else
                          <span class="input-group-text bg-gradient-info text-white required snum">Schedule#</span>
                          @endif
                        </div>
                        <input type="hidden" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="idd" name="idd" value="{{($accid->id) +1 }}"  >
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="seqnumber" name="seqnumber" value="{{$acc->seqnumber }}" readonly="" >
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          @if($acc->accounttype =='a1')
                          <span class="input-group-text bg-gradient-info text-white required anum" >A/C Name</span>
                          @else
                          <span class="input-group-text bg-gradient-info text-white required snum">Sched Name</span>
                          @endif
                        </div>
                        <input type="text" class="form-control text-uppercase" aria-label="Amount (to the nearest dollar)" name="name" id="nname" value="{{$acc->name }}" >
                        
                      </div>
                    </div>
                </div>
              </div>
               <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Print Name</span>
                        </div>
                        
                        <input type="text" class="form-control text-uppercase" aria-label="Amount (to the nearest dollar)" name="printname" id="pname" value="{{$acc->printname }}" >
                      
                      </div>
                    </div>
                </div>
           
           
              <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Under</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="parentid" id="under" readonly value="{{$pname->printname }}">
                       
                      
                      </div>
                    </div>
                </div>
              </div>
               <div class="row">
                   	<div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Description</span>
                        </div>
                        
                        <textarea type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="description" >{{ $acc->description }}</textarea>
                      </div>
                    </div>
                </div>
                
              <!--  -->
               <div class="col-md-3">
                <label class="form-check-label">Category</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="category" value='others' {{($acc->category == 'others'? ' checked' : 'disabled') }}> Others </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category"  
                                 value="bank" {{($acc->category == 'bank'? ' checked' : 'disabled') }} > Bank </label>
                            </div>
           
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category" value="debtor" {{($acc->category == 'debtor'? ' checked' : 'disabled') }} > Debtor </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category" value="creditor"  {{($acc->category == 'creditor'? ' checked' : 'disabled') }}> Creditor </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category" value="staff" {{($acc->category == 'staff'? ' checked' : 'disabled') }}> Staff </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category" value="cash" {{($acc->category == 'cash'? ' checked' : 'disabled') }}> Cash </label>
                            </div>
                             </div>
           </div>
              <div class="row mt-1">
               <div class="col-md-10 col-md-offset-0 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
          </div>
        </div>
            </div>
          
             
          <div class="col-md-3">
           <h4>Account List</h4>
                            <ul id="tree1">
                                @foreach($categories as $category)
                                    <li >
                                        <span class="text-uppercase" style="color:red;font-weight: 50;"><span class="glyphicon glyphicon-plus"></span>{{ $category->name }}</span>
                                        @if(count($category->childs))
                                            @include('manageChild',['childs' => $category->childs])
                                        @endif
                                    </li>
                                @endforeach
                            </ul>


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
        <h5 class="modal-title" id="companyModalLabel">Account Details</h5>
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
      <th scope="col">A/C Type</th>
      <th scope="col">Chart Of A/C</th>
      <th scope="col">Status</th>
     
    </tr>
  </thead>
  <tbody>
     @foreach($allCategories as $all)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/account-edit/{{$all->id}}">@if($all->accounttype == 'a1')<span style="color:green;">Account</span> @else Schedule @endif</a></td>
      <td><a href="/accounts/account-edit/{{$all->id}}">{{$all->name}}</a></td>
      <td><a href="/accounts/account-edit/{{$all->id}}">@if($all->active==1) Active @else Inactive @endif</a></td>
     
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
<script src="../../assets/js/treeview.js"></script>
<script type="text/javascript">

 $(function () {
    var $src = $('#nname'),
        $dst = $('#pname');
    $src.on('input', function () {
        $dst.val($src.val());
    });
});
  
</script>
@stop