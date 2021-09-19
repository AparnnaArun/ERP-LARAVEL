   
                        <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Qoute# </span>
                        </div>
                         <select class="form-control mySelect2 select_product " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name=""  multiple="multiple" >
                          
                       @foreach($senq as $row)
                        <option value="{{$row->id}}" >{{$row->qtn_no}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>
                    <script type="text/javascript">
                    	 $('.mySelect2').select2({
  selectOnClose: true
});
                    </script>