<div class="modal" id="autoDataInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header clearfix">
         Generate Record
         <i class="fa fa-close pull-right pointer" data-dismiss="modal"></i>
         <button onclick="getRecords()" class="btn btn-primary pull-right"><i class="fa fa-database fa-fw"></i>Fetch Records</button>
      </div>
      <div class="modal-body clearfix">
        <div class="col-lg-12" id="autoFetchRecords">

        </div> 
          
     </div>
    </div>
  </div>
</div>
<input type="hidden" id="saveController" value="0" />

<script type="text/javascript">
     
     function getRecords()
     {
         var user_id = $('#user_id').val();
         var grade_level = $('#selectedLevel').val()
         var isSave = $('#saveController').val()
         
          var url = "<?php echo base_url().'reports/searchRecords/'?>"
           $.ajax({
                type: "POST",
                url: url,
                data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+'&user_id='+user_id+'&grade_level='+grade_level+'&ifSave='+isSave+'&spr_id='+$('#spr_id').val(),
                beforeSend: function() {
                    showLoading('autoFetchRecords');
                },
                success: function(data)
                {
                    $('#autoFetchRecords').html(data);
                    if(isSave==1)
                        {
                            alert('Records Successfully Processed')
                        }
                    if(isSave==2)
                        {
                            alert('Record is Successfully Reprocessed');
                            $('#autoDataInput').modal('hide');
                            getAcad(grade_level)
                        }
                }
                
            
            
            })
     }
        
        
</script>    