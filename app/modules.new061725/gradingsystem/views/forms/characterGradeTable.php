<div class="row">
    <div class="span12"> 
        <?php
        $Students = Modules::run('registrar/getAllStudentsForExternal', $level->grade_level_id, $section, NULL, 1, $sy);
        ?>
        <table id="tableResult"  class="editableTable table table-striped table-bordered"> 

            <tr> 
                <td class="col-lg-4">Students</td> 
                <td style="text-align:center;">Character Grade

                </td> 
            </tr> 
            <?php
            $n = 0;
            foreach ($Students->result() as $st) {
                $chGrade = Modules::run('gradingsystem/getChGrade', $st->st_id, $subject);
                switch ($term):
                    case 1:
                        $ga = $chGrade->first_cg;
                        break;
                    case 2:
                        $ga = $chGrade->second_cg;
                        break;
                    case 3:
                        $ga = $chGrade->third_cg;
                        break;
                    case 4:
                        $ga = $chGrade->fourth_cg;
                        break;
                endswitch;
                $n++;
                ?>
                <tr > 
                    <td style="font-size:14px;" id=""><?php echo $st->st_id . ' ' . strtoupper($st->lastname . ', ' . $st->firstname) ?></td> 
                    <td tdn="<?php echo $st->st_id ?>" class="editable" style="font-size:14px; text-align: center" id="<?php echo $n; ?>">
                        <?php echo $ga ?>
                    </td>
                </tr> 
                <?php
            }
            ?>

        </table>
    </div>
</div>
<input type="hidden" id="isValidated" />

<script type="text/javascript">
    $(function () {
        $(".editable").dblclick(function ()
        {
            var altLockBtnLabel = $('#altLockBtnLabel').val();
            var OriginalContent = $(this).text();
            var ID = $(this).attr('tdn');
            var tdn = $(this).attr('id');
            var sub_id = '<?php echo $subject ?>';
            var term = '<?php echo $term ?>';
            var sy = '<?php echo $sy ?>';

            $(this).addClass("cellEditing");
            $(this).html("<input  type='text' style='height:30px; text-align:center' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function (e)
            {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    if (isNaN(newContent)) {
                        var ch = newContent.toUpperCase();
                        if (ch == 'A' || ch == 'A-' || ch == 'B' || ch == 'B-' || ch == 'C' || ch == 'D') {
                            var dataString = 'char=' + ch + "&st_id=" + ID + "&subj_id=" + sub_id + "&term=" + term + "&sy=" + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name')
                            $(this).parent().text(ch);
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url() . 'gradingsystem/recordChGrade' ?>",
                                data: dataString,
                                cache: false,
                                success: function (data) {
                                    var nxt = parseInt(1) + parseInt(tdn);
                                    getNext(nxt)
                                },
                                error: function (data) {
                                    alert('test')
                                }
                            });
                        } else {
                            alert('Invalid Input');
                            $(this).parent().text('');
                        }
                    } else {
                        alert('Invalid Input');
                        $(this).parent().text('');
                    }
                }
            });

            $(this).children().first().blur(function () {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });
    });

    function getNext(id)
    {
        var ID = $('#' + id).attr('tdn');
        var tdn = $('#' + id).attr('id');
        var sub_id = '<?php echo $subject ?>';
        var term = '<?php echo $term ?>';
        var sy = '<?php echo $sy ?>';

        var OriginalContent = $('#' + id).text();
        $('#' + id).addClass("cellEditing");
        $('#' + id).html("<input id ='input_" + tdn + "'type='text' style='height:30px; text-align:center' />");
        $('#' + id).children().first().focus();
        $('#' + id).children().first().keypress(function (e)
        {
            if (e.which == 13) {
                var newContent = $(this).val();
                if (isNaN(newContent)) {
                    var ch = newContent.toUpperCase();
                    if (ch == 'A' || ch == 'A-' || ch == 'B' || ch == 'B-' || ch == 'C' || ch == 'D') {
                        var dataString = 'char=' + ch + "&st_id=" + ID + "&subj_id=" + sub_id + "&term=" + term + "&sy=" + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name')
                        $(this).parent().text(ch);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'gradingsystem/recordChGrade' ?>",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                var nxt = parseInt(1) + parseInt(tdn);
                                getNext(nxt)
                            },
                            error: function (data) {
                                alert('test')
                            }
                        });
                    } else {
                        alert('Invalid Input');
                        $(this).parent().text('');
                    }
                } else {
                    alert('Invalid Input');
                    $(this).parent().text('');
                }
            }
        });

        $('#' + id).children().first().blur(function () {
            $('#' + id).text(OriginalContent);
            $('#' + id).parent().removeClass("cellEditing");
        });
    }
</script>

