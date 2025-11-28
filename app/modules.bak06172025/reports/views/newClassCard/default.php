<div class="row" style="margin-bottom: 50px;">
    <div class="page-header clearfix" style="width:1080px; background: #FFF; z-index: 2000">
        <h3 class="pull-left" style="margin:0">Generate Class Card</h3>
	
	<div class="control-group pull-right" style="width:230px;">
                <div class="controls" id="AddedSection">
                  <select  onclick="generateCard()" style="width:230px;"  name="inputSection" id="inputStudent" class="pull-left col-lg-12" required>
                       <option>Select Student</option> 
                     <?php  foreach ($students->result() as $s)
                        {     
                     ?>
                       <option value="<?php echo $s->st_id; ?>"><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></option>  
                     <?php } ?>
                  </select>
                </div>
            </div>

        <div class="control-group pull-right" id="month" style="width:230px;">
                <div class="controls" id="addTerm">
                  <select tabindex="-1" id="sy" style="width:200px" class="span2">
                                <option value="2014">2014 - 2015</option>
                                <option value="2015">2015 - 2016</option>
                                <option value="2016">2016 - 2017</option>
                  </select>
                </div>
        </div>
	        
        <div class="control-group pull-right" id="month" style="width:230px;">
                <div class="controls" id="addTerm">
                  <select tabindex="-1" id="inputTerm" style="width:200px" class="span2">
                                <option >Select Grading</option>
                                <option value="1">First Grading</option>
                                <option value="2">Second Grading</option>
                                <option value="3">Third Grading</option>
                                <option value="4">Fourth Grading</option>
                                
                  </select>
                </div>
        </div>
        
         
    </div>


    
    <div id="generatedResult" class="row-fluid">
        
    </div>
    
    
    
</div>
<script type="text/javascript">
        $(document).ready(function() {
           // $("#inputTerm").select2();
            $("#sy").select2();
            $("#inputStudent").select2();
        });
        
    function generateCard()
    {
        var st_id = $('#inputStudent').val();
        var term = $('#inputTerm').val();
        var school_year = $('#sy').val();
        var url = "<?php echo base_url().'reports/cc/generateCC/'?>" ;
           $.ajax({
            type: "POST",
            url: url,
            data: 'term='+term+'&st_id='+st_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {
                  $('#generatedResult').html(data)     
                      
            }
          });
    }
</script>