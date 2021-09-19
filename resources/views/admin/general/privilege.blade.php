@extends('admin/layout')
@section ('content')
<style type="text/css">
  .form-check .form-check-label input{
    opacity: 1;
    z-index: 0;
  }
</style>
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span> Privilege
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
                     <form class="forms-sample" action ="{{('/createprivilege')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">User</span>
                        </div>
                        <select  class="form-control ssslect"  name="" id="user" required="required" >
                          <option value="" hidden>User</option>
                          @foreach($users as $user)
                           <option value="{{$user->id}}" >{{$user->login_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Module</span>
                        </div>
                        <select  class="form-control"  name="" id="module" required="required" >
                          <option value="" hidden>Module</option>
                          @foreach($mods as $mod)
                           <option value="{{$mod->module}}" >{{$mod->module}}</option>
                          @endforeach
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Page</span>
                        </div>
                        <select  class="form-control result"  name="" id="pageid" required="required" >

                        </select>
                      </div>
                    </div>
                </div>
              </div>
           <div class="row">
            <div class="col-lg-10 grid-margin stretch-card">
             
              <table class="table table-striped results ">
                     
                      <tbody>
                        <tr>
                         <td>
                          <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>Page</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>Read</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>Write</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>Modify</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>Delete</label>
                            </div>
                          </td>
                       
                        </tr>
                        
                      </tbody>
                    </table>
                  
              </div>
              
<div class="col-lg-1 ">
  <h4 class="card-title"></h4>
  <br/><br/>
               <button type="button" class="btn btn-gradient-info btn-sm" id="add_to_cart">Go</button>
              </div>

          </div>
          <div class="row">
          <div class="col-lg-10 grid-margin stretch-card">
             
              <table class="table table-striped" id="Privilege">
                     <thead>
                       <tr>
                        <th>priv</th>
                        <th>Module</th>
                        <th>Page</th>
                        <th>Privilege</th>
                       </tr>
                     </thead>
                      <tbody>
                     
                         
                        
                      </tbody>
                    </table>
                  
              </div>
            </div>
                         
                           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg">Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
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
        <h5 class="modal-title" id="companyModalLabel">Privilege Details</h5>
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
      <th scope="col">User</th>
      <th scope="col">Module</th>
     <th scope="col">Page</th>
      <th scope="col">Privilege</th>
    </tr>
  </thead>
  <tbody>
     @foreach($privs as $priv)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/privilege-edit/{{$priv->id}}">{{$priv->login_name}}</a></td>
      <td><a href="/admin/privilege-edit/{{$priv->id}}">{{$priv->module}}</a></td>
      <td><a href="/admin/privilege-edit/{{$priv->id}}">{{$priv->heading}}</a></td>
      <td><a href="/admin/privilege-edit/{{$priv->id}}">{{$priv->privilege}}</a></td>
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
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">
$("#module").change(function(){
  vid=$(this).val();
  csrf = $('#token').val();
$.ajax({
         type: "POST",
         url: "/admin/privilege",
         data: {vid: vid,_token:csrf},
         dataType: "html",  
         success: 
              function(result){
              $(".result").html(result);
               }
          });
})
$("#pageid").change(function(){
   vid=$(this).val();
  priv =$("#priv").val();
  if(priv!=""){
     $.ajax({
         type: "POST",
         url: "/admin/privileges",
         data: {vid: vid,_token:csrf},
         dataType: "html",  
         success: 
              function(result){
                //alert(result);
              $(".results").html(result);
               }
          });
}else{
alert("All fileds are required");

}

})
$("#add_to_cart").click(function(){
var priv = $("#priv").val();
var modules = $("#module").val();
var pageget = $("#pageid").val();
var page = $(".page").val();
var pagesid=$(".pagesid").val();
//alert(pagesid);

if($(".read").prop('checked')){
var read =$(".read").val();
}
else{
 var read =""; 
}
//alert(read);
if($(".write").prop('checked')){
var write =$(".write").val();
}
else{
 var write =""; 
}

if($(".delete").prop('checked')){
var deletes =$(".delete").val();
}
else{
 var deletes =""; 
}
if($(".modify").prop('checked')){
var modify =$(".modify").val();
}
else{
 var modify =""; 
}
var priv = read+ write + modify + deletes
if(pagesid!=pageget || pagesid===""){
 $.ajax({
         type: "POST",
          url: "/admin/combined-privilege",
         data: {priv: priv, pageget: pageget,page:page,modules: modules,priv: priv,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data); 
                $('#Privilege tbody').append(data);
               
              }
          });
}
else{
  alert('This page name is taken');
}
});
 </script>             
@stop