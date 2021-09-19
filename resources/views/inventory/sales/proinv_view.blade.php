                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Proforma Invoice</center></h2>
      <table style="width:100%;">
        <tr><td>To,</td></tr>
        <tr><td colspan="4">{{$data ->name}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data ->pro_no}}</td></tr>
        <tr><td colspan="4">{{$data ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{$data ->dates}}</td></tr>
        <tr><td colspan="4">Your RefNo : {{$data ->customer_ref}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Currency</td>
          <td>: {{$data ->currency}}</td></tr>
          
          
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>Qnty</th>
            <th>Unit Price<br>in KWD</th>
            <th>Disc</th>
            <th>Tot.Price<br>in KWD</th>

          </tr>
        </thead>
        <tbody>
          @foreach($data->proformainvoicedetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->quantity}}</td>
            <td style="text-align: center;">{{$sqoute->rate}}</td>
            <td style="text-align: center;">{{$sqoute->disccount}}</td>
            <td style="text-align: center;">{{$sqoute->amount}}</td>
          </tr>
          @endforeach
          <tr>
            <th colspan="13">Total Value</th>
            <th>{{$data ->total}}</th>
           
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
        <tr><td colspan="13"><b>Terms & Conditions</b><hr></td>
          
          </tr>
        <tr><td colspan="2">Warranty</td>
          <td colspan="11">: Three years standard manufacturer warranty</td>
          </tr>
          <tr><td colspan="2">Payment Info</td>
          <td colspan="11">: {{$data ->paymentinfo}}</td>
          </tr>
        <tr><td colspan="2">Delivery Info</td>
          <td colspan="11">: {{$data ->deli_info}}</td>
          </tr>
          <tr><td colspan="2">Bank Details</td>
          <td colspan="11"> : AGRIM PROJECTS SERVICES GTC COMPANY<br/>
                             A/C# 2007548601,<br/>
                             NBK BANK,<br/>
                             Fahaheel Branch-1,<br/>
                             IBAN : KW72NBNBOK0000000000002007548601,<br/>

                             Swift Code : NBOKKWKW<br></td>
          </tr>
          
      </table>
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>