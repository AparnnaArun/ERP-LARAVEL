   
                        <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">DO# </span>
                        </div>
                         <select class="form-control mySelect2 select_product " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="deli_note_no[]"  multiple="multiple" >
                          
                       @foreach($dos as $row)
                        <option value="{{$row->id}}" >{{$row->deli_note_no}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>
                    <script type="text/javascript">
                    	 $('.mySelect2').select2({
  selectOnClose: true
});
                    </script>