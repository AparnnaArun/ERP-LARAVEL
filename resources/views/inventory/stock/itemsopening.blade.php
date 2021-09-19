
@foreach($items as $item)
<tr>
     <th scope="row"><input type="hidden" class="form-control "  name="itemid[]" value="{{$item->id}}" id="item_id"  placeholder="Current Stock">{{$loop->iteration}}</th>
     <td>
      {{$item->item}}</td>
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  placeholder="Current Stock">{{$item->basic_unit}}</td>
      <td><input type="text" class="form-control   inputpadd"  name="batch[]"  id=""  placeholder="Batch" required="required" value="{{ Carbon\Carbon::today()->format('d-M-Y')}}"></td>
      <td><input type="text" class="form-control auto-calc qnty inputpadd"  name="qnty[]" value="{{$item->opening_qnty}}" id=""  placeholder="Quantity" ></td>
     <td><input type="text" class="form-control auto-calc rate inputpadd"  name="rate[]" value="{{$item->cost}}" id=""  placeholder="Rate" ></td>
 
     <td><input type="text" class="form-control a datepicker inputpadd"  name="expirydate[]" value="" id=""  placeholder="" ></td>
      <td><input type="text" class="form-control  datepicker inputpadd"  name="inwarddate[]" value="" id=""  placeholder="" ><input type="hidden" class="form-control auto-calc amt inputpadd"  name="amount[]" value="{{$item->stock_value}}" id=""  placeholder="Amount" ></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
    @endforeach
    <script type="text/javascript">
      $(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
    first = row.find("td input.rate").val();
    second = row.find("td input.qnty").val();
  row.find(".amt").val((first * second).toFixed(3) );
  

});
      $(".datepicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');

    </script>