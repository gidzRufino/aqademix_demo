 <?php if($this->session->is_admin || $this->session->is_adviser): ?>  
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header clearfix" style="margin:0">Grading System Monitoring
        <?php if($this->session->is_admin): ?>    
        <div class="col-md-3 pull-right">
            <select style="font-size:16px; width: 100%;" id="section"  name="section" onclick="document.location='<?php echo base_url('gradingsystem/gradingsystem_reports/viewAssessmentPerSection/')?>'+this.value+'/'+$('#inputTerm').val()" >
              <option>Select Section</option>
              <?php 
                    foreach ($sections->result() as $s)
                      {   
                        if($s->grade_level_id > 1 && $s->grade_level_id < 14):
                            ?>                        
                                <option value="<?php echo $s->section_id ?>"><?php echo $s->level .' - '.$s->section; ?></option>

                          <?php 
                        endif;
                          
                      }
                      ?>
            </select>
        </div>
        <?php endif; ?>
            <div class="col-md-2 pull-right" id="month" style="">
                <div id="addTerm" class="pull-right">
                  <select <?php echo ($this->session->is_adviser?'onclick="loadGSMonitoring(this.value)"':''); ?> style="font-size:16px;"  tabindex="-1" id="inputTerm" class="">
                      <?php
                         $first = "";
                         $second = "";
                         $third = "";
                         $fourth = "";
                         switch($this->uri->segment(5)){
                             case 1:
                                 $first = "selected = selected";
                             break;
                             
                             case 2:
                                 $second = "selected = selected";
                             break;
                         
                             case 3:
                                 $third = "selected = selected";
                             break;
                             
                             case 4:
                                 $fourth = "selected = selected";
                             break;
                             
                         
                         }
                      ?>
                        <option >Select Grading</option>
                        <option <?php echo $first ?> value="1">First Grading</option>
                        <option <?php echo $second ?> value="2">Second Grading</option>
                        <option <?php echo $third ?> value="3">Third Grading</option>
                        <option <?php echo $fourth ?> value="4">Fourth Grading</option>
                                
                  </select>
                    
                </div>
             
        </div>
        </h1>
        
    </div>
    
    <?php 
    if($this->uri->segment(4)!=NULL): 
        $section = Modules::run('registrar/getSectionById', $section_id);
        $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
        
        ?>
    <div class="col-lg-12">
        <h4 class="text-center"><?php echo $section->level.' - '.$section->section ?></h4>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th>Name of Student</th>
                    <th></th>
                    <?php
                        
                    
                    foreach($subject_ids as $s){  
                        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                        ?>
                        <th class="text-center"><?php echo strtoupper($singleSub->short_code); ?></th>
                        <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=1;
                    $totalGrade = 0;
                    foreach($male->result() as $m):
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo strtoupper($m->lastname.', '.$m->firstname.' '.substr($m->middlename, 0, 1).'.') ?></td>
                        <td></td>
                        <?php
                            foreach($subject_ids as $s){  
                                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                $category = Modules::run('gradingsystem/getAssessCategory', $singleSub->subject_id, $school_year);
                                $grade = Modules::run('gradingsystem/gradingsystem_reports/viewAssessments', $m, $category, $this->uri->segment(5), $singleSub);
                               
                                if($singleSub->subject_id==3):
                                //   echo $this->uri->segment(5);
                                endif;
                                if($singleSub->subject_id != 55 && $singleSub->subject_id != 56):
                                  
                                  
                                endif;
                                ?>
                                <th class="text-center"><?php echo $grade ?></th>
                                <?php
                            }
                        ?>
                    </tr>
                <?php
                    endforeach;
                    $totalGrade = 0;
                    foreach($female->result() as $f):
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo strtoupper($f->lastname.', '.$f->firstname.' '.substr($f->middlename, 0, 1).'.') ?></td>
                        <td></td>
                        <?php
                            foreach($subject_ids as $s){  
                                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                $category = Modules::run('gradingsystem/getAssessCategory', $singleSub->subject_id, $school_year);
                                $grade = Modules::run('gradingsystem/gradingsystem_reports/viewAssessments', $f, $category, $this->uri->segment(5), $singleSub);
                               
                                if($singleSub->subject_id==3):
                                //   echo $this->uri->segment(5);
                                endif;
                                if($singleSub->subject_id != 55 && $singleSub->subject_id != 56):
                                  
                                  
                                endif;
                                ?>
                                <th class="text-center"><?php echo $grade ?></th>
                                <?php
                            }
                        ?>
                    </tr>
                <?php
                    endforeach;
                
                ?>
            </tbody>
        </table>
    </div>
    <?php endif;
    else:
        redirect(base_url());
    endif; 
?>
    
    
</div>    

<script type="text/javascript">
    
    $(document).ready(function(){
       $('#section').select2(); 
    });
    
    function loadGSMonitoring(term)
    {
        document.location = '<?php echo base_url('gradingsystem/gradingsystem_reports/viewAssessmentPerSection/').$this->session->advisory.'/' ?>'+term;
    }
    
</script>    