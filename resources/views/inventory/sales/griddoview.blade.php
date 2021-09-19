@foreach($do as $row)

<tr>
    <td><input type="hidden" class="form-control  "  name="doid[]" value="{{$row->id}}"  >
      <input type="hidden" class="form-control  "  name="so_id[]" value="{{$row->so_id}}"  >
      <input type="hidden" class="form-control  "  name="dln_id[]" value="{{$row->dln_id}}"  >{{$loop->iteration}}</td>
      <td><input type="hidden" class="form-control doitemid"  name="item_id[]" value="{{$row->item_id}}"  >
        <input type="hidden" class="form-control "  name="item_code[]" value="{{$row->code}}"  >{{$row->code}}
      </td>
      <td><input type="hidden" class="form-control"  name="item_name[]" value="{{$row->item}}" id="batch"  >{{$row->item}}</td>
      <td><input type="hidden" class="form-control   inputpadd"  name="unit[]"   placeholder="Quantity" required="required" value="{{$row->unit}}">{{$row->unit}}</td>
       <td><input type="hidden" class="form-control   inputpadd"  name="location_id[]"   placeholder="Quantity" required="required" value="{{$row->location_id}}">{{$row->locationname}}</td>
      <td><input type="hidden" class="form-control   inputpadd"  name="batch[]"   placeholder="Quantity" required="required" value="{{$row->batch}}">{{$row->batch}}</td>
      <td><input type="hidden" class="form-control calculate doqnty  inputpadd"  name="dnqnty[]"   placeholder="Quantity" required="required" value="{{$row->bal_qnty}}">
      <input type="hidden" class="form-control  calculate cost inputpadd"  name="rate[]"   placeholder="Quantity" required="required" value="{{$row->rate}}">{{$row->bal_qnty}}</td>
      <td><input type="text" class="form-control calculate qnty inputpadd"  name="rtnqnty[]"   placeholder="Click Here" readonly="" value="" data-id="{{$row->item_id}}">
        <div class="alertsss" style="color:red;display: none;">Qnty is limited in DO Qnty</div>
      <input type="hidden" class="form-control calculate amoo inputpadd"  name="amount[]"   placeholder="Quantity" required="required" value=""></td>
     
     <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
@endforeach
<script type="text/javascript">
  $(document).on("keyup change paste", ".calculate", function() {
    row = $(this).closest("tr");
    first = parseFloat(row.find("td input.cost").val());
    second = parseFloat(row.find("td input.qnty").val());
    third = parseFloat(row.find("td input.doqnty").val());
    //alert(third);
    if( second <= third ){
      row.find($(".alertsss")).hide();
    row.find("td input.amoo").val((first * second).toFixed(3));
  }
  else{
row.find($(".alertsss")).show();
row.find("td input.qnty").val("");
  }
  });
  $(document).on('click', '#remove', function(){  
  rowss = $(this).closest("tr");
   rowss.remove();
   item_id = rowss.find("td input.doitemid").val();
   //alert(item_id);
   $(".stocktable tr").each(function(){
       $(this).find('td input.idid').each(function(){
          var currentText = $(this).val();
 if(currentText == item_id){
              $(this).parents('tr').remove();
          }
      });
   });
   });
  
    $(".qnty").click(function(){
               itemid = $(this).data('id');
               token = $("#token").val();
               rows = $(this).closest("tr");
               doqnty = parseFloat(rows.find("td input.doqnty").val());
               //alert(itemid);
             
              $.ajax({
         type: "POST",
         url: "{{url('dortnstock')}}", 
         data: {_token: token,itemid:itemid,doqnty:doqnty},
         dataType: "html",  
         success: 
              function(data){
             //alert(data);
                $(".poppup").html(data);
               $('.currenytstock').modal('show')
              }
          });

                });
          
</script>