<tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="item_id[]" value="{{$item->id}}" id="doitemid"  >{{$rowCount}}</th>
    
        <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id=""  >{{$item->code}}</td>
      <td><input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id=""  >
      {{$item->item}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  >{{$item->basic_unit}}</td>
      
      <td>
        <input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$stock->batch}}" id=""  placeholder="Rates" required="required">{{$stock->batch}}</td>
        
      <td>
        <input type="hidden" class="form-control auto-calc totqnty inputpadd"  name="issue_qnty[]" value="{{$totqnty}}" id=""   >
        <input type="hidden" class="form-control auto-calc totqnty inputpadd"  name="rate[]" value="{{$item->cost}}" id=""   >
      <input type="hidden" class="form-control auto-calc ammt inputpadd"  name="stockissue_value[]" value="{{$amt}}" id=""   >{{$totqnty}}</td>
     <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
      <script type="text/javascript">
  $(document).ready(function(){
 
    var sums1 = 0;
   
     $("input.ammt").each(function() {
  sums1 += +$(this).val();
  
  });
   
   $(".totalcost").val(sums1.toFixed(3));

  });
</script>
    