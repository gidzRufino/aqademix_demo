<div id="recordScore" style="display: none;">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3 pull-right">
                    <a href="#importCsv" data-toggle="modal"  id="uploadAssessment" class="btn btn-success pull-right" >
                       <i class="fa fa-upload fa-2x"></i>
                   </a>
                    <button id="deleteAssessment" alt="" onclick="deleteAssessment()" class="btn btn-danger hide pull-right"  >
                        <i class="fa fa-trash fa-2x"></i>
                    </button> 
                   <a id="editAssessment" onclick="showAssessmentCategory()" class="btn btn-info hide pull-right" data-toggle="modal" href="#editAssessForm" >
                       <i style="color:white" class="fa fa-pencil fa-2x"></i>
                   </a> 
                   
               </div>
                <div class="col-lg-4">
                    <h4 id="myModalLabel">Record Assessment Results</h4>
                    <select onclick="getQuiz(this.value)" name="searchAssessDate" style="width:220px;" id="searchAssessDate" required>
                        <option>Search Date</option> 
                       
                      </select>
                </div>                
                
                <div id="asWrapper" class="col-lg-5 pull-left">
                    
                </div>
                
                <div id='answer'>

                </div>
                </div>
                
            </div>
  <div class="panel-body" style="height:350px; overflow-y: scroll;">
   <form id="recordScoreForm" action="" method="post">  

               <div id="quizResult">
                  
               </div>
       
     </form>  
  </div>
        </div>
</div>
  <?php $this->load->view('editAssessForm') ?>  
</div>
<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload e-sKwela Template</h4>
        </div>
             <?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'reports/importAssessment', $attributes);
        ?>
        <div class="panel-body">

                    <input style="height:30px" type="file" name="userfile" ><br />
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>

<script type="text/javascript" >
    function showAssessmentCategory()
      {
         var department = document.getElementById('grade_id').value;
          var url = "<?php echo base_url().'gradingsystem/getAssessCatDropdown/'?>"+department ;
         if(department!=""){  
            $.ajax({
             type: "GET",
             url: url,
             data: 'details='+department, // serializes the form's elements.
             success: function(data)
             {
                document.getElementById('selectAssessmentCat').innerHTML = data
                //$('#selectAssessmentCategory1').html(data);

             }
           });
         }else{
                alert('Please Select Subject First');
                location.reload();
           } 
          
          $('#no_Items').val($('#numberOfItems').html());
        
      }
    function editAssessment()
    {
        var qcode = $('#qcode').val();
        var cat = $('#selectAssessmentCat').val()
        var no_items = $('#no_Items').val()
        var input_term = $('#editTerm').val()
        var url = "<?php echo base_url().'gradingsystem/editAssessment/'?>"+qcode+'/'+cat+'/'+no_items+'/'+input_term ;
           $.ajax({
                type: "GET",
                url: url,
                data: 'qcode='+qcode, // serializes the form's elements.
                success: function(data)
                {
                  alert('Successfully Changed!')
                  location.reload();
                }
           })
    }
    function deleteAssessment()
    {
       var qcode = $('#qcode').val();
       //alert(qcode);
           var answer = confirm("Do you really want to Delete this Assessment? \n\  Warning: You cannot undo this process.");
            if(answer==true){
               var url = "<?php echo base_url().'gradingsystem/deleteAssessment/'?>"+qcode ;
               $.ajax({
                type: "GET",
                url: url,
                data: 'qcode='+qcode, // serializes the form's elements.
                success: function(data)
                {
                   alert('Assessment Deleted!')
                   location.reload();
                }
              });
            }else{

               return FALSE
            }
     }
       
    
    $(document).ready(function() {
          $("#searchAssessDate").select2();
          
    });
    function getQuiz(id)
    {
        $('#submitLoad').removeClass('hide');
        $('#verify_icon').removeClass('hide');
        $('#quizResult').html($('#submitLoad').html());
        var url = "<?php echo base_url().'gradingsystem/getAssessmentDetails/'?>"+id ;
          $.ajax({
           type: "GET",
           url: url,
           data: 'qcode='+id, // serializes the form's elements.
           success: function(data)
           {
              $('#quizResult').html(data);
              $('#deleteAssessment').removeClass('hide');
              $('#editAssessment').removeClass('hide');;
              $('#uploadAssessment').hide();
              $('#assessValue').val(id);
              //$('#assessWrapper').removeClass('hide')
              $('#asWrapper').html($('#assessWrapper').html());
              $('#submitLoad').addClass('hide');
              $('#verify_icon').addClass('hide');

           }
         });
    }
    
    
    $('#recordQuizBtn').click(function() {
    if(document.getElementById('recordStudent').value=='Search Student'){
        alert('Please Select Student First');
    }else if(document.getElementById('rawScore').value==''){ 
        alert('Please Enter Raw Score');
    }else{
            var url = "<?php echo base_url().'index.php/gradingSystem/recordScore' ?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+$("#recordScoreForm").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       //$("form#recordScoreForm")[0].reset();

                      //$("#msgResult").innerHTML='<textarea id="inputMessage" name="message"  onclick="" placeholder="Type in Your Message..." style="margin-left:4px;width:550px; "></textarea>'
                       alert(data); // show response from the php script.
                       document.getElementById('rawScore').value = ''
                      // document.location = '<?php echo base_url()?>gradingSystem/'
                   }
                 });

            return false; // avoid to execute the actual submit of the form.
        }
        })
    
    
    


</script>