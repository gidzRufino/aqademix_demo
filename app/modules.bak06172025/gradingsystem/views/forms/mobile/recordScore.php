<div data-role="page" id="recordScore">
    <div style="height:55px;" data-role="header" data-theme="b">
        <h4 id="myModalLabel">Record Assessment Results</h4>
        <button onclick="window.history.back()" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-right ui-icon-back">Back</button>
    </div>
   
      
  <div style="margin-bottom: 30px;">
               
        <select onchange="getQuiz(this.value)" name=""  id="" required>
            <option>Search Date</option> 

          </select>
   <div id="quizResult" >

   </div>
                  
  </div>
      <div data-position="fixed"  data-theme="b" data-role="footer" >
                <div data-role="navbar">
                    <ul>
                        <li><a data-transition="slideup"  href="#" onclick="document.location='<?php echo base_url().'gradingsystem' ?>'" data-icon="home">GS Home</a></li>
                        <li><a data-transition="slideup"  href="#createQuiz" onclick="getAssessmentCategory()" data-icon="plus">Create</a></li>
                        <li><a data-transition="slideup"  href="#recordScore" onclick="enterRawScore()" data-icon="edit"  class="ui-btn-active">Enter RS</a></li>
                        <li><a data-transition="slideup"  href="#classRecord"  onclick="getClassRecord()" data-icon="grid" class="">View</a></li>
                    </ul>
                </div>

            </div>    
    
</div>

           

<script type="text/javascript" >
    $(document).ready(function() {
        $('#').change(function(){
           getQuiz($(this).val())
          
        });
          
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
            var url = "<?php echo base_url().'/gradingSystem/recordScore' ?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: $("#recordScoreForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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