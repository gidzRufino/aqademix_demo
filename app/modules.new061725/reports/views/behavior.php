<div class="col-lg-6">
        <h5>Pagpapahalaga at Saloobin</h5>
        <hr />
        <table class="table table-striped">
            <tr>
                <td>Details</td>
                <td>Ratings</td>
            </tr>
            <?php 
                foreach($behavior as $beh)
                {
                    $behaviorRating = Modules::run('gradingsystem/getBHRating', $student->uid,$term, $sy, $beh->bh_id);    
                    ?>
            <tr>
                <td><?php echo $beh->bh_name ?></td>
                <td>
                <?php 
                if($gs_settings->gs_used==1):
                    
                ?>
                 <select onclick="submitRating('<?php echo $student->uid?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $beh->bh_id ?>)" tabindex="-1" style="width:200px" class="span2">
                        <?php 
                        if($behaviorRating->num_rows()>0):
                                switch ($behaviorRating->row()->rate){
                                  case 1:
                                      $one = 'selected';
                                      $two = '';
                                      $three = '';
                                  break;    
                                  case 2:
                                      $one = '';
                                      $two = 'selected';
                                      $three = '';
                                  break;    
                                  case 3:
                                      $one = '';
                                      $two = '';
                                      $three = 'selected';
                                  break;    
                                }
                            else:
                                        $one = '';
                                      $two = '';
                                      $three = '';
                        endif; ?> 
                        <option>Select Rating</option>
                        <option <?php echo $three ?> value="3">Lubhang Kasiya-siya</option>
                        <option <?php echo $two ?> value="2">Kasiya-siya</option>
                        <option <?php echo $one ?> value="1">Dapat Pang linangin</option>
                  </select>
                    
                <?php
                else:
                ?>
                    <select onclick="submitRating('<?php echo $student->uid?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $beh->bh_id ?>)" tabindex="-1" style="width:200px" class="span2">
                        <?php 
                        if($behaviorRating->num_rows()>0):
                                switch ($behaviorRating->row()->rate){
                                  case 1:
                                      $one = 'selected';
                                      $two = '';
                                      $three = '';
                                      $fourth = '';
                                  break;    
                                  case 2:
                                      $one = '';
                                      $two = 'selected';
                                      $three = '';
                                      $fourth = '';
                                  break;    
                                  case 3:
                                      $one = '';
                                      $two = '';
                                      $three = 'selected';
                                      $fourth = '';
                                  break;    
                                  case 4:
                                      $one = '';
                                      $two = '';
                                      $three = '';
                                      $fourth = 'selected';
                                  break;    
                                }
                            else:
                                        $one = '';
                                      $two = '';
                                      $three = '';
                                      $fourth = '';
                        endif; ?> 
                        <option>Select Rating</option>
                        <option <?php echo $fourth ?> value="4">Always Observed</option>
                        <option <?php echo $three ?> value="3">Sometimes Observed</option>
                        <option <?php echo $two ?> value="2">Rarely Observed</option>
                        <option <?php echo $one ?> value="1">Not Observed</option>
                  </select>
                <?php    
                    endif;
                ?>
                </td>
            </tr>

            <?php
                }
            ?>

        </table>
    </div>
 
</div>