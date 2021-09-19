<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Invoice #</span>
                        </div>
                       <select class="form-control invoiceno"  name="salesid" >
                        <option value="" hidden>Invoice No</option>
                        @foreach($inv as $iv)

<option value="{{$iv->id}}">{{$iv->invoice_no}}/(@if($iv->invoicefrom=='0') Direct @else DO Invoice @endif )   </option>
                        @endforeach
                        </select>
                         <input type="hidden" class="form-control "  name="cus_accnt"  value="{{$cus->account}}" readonly>
                      </div>
                    </div>
   <script type="text/javascript">
     $(".invoiceno").change(function(){
  token = $("#token").val();
invoiceno = $(".invoiceno").val();
//alert(invoiceno);
$.ajax({
    url:"{{url('getinvdetails')}}",
    method:"POST",
    data:{invoiceno:invoiceno,_token:token},
    success:function(data)
    {
  //alert(data);
  $('.doGrid').html(data);
  }
   });
$.ajax({ 
         type: "POST",
         url: "{{url('getexeinv')}}", 
        data: {invoiceno: invoiceno,_token:token},
         dataType: "html",  
         success: 
             function(data){
               //alert(data);
                $('.exeload').html(data);

              }
          });

  });
   </script>                 