                     <div class="card-body">
<br/><br/><br/><br/><br/>
<h2 class="card-title " ><center>@if($iivs->payment_mode  =='credit')
Sales Invoice @else Cash Invoice @endif</center></h2>
      <table style="width:100%;">
        <tr><td>To,</td></tr>
        <tr><td colspan="4">{{$data1 ->name}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$iivs ->invoice_no}}</td></tr>
        <tr><td colspan="4">{{$data1 ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{$iivs ->dates}}</td></tr>
          <tr><td colspan="4">DO # : @foreach($doo as $do){{$do ->deli_note_no}},@endforeach</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Manual DO</td>
          <td>: {{$iivs ->manual_do_no}}</td></tr>
        <tr><td colspan="4">PO# : {{$iivs ->customer_po}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Currency</td>
          <td>: {{$iivs ->currency}}</td></tr>
          
          
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
          @foreach($result as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->sum_qty}}</td>
            <td style="text-align: center;">{{$sqoute->rate}}</td>
            <td style="text-align: center;">{{$sqoute->sum_disc}}</td>
            <td style="text-align: center;">{{$sqoute->sum_amt}}</td>
          </tr>
          @endforeach
          <tr>
            <th colspan="13">Total Value</th>
            <th>{{$iivs ->total}}</th>
           
          </tr>
          <tr>
            <th colspan="13">Discount</th>
            <th>{{$iivs ->discount_total}}</th>
           
          </tr>
          <tr>
            <th colspan="13">Net Value</th>
            <th>{{$iivs ->net_total}}</th>
           
          </tr>
        </tbody>
<br/><br/><br/>
      </table>
      <br/>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <tr><td colspan="13">Payee/Beneficiary</td></tr>
       
          <tr>
          <td colspan="6">  AGRIM PROJECTS SERVICES GTC COMPANY<br/>
                             A/C# 2007548601,<br/>
                             NBK BANK,<br/>
                             Fahaheel Branch-1,<br/>
                             IBAN : KW72NBNBOK0000000000002007548601,<br/>

                             Swift Code : NBOKKWKW<br></td>
                             <td colspan="7">  AGRIM PROJECTS SERVICES GTC COMPANY<br/>
                              
    A/C# 05697667, <br/>
    GULF BANK <br/>
    Farwaniya Branch-1<br/>
    IBAN : KW60GULB0000000000000002005697667 <br/>
    Swift Code : GULBKWKW <br/></td>
          </tr>
          
      </table>
<table>
         <tr>
           <td>Thank You,</td></tr>
            <tr>
           <td>Yours Truly,<br/><br/></td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr> <tr><td>{{$invs1->executive}}</td>
         </tr></table>




                  </div>