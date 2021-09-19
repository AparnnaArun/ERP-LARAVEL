<select  class="form-control inputpadd"  name="account_name[]" value="{{ old('account_name') }}" required >
      <option value="" hidden>Account</option>
      @foreach($sql as $data)
<option value="{{$data->id}}" >{{$data->printname}}</option>
      @endforeach
      </select>
      <input type="hidden" class="form-control  inputpadd"  name="debitcredit[]" value="{{ $action }}"  >
