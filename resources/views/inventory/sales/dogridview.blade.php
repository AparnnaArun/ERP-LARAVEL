<tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="item_id[]" value="{{$item->id}}" id="doitemid"  placeholder="Current Stock">{{$rowCount}}</th>
    
        <td><input type="hidden" class="form-control "  name="code[]" value="{{$item->code}}" id=""  placeholder="Current Stock">{{$item->code}}</td>
      <td><input type="hidden" class="form-control "  name="item[]" value="{{$item->item}}" id=""  placeholder="Current Stock">
      {{$item->item}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  placeholder="Current Stock">{{$item->basic_unit}}</td>
      
    <td><input type="hidden" class="form-control auto-calc  inputpadd"  name="location_id[]"  id=""  placeholder="Quantity" required="required" value="{{$stock->location_id}}">{{$stock->locationname}}</td>
      <td><input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$stock->batch}}" id=""  placeholder="Rates" required="required">{{$stock->batch}}</td>
      <td><input type="hidden" class="form-control auto-calc totqnty inputpadd"  name="quantity[]" value="{{$totqnty}}" id=""  placeholder="Discount" >{{$totqnty}}</td>
     <td><input type="hidden" class="form-control auto-calc rate inputpadd"  name="rate[]" value="{{$item->cost}}" id=""  placeholder="Discount" ></td>
   
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
    <script type="text/javascript">
  $(document).ready(function(){
    var sums = 0;
    $("input.totqnty").each(function() {
  sums += +$(this).val();
  //alert(sum);
  });
    $(".gridtotal").val(sums.toFixed(3));
    $(".nettotal").val(sums.toFixed(3));

  });
  // $(document).on('click', '#remove', function(){  
  // row = $(this).closest("tr");
  //  row.remove();
  //  ntotals = $(".gridtotal").val();
  //  item_id = row.find("th input.doitemid").val();
  //  tabamount = row.find("td input.totqnty").val();
  //  alert(item_id);
  // $(".gridtotal").val((ntotals - tabamount).toFixed(3));

  //  });


</script>