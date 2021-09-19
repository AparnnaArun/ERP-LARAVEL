<div class="form-group">

                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">PO #</span>
                        </div>
                        <select class="form-control "  name="po_no" required=""  id="ponumber">
                          <option value="" hidden>Approved PO No</option>
                
           @foreach($pos as $po)
       <option value="{{$po->id}}">{{$po->po_no}}</option>
       
           @endforeach
                        </select>
                      </div>
                    </div>
                    <script type="text/javascript">
                      // //////////ADD TO GRID SECTION ///////////////////////
$("#ponumber,.loc").change(function(){
               po = $("#ponumber").val();
               token = $("#token").val();
                locs = $(".loc").val();
               // alert(locs);
              $.ajax({
         type: "POST",
         url: "{{url('gridforgrn')}}", 
         data: {_token: token,po:po,locs:locs},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
               $('.ItemGrid tbody').html(data);


              }
          });

                })
                    </script>