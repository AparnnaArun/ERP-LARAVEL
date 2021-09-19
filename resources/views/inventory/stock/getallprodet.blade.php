<div class="row ">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <input type="text" class="form-control"  name="customer" required="" value="{{$pro->name}}" readonly>
                        <input type="hidden" class="form-control"  name="customer_id" required="" value="{{$pro->customer_id}}" readonly>
                        <input type="hidden" class="form-control"  name="project_code" required="" value="{{$pro->project_code}}" readonly>
                        <input type="hidden" class="form-control"  name="project_name" required="" value="{{$pro->project_name}}" readonly>
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer PO</span>
                        </div>
                        <input type="text" class="form-control"  name="customerpo" required="" value="{{$pro->customer_po}}" readonly>
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control"  name="executive" value="{{$pro->executive}}" readonly>
                        <input type="hidden" class="form-control"  name="commission_percentage" value="{{$exe->commission_percentage}}" readonly>
                        <input type="hidden" class="form-control"  name="comm_pay_account" value="{{$exe->comm_pay_account}}" readonly>
                        <input type="hidden" class="form-control"  name="exe_com_exp_ac" value="{{$exe->exe_com_exp_ac}}" readonly>
                          
                      </div>
                    </div>
                </div>
            </div>
            @if($action=='Issue')
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Req.No</span>
                        </div>
                        <select class="form-control reqno"  name="requisitionid" required="" >
                          <option value="" hidden>Req No</option>
                          @foreach($matreq as $mat)
                          <option value="{{$mat->id }}" >{{$mat->matreq_no }}</option>
                          @endforeach
                        </select>

                          
                      </div>
                        <div class="reqdiv" style="color:red;display:none">Req No please</div>
                    </div>
                </div>
                  <div class="col-md-4">
                   
                <label class="form-check-label">Issue From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="issue_from" value='0' style="opacity: 1;"> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="issue_from"   value="1" checked style="opacity: 1;"> Request </label>
                            </div>
           
           
                             
                </div>
                
              
          </div>
          @endif

          <script type="text/javascript">
  $(document).ready(function () {

  $(".reqno").change(function(){
   $(".reqdiv").hide();
  reqno =$(".reqno").val();
  token = $("#token").val();

$.ajax({ 
         type: "POST",
         url: "{{url('getmatreqdetails')}}", 
        data: {reqno: reqno,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.ItemGrid tbody').html(data);
              
                           }
          });


    });
});
          </script>