<button type="button" class="btn btn-xs btn-fw feedback"  data-toggle="modal" data-target=".newaccountmodal">
<a href="#popup1"> <span class="page-title-icon  text-white mr-2">
                  
                </span>Open Account</a></button>
  <div class="modal fade newaccountmodal" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>

      <div class="modal-body">
      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Schedule</label>
                        
                         <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="parentid" id="under" >
                       <option value="" hidden>Schedule</option>
                        @foreach($accounts as $account)
                        <option value="{{$account->id}}" >{{$account->printname}}</option>
                        @endforeach
                      </select>
                       <div class="getfull">
                      <input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="fullcode" value="" id="fullcode" >
                    </div>
                       
                      <input type="hidden" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="idd" name="idd" value="{{($accid->id) +1 }}"  >
                     </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Account No</label>
                        <input type="text" class="form-control" id="seqnumber" placeholder="" value="ACH{{($accid->id) +1 }}"  name="seqnumber" readonly="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Account Name</label>
                        <input type="text" class="form-control text-uppercase" id="nname" placeholder="Account Name"  name="name" >
                        <input type="hidden" class="form-control " id="acccat" placeholder="Account Name"  name="acccat" value="{{$acccat}}" >
                        <input type="hidden" class="form-control " id="status" placeholder="Account Name"  name="status" value="{{$status}}" >
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
  $("#under").change(function(){
  und = $(this).val();
  token=$("#token").val();
  $.ajax({
         type: "POST",
         url: "{{url('getfullcode')}}", 
         data: {_token: token,und:und},
         dataType: "html",  
         success: 
              function(data){
               //alert(data);
                $(".getfull").html(data);

              }
          });

})
  $(function () {
    var $src = $('#nname'),
        $dst = $('#pname');
    $src.on('input', function () {
        $dst.val($src.val());
    });
});
  $(document).ready(function(){
$("#f_button").click(function(){
$("#f_button").html('Please wait....');
 $("#f_button").attr("disabled","disabled");
 name=$("#nname").val();
 under=$("#under").val();
 seqnumber=$("#seqnumber").val();
 idd=$("#idd").val();
fullcode=$("#fullcode").val();
acccat=$("#acccat").val();
status =$("#status").val();
token=$("#token").val();
 $.ajax({
         type: "GET",
         url: "{{url('ajax-newacc')}}",
         data: {name:name,token:token,under:under,fullcode:fullcode,seqnumber:seqnumber,idd:idd,acccat:acccat},
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
      

         $.ajax({
         type: "POST",
         url: "{{url('accload')}}", 
         data: {_token: token,status:status},
         dataType: "html",  
         success: 
              function(result){
                //alert(result);
                $(".accname").html(result);

              }
          });
    

          });
});
</script>