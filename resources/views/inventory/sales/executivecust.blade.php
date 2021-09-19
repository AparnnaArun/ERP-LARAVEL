 <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="tokens"/>
<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                         <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" id="exex" required >
                          <option value="" hidden>Executive</option>
                          @foreach($cust as $cus)
                        <option value="{{$cus->executive}}" >{{$cus->executive}}</option>

                          @endforeach
                    
                        </select>
                        <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="cus_accnt"  value="{{$acc->account}}">
                          <div id="excecee">
                          </div> 
                        
                      </div>
                    </div>
                   
  <script type="text/javascript">
  $("#exex").change(function(){
               exec = $(this).val();
               token = $("#tokens").val();
               //alert(exec);
              $.ajax({
         type: "POST",
         url: "{{url('getexecomm')}}", 
         data: {_token: token,exec:exec},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".excecee").html(result);
               

              }
          });

                })
                    </script>