
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Sales Order</span>
                        </div>
                         <select class="form-control sono" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="so_no" id="" >
                          <option value="" hidden>SO</option>
                          @foreach($sos as $so)
                        <option value="{{$so->id}}" >{{$so->order_no}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>


     <script type="text/javascript">
     	  $(".sono").change(function(){
               sono = $(this).val();
               token = $("#token").val();
               //alert(token);
              $.ajax({
         type: "POST",
         url: "{{url('getsodet')}}", 
         data: {_token: token,sono:sono},
         dataType: "html",  
         success: 
              function(data){
             //alert(data);
                $('.soodiv').html(data);
               //$('.currenytstock').modal('show')
              }
          });

                })
     </script>               
            