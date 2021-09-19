<div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped SoGrid" id="SoGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                           <th>Location</th>
                            <th>Batch</th>
                            <th>SO Qnty</th>
                            <th>Deliv. Qnty</th>
                            <th>Req Qnty</th>
                             <th></th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>


@foreach($sod as $row)
<tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid tooid"  name="item_id[]" value="{{$row->item_id}}" id="doitemid"  placeholder="Current Stock">
      <input type="hidden" class="form-control auto-calc "  name="soid[]" value="{{$row->id}}" id=""  placeholder="Current Stock">
      <input type="hidden" class="form-control auto-calc "  name="main[]" value="{{$row->order_id}}" id=""  placeholder="Current Stock">{{$loop->iteration}}</th>
    
        <td><input type="hidden" class="form-control "  name="code[]" value="{{$row->code}}" id=""  placeholder="Current Stock">{{$row->code}}</td>
      <td><input type="hidden" class="form-control "  name="item[]" value="{{$row->item}}" id=""  placeholder="Current Stock">
      {{$row->item}}</td>
      
      <td>
        <input type="hidden" class="form-control"  name="unit[]" value="{{$row->unit}}" id="unit[]"  placeholder="Current Stock">{{$row->unit}}
      </td>
      <td >
        <input type="hidden" class="form-control auto-calc  loccid inputpadd"  name="location_id[]"  id=""  placeholder="Quantity" required="required" value="" data-id="{{$row->item_id}}" readonly="">
        <input type="text" class="form-control auto-calc  loccname inputpadd"  name=""  id=""  placeholder="Location" required="required" value="" data-id="{{$row->item_id}}" readonly="">
      </td>
      <td >
        <input type="text" class="form-control auto-calc  batchsss inputpadd"  name="batch[]" value="" id=""  placeholder="Batch" required="required" data-id="{{$row->item_id}}" readonly="">
      </td>
      <td><input type="hidden" class="form-control auto-calc soqnty inputpadd"  name="soqnty[]" value="{{$row->bal_qnty}}" id=""   data-id="{{$row->item_id}}">
        {{$row->quantity}}</td>
        <td>
        {{$row->issdn_qnty}}</td>
      <td><input type="text" class="form-control auto-calc totqnty tooqnty inputpadd"  name="quantity[]" value="" id=""  placeholder="Click Here" data-id="{{$row->item_id}}" readonly=""></td>

     <td><input type="hidden" class="form-control auto-calc rate inputpadd"  name="rate[]" value="{{$row->rate}}" id=""   ></td>
   <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
    <script type="text/javascript">
 
  $(".tooqnty").click(function(){
    row11 = $(this).closest("tr");
soqty = row11.find("td input.soqnty").val();
  itemid = $(this).data('id');
  token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getcurrentstockso')}}", 
         data: {_token: token,itemid:itemid,soqty:soqty},
         dataType: "html",  
         success: 
              function(result){
             
                $(".poppup").html(result);
               $('.currenytstock').modal('show')
              }
          });

                })

</script>