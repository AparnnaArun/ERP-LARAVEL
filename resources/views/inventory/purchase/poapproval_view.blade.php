                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Purchase Order</center></h2>
      <table style="border-collapse: collapse;border-color: wheat;width:100%">
        <tr><td>To,</td></tr>
        <tr><td colspan="3">{{$data ->vendor}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data ->po_no}}</td></tr>
        <tr><td colspan="3">{{$data ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{ \Carbon\Carbon::parse($data->order_date)->format('j -F- Y')  }}</td></tr>
        <tr><td colspan="3">Kind Attn:{{$data ->contact_person}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Reference</td>
          <td>: {{$data ->reference}}</td></tr>
          <!-- <tr><td colspan="3"></td>
          <td>Qtn Ref</td>
          <td>: {{$data ->qtn_ref}}</td>
          <td></td>
          <td>Enq Ref</td>
          <td>: {{$data ->currency}}</td></tr> -->
          <tr><td colspan="13"><p align="left" ><b>Dear Sir,<br/></b>
         As per your quotation,Please supply the following items at the earliest.</p><br/></td></tr>
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Part No</th>
            <th>Unit</th>
            <th>Qnty</th>
            <th>Unit Price<br>in KWD</th>
          
            <th>Tot.Price<br>in KWD</th>

          </tr>
        </thead>
        <tbody>
          @foreach($data->purchaseorderdetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->apprqnty}}</td>
            <td style="text-align: center;">{{$sqoute->rate}}</td>
           
            <td style="text-align: center;">{{$sqoute->total}}</td>
          </tr>
          @endforeach
          <tr>
            <th colspan="13">Total Value</th>
            <th>{{$data ->tamount}}</th>
           
          </tr>
          <tr>
            <th colspan="13">Discount</th>
            <th>{{$data ->discount_total}}</th>
           
          </tr>
          <tr>
            <th colspan="13">Net Value</th>
            <th>{{$data ->net_total}}</th>
           
          </tr>
        </tbody>

      </table>
      <br/>
      <table>
        
        
          <tr><td colspan="2"><b>Payment Info<b/></td>
          <td colspan="11">: {{$data ->paymentterms}}</td>
          </tr>
        <tr><td colspan="2"><b>Delivery Info</b></td>
          <td colspan="11">: {{$data ->deliveryinfo}}</td>
          </tr>
          <tr><td colspan="2"><b>Notes</b></td>
          <td colspan="11">: {{$data ->remarks}}</td>
          </tr>
          
      </table>
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>