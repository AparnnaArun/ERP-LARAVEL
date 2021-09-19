                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Sales Return</center></h2>
      <table style="width:100%;">
        <tr><td>To,</td></tr>
        <tr><td colspan="4">{{$data1 ->name}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data1 ->rtn_no}}</td></tr>
        <tr><td colspan="4">{{$data1 ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{$data1 ->rtndate}}</td></tr>
        <tr><td colspan="4">Invoice No : {{$doo ->invoice_no}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td></tr>
          
          
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>Rtn Qnty</th>
            <th>Rtn Free Qnty</th>
            <th>Damage</th>
            <th>Unit Price<br>in KWD</th>
            <th>Disc</th>
            <th>Tot.Price<br>in KWD</th>

          </tr>
        </thead>
        <tbody>
          @foreach($iivs->salesreturndetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->rtnqnty}}</td>
            <td style="text-align: center;">{{$sqoute->rtnfreeqnty}}</td>
            <td style="text-align: center;">{{$sqoute->damage}}</td>
            <td style="text-align: center;">{{$sqoute->rate}}</td>
            <td style="text-align: center;">{{$sqoute->discount}}</td>
            <td style="text-align: center;">{{$sqoute->amount}}</td>
          </tr>
          @endforeach
          <tr>
            <th colspan="15">Total Value</th>
            <th>{{$data1 ->total}}</th>
           
          </tr>
          <tr>
            <th colspan="15">Discount</th>
            <th>{{$data1 ->discount_total}}</th>
           
          </tr>
          <tr>
            <th colspan="15">Net Value</th>
            <th>{{$data1 ->net_total}}</th>
           
          </tr>
        </tbody>

      </table>
      <br/>
      <table>
       
       
          
        <tr><td colspan="2">Delivery Info</td>
          <td colspan="11">: {{$data1 ->deli_info}}</td>
          </tr>
          <tr><td colspan="2">Vehicle Info</td>
          <td colspan="11">: {{$data1 ->paymentinfo}}</td>
          </tr>
          
          
      </table>
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>