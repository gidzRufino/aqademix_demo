<div class="modal-dialog" style="width: 700px;">
   <div class="modal-content">
      <div class="modal-header bg-primary">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <b class="modal-title" id="myModalLabel">Add New Author Information</b>
      </div>
      <div class="modal-body" >
         <div class="container-fluid">
            <form class="form-horizontal" id="new_author" name="new_author">
               <div class="form-group col-md-6 ">
                  <label for="bk_author_name">Author Name</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_author_name" name="bk_author_name" placeholder="Enter name of the author">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_author_address">Address</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_author_address" name="bk_author_address" placeholder="Address of the author">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_author_web">Website</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_author_web" name="bk_author_web" placeholder="Author's website">					
                  </div>
               </div>
               <div class="form-group col-md-6 ">
                  <label for="bk_author_email">Email Address</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_author_email" name="bk_author_email" placeholder="Author's email address">					
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="button" id="save_author" name="save_author" class="btn btn-success">Save changes</button>
   </div>
</div>

<script type="text/javascript">
   $("#save_author").click(function (){
      var url_a = "<?php echo base_url() . 'librarymodule/save_new_author' ?>";
      var a_name = document.getElementById('bk_author_name').value;
      if (a_name === null || a_name === "" ){
         alert('Please provide Author Name to continue.')
      }else{
         $.ajax({
            type: "POST",
            url: url_a,
            data: $("#new_author").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {
               // document.location = '<?php echo base_url() ?>librarymodule/books/';
               alert('New Author Successfully added! You can now search the newly added author from the list.');
               // location.reload();               
               $('#bk_author').append("<option value='"+data+"'>"+a_name+"</option>");
               $('#add_bk_author_modal').modal('hide'); 
            }
        });
      }
   });
</script>
           