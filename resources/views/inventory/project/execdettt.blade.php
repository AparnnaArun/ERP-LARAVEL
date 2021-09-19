 <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Code</span>
                        </div>
                        <select class="form-control projectid"  name="projectids" required="" >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                     <option value="{{$pro->id}}" >{{$pro->project_code}}</option>
                     @endforeach
                        </select>
                        <input type="hidden" class="form-control  "  name="comm_pay_account"  value="{{$exx->comm_pay_account}}" readonly>
                        <input type="hidden" class="form-control  "  name="exe_com_exp_ac"  value="{{$exx->exe_com_exp_ac}}" readonly>
                        <input type="hidden" class="form-control  "  name="commission_percentage"  value="{{$exx->commission_percentage}}" readonly>
                      </div>
                    </div>
                    <script type="text/javascript">
                      $(".projectid").change(function(){
               pid = $(this).val();
               token = $("#token").val();
               rowCount = $('.ItemGrid tr').length; 
               texce =$(".inpexce").val();
              $.ajax({
         type: "POST",
         url: "{{url('getprodetails')}}", 
         data: {_token: token,pid:pid,rowCount:rowCount,texce:texce},
         dataType: "html",  
         success: 
              function(result){
             var isExists=false;
        $(".ItemGrid td .doproid").each(function(){
              var val=$(this).val();
              if(val==pid)
                isExists=true;

            });
            if (isExists) {
             alert("Project code is taken");
          
            } else {
                $(".ItemGrid tbody").append(result);
              }

              }
          });

                })
                    </script>