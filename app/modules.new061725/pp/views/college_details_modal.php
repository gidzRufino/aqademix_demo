<div id="collegeDetails" style="width:60%; margin: 15px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading clearfix">
            <h4 class="no-margin col-lg-4" id="name"><?php echo $name; ?></h4>
            <input type="hidden" id="adm_id" />
            <button style="margin-left:5px;" data-dismiss="modal" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close fa-2x"></i></button>
        </div>    
        <div id="studentData" class="panel-body">
                <table class="table table-stripped table-hover">
                    <tr>
                        <th colspan="4" class="text-center" style="border-right:1px solid #ddd"> Subjects Taken </th>
                        <th colspan="5" class="text-center"> Grade </th>
                    </tr>
                    <tr>
                        <th class="text-center">Code</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Lecture Units</th>
                        <th class="text-center">Lab Units</th>
                        <th class="text-center">Prelim</th>
                        <th class="text-center">Mid Term</th>
                        <th class="text-center">Semi Final</th>
                        <th class="text-center">Final</th>
                        <th class="text-center">Final Grade</th>
                        <th></th>
                    </tr>
                    <tbody id="subjectTaken">

                        <?php
                            $totalUnitsLec = 0;
                            $totalUnitsLab = 0;
                            $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $admission_id);

                            foreach ($loadedSubject as $ls):

                                    if($ls->is_final):    
                        ?>

                                        <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" onclick="removeSubject('<?php echo $ls->s_id ?>','<?php echo $ls->pre_req ?>')">
                                            <td class="text-center"><?php echo $ls->sub_code ?></td>
                                            <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                                            <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo $ls->s_lect_unit ?></td>
                                            <td class="text-center"><?php echo $ls->s_lab_unit ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                        <?php       $totalUnitsLec += $ls->s_lect_unit;
                                    $totalUnitsLab += $ls->s_lab_unit;
                                    endif;
                            endforeach;
                        ?>

                        <tr id="tr_total_taken">
                            <td colspan="2"></td>
                            <td id="totalLect_taken" class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLec==0?0:$totalUnitsLec) ?></td>
                            <td class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLab==0?0:$totalUnitsLab) ?></td>
                        </tr>    
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    });
    
    function getCollegeData(adm_id)
    {
        setTimeout(function() {
            var url = "<?php echo base_url().'college/subjectmanagement/getLoadedSubjectTemplate/' ?>"+adm_id;
            $.ajax({
               type: "POST",
               url: url,
               beforeSend: function()
               {
                   $('#studentData').html('Loading Record Please Wait Patiently...');
               } ,
               //dataType: 'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#studentData').html(data)
               }
             });
        }, 5000);
        
    
    }
    
</script>    