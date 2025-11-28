<div class="row">
     <?php
            if($this->session->userdata('isVoterLoggedIn')):
        ?>  
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Election Management System
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" onclick="submitBalot()" class="btn btn-danger" >Done Voting</button>
              </div>
        </h3>
    </div>
    <div class="col-lg-12">
             
             <h2 class="text-center text-danger">List of Candidates</h2>
        <?php 
            foreach ($candidate_position as $p):
       ?>
        <div class="panel panel-success no-padding" style="width: 60%; margin: 5px auto;" >
            <div class="panel-heading"><?php echo strtoupper($p->candidate_position) ?></div>
            <div class="panel-body clearfix">
                <ul class="list-group" id="<?php echo $p->pos_id ?>_position" >
                <?php $president = Modules::run('college/election/getCandidateList', $p->pos_id); 
                        foreach ($president as $pres):
                            $basicInfo = Modules::run('college/election/getBasicInfoBySTID', $pres->ec_st_id, $this->session->userdata('school_year'));
                        
                            switch ($basicInfo->year_level):
                              case 1:
                                  $year = 'First Year';
                              break;
                              case 2:
                                  $year = 'Second Year';
                              break;
                              case 3:
                                  $year = 'Third Year';
                              break;
                              case 4:
                                  $year = 'Fourth Year';
                              break;
                              case 5:
                                  $year = 'Fifth Year';
                              break;
                            endswitch;
                            ?>
                    <li id="<?php echo $pres->ec_id ?>_li" onclick="chooseCandidate('<?php echo $pres->ec_id ?>','<?php echo $p->pos_id ?>')" class="list-group-item clearfix btn btn-primary">
                        <img class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/'.$basicInfo->avatar;  ?>" />
                        <div class="col-lg-8">
                            <h4 style="color:black; text-align: left;"><?php echo $basicInfo->firstname.' '.$basicInfo->lastname ?></h4>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; text-align: left;"><span class="text-danger"><?php echo $basicInfo->course ?></span></h5>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; margin-left: 15px; text-align:left;"><span class="text-danger"><?php echo $year ?></span></h5>
                        </div>
                        <i id="<?php echo $pres->ec_id ?>_check" style="display: none; " class="fa fa-check fa-3x pull-right pointer text-success"></i>
                    </li>        
                            <?php
                        endforeach;
                ?>
                </ul>
            </div>
        </div>
        
        <?php
        endforeach;
        ?>
              
        
    </div>
    <?php
            else:
?>
<div id="votersLoggedIn"  style="width:30%; margin: 40px auto;"  class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h2 class="text-center">Please Enter your Id Number</h2>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control input-large" placeholder="ENTER YOUR ID HERE" id="st_id" />
        </div>
        <div class="panel-footer" style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='votersLogin()' class='btn btn-lg btn-success pull-right btn-block'>SUBMIT</a>
        </div>
    </div>
</div>   
<?php                
            endif;
?>       
</div>
<form id="balot">
    <?php 
    foreach ($candidate_position as $p):
    ?>
        <input type="hidden" id="voted_<?php echo $p->pos_id ?>" name="<?php echo $p->pos_id ?>" value="" />
    <?php
    endforeach;
    ?>
</form>    
<script type="text/javascript">
    
    $(document).ready(function(){
       $('#votersLoggedIn').modal('show');
       
      })
   
       
   
   function chooseCandidate(id, pos_id)
   {
       $('#'+id+'_check').show();
       $('#'+id+'_li').addClass('active')
       setTimeout(function(){
            $('#'+pos_id+'_position li').each(function(){
               if(!$(this).hasClass('active'))
               {
                  $(this).addClass('disabled')
               }
           });
        }, 100);
      $('#voted_'+pos_id).val(id)
   }
   
   function votersLogin()
   {
        var value = $('#st_id').val();
            var url = '<?php echo base_url().'college/election/login/' ?>'+value;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   dataType:'json',
                   success: function(data)
                   {    
                      alert(data.msg)
                      location.reload();
                   }
                 });

            return false;
       
   }
    
  function submitBalot()
  {
      var data = $('#balot').serialize();
      
    var url = '<?php echo base_url().'college/election/castVotes/' ?>';
     $.ajax({
           type: "POST",
           url: url,
           data: data+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           //dataType:'json',
           success: function(data)
           {  
               //alert(data)
              alert('Thank you for casting your vote');
              location.reload();
           }
         });

    return false;
  }
   
</script>