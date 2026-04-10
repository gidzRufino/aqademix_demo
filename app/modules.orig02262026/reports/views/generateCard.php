<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Generate DepEd Form 138 - A
            <small>
                
                <div class="form-group col-lg-2 pull-right" style="margin-right:20px; ">
                        <div class="controls" id="AddedSection">
                          <select  onclick="generateCard()"  name="inputSection" id="inputStudent" style="width:100%;" required>
                               <option>Select Student</option> 
                             <?php  foreach ($students->result() as $s)
                                {     
                             ?>
                               <option value="<?php echo $s->st_id; ?>"><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></option>  
                             <?php } ?>
                          </select>
                        </div>
                    </div>

                <div class="form-group col-lg-2 pull-right" id="month" style="width:230px;">
                        <div class="controls" id="addTerm">
                          <select tabindex="-1" id="sy" style="width:200px" class="span2">
                                        <?php 
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($this->session->userdata('school_year')==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
                          </select>
                        </div>
                </div>

                <div class="form-group col-lg-2 pull-right" id="month" style="">
                        <div class="controls" id="addTerm">
                          <select tabindex="-1" id="inputTerm" style="width:100%;">
                                        <option >Select Grading</option>
                                        <option value="1">First Grading</option>
                                        <option value="2">Second Grading</option>
                                        <option value="3">Third Grading</option>
                                        <option value="4">Fourth Grading</option>

                          </select>
                        </div>
                </div>
            </small>
            
        </h3>
        <input type="hidden" id="strand" value="<?php echo $strand ?>" />
         
    </div>

    <div id="generatedResult" class="col-lg-12">
        
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
        var strand_id = $('#strand').val();
        var url = "<?php echo base_url().'reports/generateReportCard/'?>"+st_id+'/'+term+'/'+school_year+'/'+strand_id;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                  $('#generatedResult').html(data)     
                      
            }
          });
    }
</script>
