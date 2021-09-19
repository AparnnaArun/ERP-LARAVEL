       
    <tr>
      <th scope="row">{{$rowCount}}</th>
      <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id="code" >

        {{$item->code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->id}}" id="item_id" >
      	<input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id="" >{{$item->item}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]" >{{$item->basic_unit}}</td>
      <td><input type="text" class="form-control auto-calc batch inputpadd"  name="batch[]"   placeholder="Batch" value="{{ \Carbon\Carbon::parse(now())->format('j -F- Y')  }}"  required ></td>
      <td><input type="text" class="form-control auto-calc qnty"  name="quantity[]" value="" id="qnty"  placeholder="Quantity" required="required"></td>
      <td><input type="text" class="form-control auto-calc freeqnty"  name="freeqnty[]" value="0"   placeholder="Free Qnty" ></td>
       <td><input type="text" class="form-control auto-calc rate"  name="rate[]" value="" id="rate"  placeholder="Rate" required="required"></td>
        <td><input type="text" class="form-control auto-calc amount"  name="total[]" value="" id="amount"  placeholder="Amount" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>
<script type="text/javascript">
	$(document).on("keyup change paste", ".auto-calc", function() {
	row = $(this).closest("tr");
    first = parseFloat(row.find("td input.qnty").val());
    second = parseFloat(row.find("td input.rate").val());
   row.find("td input.amount").val((first*second).toFixed(3));
 var sums = 0;
  var sums1 = 0;
    $("input.qnty").each(function() {
  sums += +$(this).val();
  
  });
      $("input.amount").each(function() {
  sums1 += +$(this).val();
  
  });
      $(".tqnty").val(sums.toFixed(3));
      $(".tamount,.gridtotal,.nettotal").val(sums1.toFixed(3));
});

</script>