<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top:5px; margin-bottom: 5px;">Generate DepEd Form 137 - A
            <div class="form-group pull-right" style="margin-right:20px;font-size: 15px;">
                <div class="controls" id="AddedSection">
                    <a href="#form137Settings" data-toggle="modal">
                        <i title="settings" data-toggle="tooltip" data-placement="top"  class="fa fa-cog fa-2x pull-right pointer tip-top"></i>
                    </a>
                    <a href="#downloadSection" data-toggle="modal" class="text-danger">
                        <i title="Download Form 137 Template for Bulk Upload" data-toggle="tooltip" data-placement="top"  class="fa fa-download fa-2x pull-right pointer tip-top"></i>
                    </a>
                    <a href="#uploadF137" data-toggle="modal" class="text-success">
                        <i title="Upload Form 137" data-toggle="tooltip" data-placement="top"  class="fa fa-upload fa-2x pull-right pointer tip-top"></i>
                    </a>
                    <a class="text-warning" onclick="document.location = '<?php echo base_url('sf10/getNewInfo') ?>'">
                        <i title="Add a new record" data-toggle="tooltip" data-placement="top"  class="fa fa-plus fa-2x pull-right pointer tip-top"></i>
                    </a>
                </div>
            </div>
        </h3>
        <input type="hidden" id="csrf_cookie_name" value />

    </div>
</div>
<div class="col-lg-12" id="searchStudent">
    <div class="col-lg-2"></div>
    <div class="input-group col-lg-8">
        <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
        <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none; top:50px" class="resultOverflow" id="searchName">

        </div>
        <div class="input-group-btn">
            <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (segment_6 == '' ? $this->session->school_year : segment_6) . ' - ' . ((segment_6 == '' ? $this->session->school_year : segment_6) + 1) ?> <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php
                $ro_years = Modules::run('install/spr_records/databaseList');
                $settings = $this->eskwela->getSet();
                $numString = strlen($settings->short_name) + 8;
                foreach ($ro_years as $ro) {
                    if ("eskwela_" . strtolower($settings->short_name) == substr($ro, 0, $numString)) {
                        ?>
                        <li onclick="$('#btnControl').html('<?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?>  <span class=\'caret\'></span>'), $('#inputSchoolYear').val('<?php echo substr($ro, $numString + 1, $numString + 5) ?>')"><a href="#"><?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <input type="hidden" id="inputSchoolYear" value="<?php echo $this->session->school_year ?>" />
        </div><!-- /btn-group -->
    </div>
</div>
<div id="generatedResult" class="row">

</div>
<?php
$subject['subject'] = $subjects;
$this->load->view('inputManually', $subject)
?>    

<div id="downloadSection" class="modal fade" style="width:20%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Use this file for Academic Grades Only
        </div>
        <div class="panel-body">
            <div class="form-group" id="soaSectionWrapper">
                <?php
                $section = Modules::run('registrar/getAllSection');
                ?>
                <label>Select Section</label>
                <select id="soaSection" style="width:100%;">
                    <?php
                    foreach ($section->result() as $sec):
                        if ($sec->grade_id <= 13):
                            ?>
                            <option value="<?php echo $sec->section_id ?>"><?php echo strtoupper($sec->level . ' - ' . $sec->section) ?></option>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>
            <a href='#'data-dismiss='modal' onclick='downloadSection($("#soaSection").val())' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Generate</a>
        </div>
    </div>
</div>

<div id="uploadF137" class="modal fade" style="width:25%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Use this for bulk upload
        </div>
        <div class="panel-body">
            <?php
            $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
            echo form_open_multipart(base_url() . 'sf10/uploadF137', $attributes);
            ?>
            <!--             <div class="form-group">
                             <label>Select Option</label>
                             <select id="uploadOption" name="uploadOption">
                                 <option>Select Option</option>
                                 <option value="0">Academics</option>
                                 <option value="1">Attendance Record</option>
                             </select>
                         </div>-->
            <h5 id="myModalLabel">School Year:</h5> 
            <input type="text" onblur="checkDB(this.value)" id="uploadSchoolYear" class="form-control" name="uploadSchoolYear" placeholder="Please Enter School Year" />
            <input type="hidden" value="0" id="uploadOption" name="uploadOption" />
            <h5 id="myModalLabel">Upload an Excel File</h5> 
            <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
            <br />
            <hr />
            <input type="submit" id="uploadBtn" value="upload" class="btn btn-info pull-right disabled"/>

            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
        $("#inputMonthForm137").select2();
        $("#inputStudent").select2();
        $("#inputSubject").select2();
        $("#soaSection").select2();
        $(".tip-top").tooltip();

        // alert($.cookie('csrf_cookie_name'))
    });

    function checkDB(year)
    {
        if (year != '') {
            if (year.length != 4 || isNaN(year)) {
                alert('Please enter a valid year');
            } else {
                var url = '<?php echo base_url() . 'install/spr_records/create_database/' ?>' + year;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: "id=" + year, // serializes the form's elements.
                    dataType: 'json',
                    success: function (data)
                    {
                        if (data.status) {
                            $('#uploadBtn').removeClass('disabled');
                        }

                    }
                });

                return false;
            }
        } else {
            alert('Please input School Year');
        }
    }

    function downloadSection(section)
    {
        var url = '<?php echo base_url() . 'sf10/exportStudentListToExcell/' ?>' + section;
        document.location = url;
    }

    function loadStudentDetails(st_id, status, year)
    {
        var url = '<?php echo base_url() . 'sf10/getPersonalInfo/' ?>' + st_id + '/' + status + '/' + year;
//        alert(url);
        document.location = url;
    }

    function search(value)
    {
        var sy = $('#inputSchoolYear').val();
        var url = '<?php echo base_url() . 'sf10/searchStudent/' ?>' + value + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#searchName').show();
                $('#searchName').html(data);
            }
        });

        return false;
    }

    function generateForm(st_id)
    {

        var url = "<?php echo base_url() . 'sf10/generateF137/' ?>" + st_id;
        $.ajax({
            type: "GET",
            url: url,
            data: 'qcode=' + st_id, // serializes the form's elements.
            success: function (data)
            {
                $('#generatedResult').html(data)

            }
        });
    }

    function saveNumberOfDays()
    {
        var url = "<?php echo base_url() . 'sf10/saveSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val() + '&month=' + $('#inputMonthForm137').val() + "&numOfSchoolDays=" + $('#numOfSchoolDays').val(), // serializes the form's elements.
            success: function (data)
            {
                $('#sd_' + data.month).html(data.days);
            }
        });
    }

    function getSchoolDays(value)
    {
        var url = "<?php echo base_url() . 'sf10/getSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val(),
            success: function (data)
            {
                $('#tableDays').html(data);
            }
        })
    }

    function getDaysPresent(value)
    {
        var url = "<?php echo base_url() . 'sf10/getDaysPresentModal/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&spr_id=' + $('#spr_id').val(),
            success: function (data)
            {
                $('#daysPresentResult').html(data);
            }
        });
    }

    function deleteSPRecord()
    {
        var url = "<?php echo base_url() . 'sf10/deleteSPRecords/' ?>" + $('#spr_id').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }

    function deleteSingleRecord(id)
    {
        var url = "<?php echo base_url() . 'sf10/deleteSingleRecord/' ?>" + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }

</script>
