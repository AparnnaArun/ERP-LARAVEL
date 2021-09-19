<button type="button" class="btn btn-xs btn-fw feedback"  data-toggle="modal" data-target=".newitemmodal">
<a href="#popup2"> <span class="page-title-icon  text-white mr-2">
                  
                </span>Add Item</a></button>
  <div class="modal fade newitemmodal" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Local Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="forms">
     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>

                   <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Code</label>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="" value="{{$nllslno}}" id="code" readonly>
                        <input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="" value="{{$nlslno}}" id="slno" readonly>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Item Name</label>
                        <input type="text" class="form-control text-uppercase" id="name" placeholder="Item Name"  name="name" >
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Unit</label>
                       <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="unit" id="unit"  >
                        <option value="" hidden >Unit</option>
                       @foreach($units as $unit)
                       <option value="{{  $unit->shortname }}">{{  $unit->shortname }}</option>
                        @endforeach
                      </select>
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="">Description</label>
                        <textarea class="form-control text-uppercase" id="nname" placeholder="description"  name="description" >
                          </textarea>
                        
                      </div>
               
      </div>
      <div class="form-group">
            <div class="col-sm-12">
             <span id="fmssg"></span>
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="fbutton" class="btn btn-primary">Save changes</button>
      </div>
</form>
    </div>
  </div>
</div>
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
$("#fbutton").click(function(){
$("#fbutton").html('Please wait....');
 $("#fbutton").attr("disabled","disabled");
 code=$("#code").val();
 slno=$("#slno").val();
 name=$("#name").val();
 unit=$("#unit").val();
description=$("#description").val();
   //alert(unit);
token=$("#token").val();
 $.ajax({
         type: "GET",
         url: "{{url('addnewitem')}}",
         data: {token:token,slno:slno,description:description,name:name,
                 unit:unit,code:code},
         dataType: "html",  
         success: 
              function(data,status){
               
               $("#fmssg").html(data);
            //alert(data);
                $("#fbutton").html('Submit');
                 $('#forms').each(function() { 
                     this.reset() 
                   });
                $("#fbutton").removeAttr("disabled","disabled");

           }
          });
          $.ajax({
         type: "POST",
         url: "../accload", 
         data: {_token: token,status:status},
         dataType: "html",  
         success: 
              function(result){
                //alert(result);
                $(".itemload").html(result);

              }
          });
    

          });
});
</script>