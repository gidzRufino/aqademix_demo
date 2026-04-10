<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-5" rowspan="2">Subject</th>
        <th class="text-center" colspan="2">First Semester</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2" rowspan="2">Final Rating</th>
        <?php if ($gsYR != $this->session->school_year): ?>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Action</th>
        <?php endif; ?>
    </tr>
    <tr>
        <th class="col-lg-1 text-center">1</th>
        <th class="col-lg-1 text-center">2</th>
    </tr>

    <?php
    // print_r($acadRecords);
    
    $aRec1 = 0;
    $aRec2 = 0;
    $aRec3 = 0;
    $aRec4 = 0;
    

    $count = 0;
    foreach ($acadRecordsFirst->result() as $ar):
        $count++;
        if($ar->subject_id != 0):
            ?>
            <tr>
                <td class="col-lg-5"><?php echo $ar->subject ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->first ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->second ?></td>
                <th style="text-align: center" class="col-lg-1"><?php echo $ar->avg ?></th>
                <?php if ($gsYR != $this->session->school_year): ?>
                    <td style="vertical-align: middle; text-align: center;">
                    <div class="btn-group">    
                    <button onclick="$('#editGrades').modal('show'), 
                                     $('#editSubject').html('<?php echo $ar->subject ?>'),   
                                     $('#editFirst').val('<?php echo $ar->first ?>'),   
                                     $('#editSecond').val('<?php echo $ar->second ?>'),   
                                     $('#editAverage').val('<?php echo $ar->avg ?>'),   
                                     $('#editSem').val('<?php echo $ar->sem ?>'),   
                                     $('#editARid').val('<?php echo $ar->ar_id ?>')  
                                     " 
                                          
                                     class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                    </button>
                    <button onclick="$('#deleteRecord').modal('show')" onmouseover="$('#inputDeleteARID').val('<?php echo $ar->ar_id ?>'), $('#inputDeleteYear').val('<?php echo $gsYR; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
                    <?php 
                endif; 
                $aveSub += $ar->avg; 
                ?>
            </tr>
            <?php
        else:
            ?>
            <tr>
                <th style="text-align: right">General Average</th>
                <th style="text-align: center"><?php echo $ar->first ?></th>
                <th style="text-align: center"><?php echo $ar->second ?></th>
                <th style="text-align: center"><?php echo $ar->avg ?></th>
            </tr>
            <?php
        endif;
    endforeach;
    ?>
    
</table>

<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-5" rowspan="2">Subject</th>
        <th class="text-center" colspan="2">Second Semester</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2" rowspan="2">Final Rating</th>
        <?php if ($gsYR != $this->session->school_year): ?>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Action</th>
        <?php endif; ?>
    </tr>
    <tr>
        <th class="col-lg-1 text-center">1</th>
        <th class="col-lg-1 text-center">2</th>
    </tr>

    <?php
    
    $aRec1 = 0;
    $aRec2 = 0;
    $aRec3 = 0;
    $aRec4 = 0;
    

    $count = 0;
    foreach ($acadRecordsSecond->result() as $ar):
        $count++;

        if($ar->subject_id != 0):
            ?>
            <tr>
                <td class="col-lg-5"><?php echo $ar->subject ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->third ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->fourth ?></td>
                <th style="text-align: center" class="col-lg-1"><?php echo $ar->avg ?></th>
                <?php if ($gsYR != $this->session->school_year): ?>
                <td style="vertical-align: middle; text-align: center;">
                <div class="btn-group">    
                    <button onclick="$('#editGrades').modal('show'), 
                                     $('#editSubject').html('<?php echo $ar->subject ?>'),   
                                     $('#editFirst').val('<?php echo $ar->third ?>'),   
                                     $('#editSecond').val('<?php echo $ar->fourth ?>'),   
                                     $('#editAverage').val('<?php echo $ar->avg ?>'),   
                                     $('#editSem').val('<?php echo $ar->sem ?>'),   
                                     $('#editARid').val('<?php echo $ar->ar_id ?>')  
                                     " 
                                          
                                     class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                    </button>
                    <button onclick="$('#deleteRecord').modal('show')" onmouseover="$('#inputDeleteARID').val('<?php echo $ar->ar_id ?>'), $('#inputDeleteYear').val('<?php echo $gsYR; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                </div>
                </td>
                <?php endif; 
                $aveSub2 += $ar->avg; ?>
            </tr>
            <?php
        else:
            ?>
            <tr>
                <th style="text-align: right">General Average</th>
                <th style="text-align: center"><?php echo $ar->third ?></th>
                <th style="text-align: center"><?php echo $ar->fourth ?></th>
                <th style="text-align: center"><?php echo $ar->avg ?></th>
            </tr>
            <?php
        endif;
    endforeach;
    ?>
</table>

<div style="margin: 50px auto 0;" class="modal col-lg-3" id="deleteRecord" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="deleteNewBody" class="alert alert-danger clearfix text-center" style="margin-bottom: 0; padding: 3px;">
        Are you sure you want to Delete this Record ? Please note that you cannot undo the process. Continue ?<br />
        <button class="btn btn-success btn-sm" onclick="deleteRecord()">YES</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">NO</button>
        <input type="hidden" id="inputDeleteARID" />
        <input type="hidden" id="inputDeleteYear" />
    </div>
</div>

<div id="editGrades"  style="margin: 50px auto 0;" class="modal fade col-lg-4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="panel panel-green" style="min-height: 100px; overflow-y: auto;">
        <div class="panel-heading">
            <h5>Edit Subject : <span id="editSubject"></span></h5>
        </div>
        <div class="panel-body">
            <div class="col-lg-4">
                <label>First</label>
                <input type="text" class="form-control text-center" id="editFirst" value="" required/>
            </div>
              <div class="col-lg-4">
                <label>Second</label>
                <input type="text" class="form-control text-center" id="editSecond" value="" required/>
            </div>
            <div class="col-lg-4">
                <label>Average</label>
                <input type="text" class="form-control text-center" id="editAverage" value="" required/>
            </div>   
        </div>
        <input type="hidden" id="editARid" />
        <input type="hidden" id="editSem" />
        <div class="panel-footer clearfix">
            <div class="pull-right">
                   <button onclick="editAcademicRecordsSH()" type="button" class="btn btn-warning btn-xs"><i class="fa fa-save fa-fw"></i> Update</button>
                   <button data-dismiss="modal" type="button" class="btn btn-danger btn-xs"><i class="fa fa-close fa-fw"></i> close</button>
            </div> 
        </div>

    </div>
</div>