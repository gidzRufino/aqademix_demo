<div class="modal-dialog" style="width: 700px;">
   <div class="modal-content">
      <div class="modal-header bg-primary">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <b class="modal-title" id="myModalLabel">Create a Topical Term</b>
      </div>
      <div class="modal-body" >
         <div class="container-fluid">
            <form class="form-horizontal" id="new_tt" name="new_tt">
               <div class="form-group col-md-12 ">
                  <label for="bk_dds_code">Topical Term</label>
                  <div class="controls">
                     <input type="text" style="width:90%;" id="bk_tt" name="bk_tt" placeholder="Enter a Topical Term">					
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="button" id="new_tts" name="new_tts" class="btn btn-success">Save changes</button>
   </div>
</div>


<script type="text/javascript">
   $("#new_tts").click(function (){
      var url_a = "<?php echo base_url() . 'librarymodule/save_new_tt' ?>";
      var tt = document.getElementById("bk_tt").value;
         $.ajax({
            type: "POST",
            url: url_a,
            data: $("#new_tt").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {
               alert('New Topical Term Successfully added!');
               $('#bk_tt1').append("<option value='"+data+"'>"+tt);
               $('#bk_tt2').append("<option value='"+data+"'>"+tt);
               $('#bk_tt3').append("<option value='"+data+"'>"+tt);
               $('#add_bk_tt_modal').modal('hide'); 
            }
        });
   });   
</script>
