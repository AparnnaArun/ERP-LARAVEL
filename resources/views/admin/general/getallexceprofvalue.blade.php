
<table>
    <thead>
        <th>Executive</th>
        <th>Amount</th>
    </thead>
    <tbody>
       
@foreach($pinv as $pi)
<tr>
 <td><input type="text" class="form-control pas"   id="pas" value="{{$pi->short_name}}"  readonly ></td>
 <td><input type="text" class="form-control"   id="pexec" value="{{$pi->pinvs}}" readonly ></td></tr>
@endforeach
    </tbody>
</table>
<input type="text" class="form-control"   id="cnt" value="{{$cnt}}" readonly >