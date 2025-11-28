<div class="modal-dialog" style="width: 700px;">
   <div class="modal-content">
      <div class="modal-header bg-primary">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <b class="modal-title" id="myModalLabel">Add New Publication Information</b>
      </div>
      <div class="modal-body" >
         <div class="container-fluid">
            <form class="form-horizontal" id="new_publication" name="new_publication">
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_name">Publisher's Name / Publishing House</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication" name="bk_publication" placeholder="Enter name of the publication">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_address">Address</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication_address" name="bk_publication_address" placeholder="Address of the publication">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_email">Contact Number</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication_contactnum" name="bk_publication_contactnum" placeholder="publication's contact number">
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_contactperson">Contact Person</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication_contactperson" name="bk_publication_contactperson" placeholder="publication's contact person">
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_web">Website</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication_web" name="bk_publication_web" placeholder="publication's website">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_publication_email">Email Address</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_publication_email" name="bk_publication_email" placeholder="publication's email address">					
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="button" id="save_publication" name="save_publication" class="btn btn-success">Save changes</button>
   </div>
</div>

<script type="text/javascript">
   $("#save_publication").click(function (){
      var url_a = "<?php echo base_url() . 'librarymodule/save_new_publication' ?>";
      var a_name = document.getElementById('bk_publication').value;
      if (a_name === null || a_name === "" ){
         alert('Please provide publication Name to continue.')
      }else{
         $.ajax({
            type: "POST",
            url: url_a,
            data: $("#new_publication").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {
               alert('New publication Successfully added! You can now search the newly added publisher from the list..');
               // location.reload();             
               $('#bk_publisher').append("<option value='"+data+"'>"+a_name+"</option>");
               $('#add_bk_publisher_modal').modal('hide');   
            }
        });
      }
   });
</script>
           