                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Sales Quotation</center></h2>
      <table>
        <tr><td>To,</td></tr>
        <tr><td colspan="3">{{$data ->name}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data ->qtn_no}}</td></tr>
        <tr><td colspan="3">{{$data ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{$data ->dates}}</td></tr>
        <tr><td colspan="3">Kind Attn:{{$data ->authority}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Currency</td>
          <td>: {{$data ->currency}}</td></tr>
          <tr><td colspan="3"></td>
          <td>Qtn Ref</td>
          <td>: {{$data ->qtn_ref}}</td>
          <td></td>
          <td>Enq Ref</td>
          <td>: {{$data ->currency}}</td></tr>
          <tr><td colspan="13"><p align="left" ><b>Dear Sir,<br/></b>
         With Reference to your inquiry for the subject item, We wish to offer our Best Price as follows:</p><br/></td></tr>
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
          @foreach($data->salesquotationdetail as $sqoute)
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
        <tr><td colspan="13"><b>Note:{{$data->remarks}}</b><hr></td>
          
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
          <tr><td colspan="2">Validity of Quote</td>
          <td colspan="11">: {{$data ->validity}}</td>
          </tr>
          
      </table>
<table><tr><td colspan="13">
         Hope this will meet your requirements. If you have any questions and clarifications, please feel free to contact us</td></tr>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>