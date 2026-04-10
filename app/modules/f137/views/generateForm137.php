<div class="container-fluid py-3">

    <!-- HEADER CARD -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="fw-bold mb-0">
                    Generate DepEd Form 137 - A
                </h3>

                <div class="d-flex gap-3 fs-4">

                    <a href="#" data-bs-toggle="modal" data-bs-target="#form137Settings">
                        <i class="fa fa-cog pointer tip-top" title="Settings"></i>
                    </a>

                    <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#downloadSection">
                        <i class="fa fa-download pointer tip-top"
                            title="Download Form 137 Template for Bulk Upload"></i>
                    </a>

                    <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#uploadF137">
                        <i class="fa fa-upload pointer tip-top"
                            title="Upload Form 137"></i>
                    </a>

                    <a class="text-warning"
                        onclick="document.location = '<?php echo base_url('sf10/getNewInfo') ?>'">
                        <i class="fa fa-plus pointer tip-top" title="Add a new record"></i>
                    </a>

                </div>
            </div>

            <input type="hidden" id="csrf_cookie_name" value />

        </div>
    </div>


    <!-- SEARCH CARD -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="input-group input-group-lg">

                        <input onkeyup="search(this.value)"
                            id="searchBox"
                            class="form-control"
                            type="text"
                            placeholder="Search Name Here" />

                        <button class="btn btn-outline-secondary dropdown-toggle"
                            type="button"
                            id="btnControl"
                            data-bs-toggle="dropdown">
                            <?php echo ($sy == '' ? $this->session->school_year : $sy) . ' - ' . (($sy == '' ? $this->session->school_year : $sy) + 1) ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            $ro_years = Modules::run('install/spr_records/databaseList');
                            $settings = $this->eskwela->getSet();
                            $numString = strlen($settings->short_name) + 8;

                            foreach ($ro_years as $ro) {
                                if ("aqademix_" . strtolower($settings->short_name) == substr($ro, 0, $numString)) {
                            ?>
                                    <li>
                                        <a class="dropdown-item"
                                            href="#"
                                            onclick="$('#btnControl').html('<?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?>'), $('#inputSchoolYear').val('<?php echo substr($ro, $numString + 1, $numString + 5) ?>')">
                                            <?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?>
                                        </a>
                                    </li>
                            <?php }
                            } ?>
                        </ul>

                        <input type="hidden"
                            id="inputSchoolYear"
                            value="<?php echo $this->session->school_year ?>" />
                    </div>

                    <!-- SEARCH RESULT -->
                    <div id="searchName"
                        class="border rounded shadow-sm bg-white mt-2 p-2 d-none"
                        style="z-index:1000; position:relative;">
                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- RESULT AREA -->
    <div id="generatedResult" class="row"></div>

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
            <a href='#' data-dismiss='modal' onclick='downloadSection($("#soaSection").val())' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Generate</a>
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
            <input type="submit" id="uploadBtn" value="upload" class="btn btn-info pull-right disabled" />

            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        $("#inputMonthForm137, #inputStudent, #inputSubject, #soaSection").select2();

        // Bootstrap 5 tooltip init
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tip-top'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

    });

    $(document).on('click', '.student-item', function() {
        $('#searchName').addClass('d-none'); // Bootstrap 5 hide
        $('#searchBox').val($(this).data('name'));

        loadStudentDetails(
            $(this).data('id'),
            $(this).data('status'),
            $(this).data('year'),
            $(this).data('grade')
        );
    });


    function checkDB(year) {
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
                    success: function(data) {
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

    function downloadSection(section) {
        var url = '<?php echo base_url() . 'sf10/exportStudentListToExcell/' ?>' + section;
        document.location = url;
    }

    function loadStudentDetails(st_id, status, year, level) {
        var url = '<?php echo base_url() . 'f137/getPersonalInfo/' ?>' + st_id + '/' + status + '/' + year + '/' + level;
        //        alert(url);

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + st_id,
            success: function(data) {
                $('#generatedResult').html(data);
            }
        })
    }

    function search(value) {
        var sy = $('#inputSchoolYear').val();
        var url = '<?php echo base_url() . 'f137/searchStudent/' ?>' + value + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                $('#searchName').removeClass('d-none').html(data);
            }
        });

        return false;
    }

    function generateForm(st_id) {

        var url = "<?php echo base_url() . 'sf10/generateF137/' ?>" + st_id;
        $.ajax({
            type: "GET",
            url: url,
            data: 'qcode=' + st_id, // serializes the form's elements.
            success: function(data) {
                $('#generatedResult').html(data)

            }
        });
    }

    function saveNumberOfDays() {
        var url = "<?php echo base_url() . 'sf10/saveSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val() + '&month=' + $('#inputMonthForm137').val() + "&numOfSchoolDays=" + $('#numOfSchoolDays').val(), // serializes the form's elements.
            success: function(data) {
                $('#sd_' + data.month).html(data.days);
            }
        });
    }

    function getSchoolDays(value) {
        var url = "<?php echo base_url() . 'sf10/getSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val(),
            success: function(data) {
                $('#tableDays').html(data);
            }
        })
    }

    function getDaysPresent(value) {
        var url = "<?php echo base_url() . 'sf10/getDaysPresentModal/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&spr_id=' + $('#spr_id').val(),
            success: function(data) {
                $('#daysPresentResult').html(data);
            }
        });
    }

    function deleteSPRecord() {
        var url = "<?php echo base_url() . 'sf10/deleteSPRecords/' ?>" + $('#spr_id').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }

    function deleteSingleRecord(id) {
        var url = "<?php echo base_url() . 'sf10/deleteSingleRecord/' ?>" + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }
</script>

<style>
    .student-hover {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .student-hover:hover {
        background-color: #f8f9fa;
        transform: translateX(4px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }
</style>