@foreach($piv as $item)
<tr>
      <th scope="row"><input type="hidden" class="form-control "  name="id1[]" value="{{$item->id}}"  ><input type="hidden" class="form-control "  name="main[]" value="{{$item->piid}}"  >
        <input type="hidden" class="form-control "  name="loc[]" value="{{$mpi->locations}}"  >{{$loop->iteration}}</th>
      <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->item_code}}"  >
        {{$item->item_code}}</td>
      <td><input type="hidden" class="form-control"  name="item_id[]" value="{{$item->item_id}}" id="item_id"  >
      	<input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}" id=""  >{{$item->item_name}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}"  >{{$item->unit}}</td>
      <td><input type="hidden" class="form-control"  name="batch[]" value="{{$item->batch}}"  >{{$item->batch}}</td>
      <td><input type="hidden" class="form-control"  name="piqnty[]" value="{{$item->quantity}}"  >
        <input type="hidden" class="form-control"  name="rtnqnty[]" value="{{$item->rtnqnty}}"  >
        <input type="hidden" class="form-control auto-calc bqnty"  name="" value="{{$item->balqnty}}"  >{{$item->balqnty}}</td>
      <td><input type="text" class="form-control auto-calc qnty inputpadd"  name="quantity[]" value="" id="qnty"  placeholder="Quantity" required="required">
        <div class="alertdiv" style="display: none;color:red;">Qnty should be less than Invoice Qnty</div>
      </td>
      
       <td><input type="hidden" class="form-control auto-calc rate inputpadd"  name="rate[]" value="{{$item->rate}}" id="rate"  placeholder="Rate" required="required" >{{$item->rate}}</td>
        <td><input type="text" class="form-control auto-calc amount inputpadd"  name="total[]" value="{{$item->total}}" id="amount"  placeholder="Amount" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>
    @endforeach
      <script type="text/javascript">
  $(document).on("keyup change paste", ".auto-calc", function() {
  row = $(this).closest("tr");
    first = parseFloat(row.find("td input.qnty").val());
    second = parseFloat(row.find("td input.rate").val());
    third = parseFloat(row.find("td input.bqnty").val());
    if(third < first){

  row.find($(".alertdiv")).show();
   $(".savebtn").attr("disabled", true);

    }else{
   row.find($(".alertdiv")).hide(); 
    $(".savebtn").attr("disabled", false); 
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
      var total =parseFloat($(".tamount").val());
   var disc = parseFloat($(".disctotal").val());
   var erate =parseFloat( $(".erate").val());

   var nettotals = ((total)-(disc));
 
   var afrrate = erate*nettotals;
   //alert(nettotals);
    $(".nettotal").val(nettotals.toFixed(3));
 $(".gridtotal").val(afrrate.toFixed(3));
    }
});

</script>