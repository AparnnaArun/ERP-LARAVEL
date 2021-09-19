<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Note No</span>
                        </div>
                       <select class="form-control " placeholder=""  name="deli_note_number" required="" id="dono">
                          <option value="" hidden>Delivery Note</option>
                    @foreach($do as $ddo)
                        <option value="{{$ddo->id}}" >{{$ddo->deli_note_no}}</option>
                        @endforeach
                        </select>
                        
                      </div>
                    </div>
                     <script type="text/javascript">

$(document).ready(function () {

$("#dono").change(function(){

  dono =$("#dono").val();
  token = $("#token").val();
  //alert(token);
  $.ajax({ 
         type: "POST",
         url: "{{url('alldodetails')}}", 
        data: {dono: dono,_token:token},
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