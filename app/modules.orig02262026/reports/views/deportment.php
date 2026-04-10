<div class="container-fluid">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <div class="col-md-10">
            </div>
                <button style="margin-left:5px;" class="btn btn-success pull-right" onclick="$('#uploadDeportment').modal('show')"><i class="fa fa-upload"></i></button>
                <button class="btn btn-warning pull-right" onclick="downloadExcellForDeportment()"><i class="fa fa-download"></i></button>
                <h3><p style="text-align: center">Deportment : <?php echo strtoupper($deport_desc->bh_name) ?></p></h3>
                <h4><p id="term" style="text-align: center;" class="no-margin"></p>
                </h4>
            </div>
            <div class="panel-body">
                <input type="text" value="<?php echo segment_4; ?>" hidden="" id="sem">
                <input type="text" value="<?php echo segment_5; ?>" hidden="" id="bid">
                <input type="text" value="<?php echo segment_6; ?>" hidden="" id="sy">
                <table id="tableResult"  class="editableTable table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Student's Name</th>
                            <th>Deportment Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        foreach ($students->result() as $stud):
                            $n++;
                            $st_bhRate = Modules::run('gradingsystem/getBHRating', $stud->st_id, segment_4, segment_6, segment_5);
                            ?>
                            <tr>
                                <td style="width: 50%"><?php echo strtoupper($stud->lastname . ', ' . $stud->firstname) ?></td>
                                <td tdn="<?php echo $stud->st_id ?>" id="<?php echo $n ?>" class="editable" style="text-align: center; font-size:14px;"><?php echo $st_bhRate->row()->rate ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="uploadDeportment" class="modal fade" style="width:25%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Use this for bulk upload
        </div>
         <div class="panel-body">
            <?php
            $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
            echo form_open_multipart(base_url().'reports/reports_f137/uploadDeportment', $attributes);
            ?>
             <h5 id="myModalLabel">Upload an Excel File</h5> 
            <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
            <br />
            <hr />
            <input type="submit" value="upload" class="btn btn-info pull-right"/>

            </form>
         </div>
     </div>
</div>


<script type="text/javascript">
    
        
    function downloadExcellForDeportment()
    {
      var section = $('#inputSection').val();
      var term = $('#inputTerm').val();
      
      var url = '<?php echo base_url().'reports/reports_f137/exportStudentListForDeportment/' ?>'+section+'/'+term;
      //document.location = url;  
      window.open(url, '_blank');
    }  
    
    $(document).ready(function () {
        $("#searchAssessDate").select2();
        $('#editAssessDate').datepicker();

        var label = 'Record Assessment Results';
        var btnLabel = $('#lockedBtnLabel').val();
        $('#lockID').html(btnLabel)
        $('#lockID').attr('alt', $('#altLockBtnLabel').val());

        var termInput = $('#inputTerm').val();
        var term = '';

        switch(termInput){
            case '1':
                term = 'First Grading';
                break;
            case '2':
                term = 'Second Grading';
                break;
            case '3':
                term = 'Third Grading';
                break;
            case '4':
                term = 'Fourth Grading';
                break;
        }

        $('#term').text(term);
    });

    $('.editable').dblclick(function () {
        var altLockBtnLabel = $('#altLockBtnLabel').val();
        var OriginalContent = $(this).text();
        var bh = $(this).get(0).id;
        var ID = $(this).attr('tdn');
        var tdn = $(this).attr('id');

        $(this).addClass("cellEditing");
        $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "'/>");
        $(this).children().first().focus();
        $(this).children().first().keypress(function (e) {
            if (e.which == 13) {
                var newContent = $(this).val();
                var bhID = $('#bid').val();
                var term = $('#sem').val();
                var sy = $('#sy').val();

                var dataString = 'studentID=' + ID + '&rate=' + newContent + '&bhid=' + bhID + '&term=' + term + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name');

                $(this).parent().text(newContent);
                $(this).parent().removeClass("cellEditing");

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'gradingsystem/saveBHRate' ?>',
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#success').html(data.msg);
                        $('#alert-info').fadeOut(5000);

                        var nxt = parseInt(1) + parseInt(tdn);
                        getNext(nxt)
                    },
                    error: function (data) {
                        alert('error');
                    }
                });
            }
        });
        $(this).children().first().blur(function () {
            $(this).parent().text(OriginalContent);
            $(this).parent().removeClass("cellEditing");
        });
    });

    function getNext(id)
    {
        var ID = $('#' + id).attr('tdn');
        var tdn = $('#' + id).attr('id');

        var OriginalContent = $('#' + id).text();
        $('#' + id).addClass("cellEditing");
        $('#' + id).html("<input id ='input_" + tdn + "'type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />");
        $('#' + id).children().first().focus();
        $('#' + id).children().first().keypress(function (e)
        {
            if (e.which == 13) {

                var newContent = $('#input_' + id).val();

                $('#' + id).text(newContent);
                $('#' + id).parent().removeClass("cellEditing");

                var bhID = $('#bid').val();
                var term = $('#sem').val();
                var sy = $('#sy').val();

                var nxt = parseInt(1) + parseInt(tdn);
                getNext(nxt);


                var dataString2 = 'studentID=' + ID + '&rate=' + newContent + '&bhid=' + bhID + '&term=' + term + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'gradingsystem/saveBHRate' ?>",
                    dataType: 'json',
                    data: dataString2,
                    cache: false,
                    success: function (data) {
                        $('#success').html(data.msg);
                        $('#alert-info').fadeOut(5000);

                        var nxt = parseInt(1) + parseInt(tdn);
                        getNext(nxt)
                    }
                });
            }
        });

        $('#' + id).children().first().blur(function () {
            $('#' + id).text(OriginalContent);
            $('#' + id).parent().removeClass("cellEditing");
        });
    }
</script>
<?php
echo Modules::run('templates/html_footer');
