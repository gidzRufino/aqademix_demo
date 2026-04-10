<div class="modal-dialog" style="width: 700px;">
   <div class="modal-content">
      <div class="modal-header bg-primary">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <b class="modal-title" id="myModalLabel">Enroll Dewey Decimal Code</b>
      </div>
      <div class="modal-body" >
         <div class="container-fluid">
            <form class="form-horizontal" id="new_dds" name="new_dds">
               <div class="form-group col-md-12 ">
                  <label for="bk_deweysi">General Code</label>
                  <div class="controls">
                     <select tabindex="-1" id="bk_deweysi" name="bk_deweysi" style="width: 90%;">
                         <option>General Category</option>
                           <?php foreach ($bk_dds as $dd) { ?>
                         <option value="<?php echo $dd->dw_id; ?>">[<?php echo $dd->dw_dewey_code.'] &nbsp|&nbsp&nbsp'.$dd->dw_dewey_desc; ?></option>
                           <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_dds_code">DDS Code</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_dds_code" name="bk_dds_code" placeholder="Enter Code (e.g. 311.25)">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_dds_desc">DDS Description</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_dds_desc" name="bk_dds_desc" placeholder="Description">					
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="button" id="save_dds" name="save_dds" class="btn btn-success">Save changes</button>
   </div>
</div>


<script type="text/javascript">
   $("#save_dds").click(function (){
      var url_a = "<?php echo base_url() . 'librarymodule/save_new_dds' ?>";
      var dds_gen = document.getElementById('bk_deweysi').value;
      var dds_code = document.getElementById('bk_dds_code').value;
      var dds_desc = document.getElementById('bk_dds_desc').value;
      if (dds_gen === null || dds_gen === "General Category" ){
         alert('Please select General Category to continue.');
      }else if (dds_code === null || dds_code === "" ){
         alert('Please provide DDS Code to continue.');
      }else if (dds_desc === null || dds_desc === "" ){
         alert('Please provide DDS Description to continue.');
      }else{
         $.ajax({
            type: "POST",
            url: url_a,
            data: $("#new_dds").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {
               alert('New DDS Code Successfully added! The page will be refreshed so that you can find the newly added DDS among the options.');
               $('#bk_dewey').append("<option value='"+data+"'>"+dds_code+" &nbsp|&nbsp "+dds_desc+"</option>");
               $('#add_bk_dds_modal').modal('hide'); 
            }
        });
      }
   });   
</script>
