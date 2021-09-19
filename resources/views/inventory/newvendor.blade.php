<button type="button" class="btn btn-xs btn-fw feedbackcustomer"  data-toggle="modal" data-target=".newvendormodal">
<a href="#popup1"> <span class="page-title-icon  text-white mr-2">
                  
                </span>Add A Vendor</a></button>
  <div class="modal fade newvendormodal" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Vendor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token11"/>

      <div class="modal-body">
      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Name</label>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="name" value="" id="name"  placeholder="Vendor Name">
                        
                       
                       
                    
                     </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Short Name</label>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="shortname" value="" id="shortname"  placeholder="Short Name">
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Business Type</label>
                         <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="bustype" id="bustype" >
                          <option value="" hidden >Business Type</option>
                        @foreach($btypes as $btype)
                       <option value="{{  $btype->btype }}">{{  $btype->btype }}</option>
                        @endforeach
                      </select>
                        
                      </div>
                      
               
      </div>
      <div class="form-group">
            <div class="col-sm-12">
             <span id="f_mssg"></span>
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="f_button" class="btn btn-primary">Save changes</button>
      </div>
</form>
    </div>
  </div>
</div>
<script src="../../assets/js/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
$("#f_button").click(function(){
$("#f_button").html('Please wait....');
 $("#f_button").attr("disabled","disabled");
 name=$("#name").val();
 shortname=$("#shortname").val();
 bustype=$("#bustype").val();
 

token=$("#token11").val();
 $.ajax({
         type: "POST",
         url: "{{url('addnewvendor')}}",
         data: {name:name,_token:token,shortname:shortname,bustype:bustype},
         dataType: "html",  
         success: 
              function(data,status){
               
               $("#f_mssg").html(data);
            //alert(data);
                $("#f_button").html('Submit');
                 $('#form').each(function() { 
                     this.reset() 
                   });
                $("#f_button").removeAttr("disabled","disabled");

           }
          });
      
});
});
</script>