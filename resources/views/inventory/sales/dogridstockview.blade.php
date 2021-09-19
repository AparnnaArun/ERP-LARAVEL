
<tr >
    <td ><input type="text" class="form-control idid " aria-label="Amount (to the nearest dollar)" name="itemid[]" value="{{$itemid}}" id=""  placeholder="Current Stock"></td>
      <td><input type="text" class="form-control gloc" aria-label="Amount (to the nearest dollar)" name="locid[]" value="{{$locid}}" id=""  placeholder="Current Stock">
      </td>
      <td><input type="text" class="form-control gbatch" aria-label="Amount (to the nearest dollar)" name="batches[]" value="{{$batch}}" id="batch"  placeholder="Current Stock"></td>
      <td><input type="text" class="form-control auto-calc  inputpadd" aria-label="Amount (to the nearest dollar)" name="reqqnty[]"  id=""  placeholder="Quantity" required="required" value="{{$reqqnty}}"></td>
       <td><input type="text" class="form-control auto-calc  inputpadd" aria-label="Amount (to the nearest dollar)" name="balqnty[]"  id=""  placeholder="Quantity" required="required" value="{{$bal}}"></td>
      <td><input type="text" class="form-control auto-calc cost inputpadd" aria-label="Amount (to the nearest dollar)" name="cost[]"  id=""  placeholder="Quantity" required="required" value="{{$itemmcost}}"></td>
      <td><input type="text" class="form-control auto-calc amoo inputpadd" aria-label="Amount (to the nearest dollar)" name="amt[]"  id=""  placeholder="Quantity" required="required" value="{{$amo}}"></td>
     
     <td ><button id="" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>