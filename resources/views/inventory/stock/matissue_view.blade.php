                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Material Issue</center></h2>
      <table style="width:100%;">
        
        <tr><td colspan="0">Issue No</td>
          <td>: {{$data ->issue_no}}</td>
          <td></td>
          <td></td>
           <td>Date</td>
          <td>: {{$data ->dates}}</td></tr>
        <tr><td colspan="0">Req No</td>
          <td>: {{$data ->matreq_no}}</td>
          <td></td>
          <td></td>
          <td>Project Code</td>
          <td>: {{$data ->project_code}}</td></tr>
        <tr><td colspan="0">Req By</td>
          <td>: {{$data ->req_by}}</td>
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
            <th>Req Qnty</th>
            <th>Iss Qnty</th>
            <th>Pen Qnty</th>
            

          </tr>
        </thead>
        <tbody>
          @foreach($data->projectmaterialissuedetail as $sqoute)
          
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->req_qnty}}</td>
            <td style="text-align: center;">{{$sqoute->issue_qnty}}</td>
            <td style="text-align: center;">{{$sqoute->req_qnty - $sqoute->issue_qnty}}</td>
          
          </tr>
          @endforeach
         
        </tbody>

      </table>
      <br/>
      <table style="width:100%;">
        
        <tr><td colspan="0">Issue By:
          <br/>{{$data ->executive}}</td>
          <td colspan="0"></td>
          <td colspan="9"></td>

           <td>Received By<br/><br/></td>
          <td > </td></tr>
          <tr><td colspan="0"></td>
          <td colspan="0"></td>
          <td colspan="9"></td>
          <td>Signature<br/><br/></td>
          <td ></td></tr>
          <tr><td colspan="0"></td>
          <td colspan="0"> </td>
          <td colspan="9"></td>
          <td>Mob<br/><br/></td>
          <td > </td></tr>
          <tr><td colspan="0"></td>
          <td colspan="0"></td>
          <td colspan="9"></td>
          <td>IDNo<br/><br/></td>
          <td > </td></tr>
          <tr><td colspan="0"></td>
          <td colspan="0"></td>
          <td colspan="9"></td>
          <td>Location<br/><br/></td>
          <td > </td></tr>
          
      </table>
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>