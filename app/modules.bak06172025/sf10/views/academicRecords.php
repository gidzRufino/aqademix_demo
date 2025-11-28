<br/>
<span class="badge badge-pill badge-light nowrap clickover pointer pull-right" style="background-color: green; cursor: pointer" onclick="printForm(<?php echo $gsYR ?>, $('#strand-id').val())">
    <i style="font-size:15px;" class="fa fa-book"></i> Generate Records
</span>

<div id="recordsTbl">

</div>


<div class="modal fade" id="uRecord" tabindex="-1" role="dialog" aria-labelledby="uRecord" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix">
                Subject: <span id="eSubj"></span>
                <a href="#" data-dismiss="modal">
                    <i class="pull-right fa fa-close pointer"></i>
                </a>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="text-align: center">1st Quarter</th>
                        <th style="text-align: center">2nd Quarter</th>
                        <th style="text-align: center">3rd Quarter</th>
                        <th style="text-align: center">4th Quarter</th>
                    </tr>
                    <tr>
                        <td style="text-align: center" id="sFirst" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sSecond" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sThird" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sFourth" contenteditable="true">

                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-small" data-dismiss="modal" onclick="updateRec()">Update</button>
                <button class="btn btn-danger btn-small" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="school_year" value="<?php echo $gsYR ?>" />
<input type="hidden" id="arID" />
<input type="hidden" id="subID" />

<?php
function levelDesc($gradeID) {
    switch ($gradeID):
        case 1:
            return 'Kinder';
        case 2:
            return 'Grade 1';
        case 3:
            return 'Grade 2';
        case 4:
            return 'Grade 3';
        case 5:
            return 'Grade 4';
        case 6:
            return 'Grade 5';
        case 7:
            return 'Grade 6';
        case 8:
            return 'Grade 7';
        case 9:
            return 'Grade 8';
        case 10:
            return 'Grade 9';
        case 11:
            return 'Grade 10';
        case 12:
            return 'Grade 11';
        case 13:
            return 'Grade 12';
    endswitch;
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    });

    function updateRec() {
        var spr_id = $('#getSPR').val();
        var subj_id = $('#subID').val();
        var ar_id = $('#arID').val();
        var first = $('#sFirst').text();
        var second = $('#sSecond').text();
        var third = $('#sThird').text();
        var fourth = $('#sFourth').text();
        var sy = $('#sy').val();
        //alert(spr_id + ' ' + ' ' + subj_id + ' ' + ar_id + ' ' + first + ' ' + second + ' ' + third + ' ' + fourth + ' ' + sy);

        var url = '<?php echo base_url() . 'sf10/updateSPRrecord/' ?>' + spr_id + '/' + subj_id + '/' + ar_id + '/' + first + '/' + second + '/' + third + '/' + fourth + '/' + sy;

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + ar_id,
            success: function (data) {
                //window.location.reload();
            },
            error: function (data) {

            }
        });
    }

    function delRec(sprid, sy) {
        alert(sprid + ' ' + sy);
    }

</script>