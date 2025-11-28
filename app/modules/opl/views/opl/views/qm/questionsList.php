<style>
    .questionsList td li{
        list-style: none;
    }
</style>

<section id="questionsList" class="col-lg-6 col-xs-12 float-left">
    <div class="card card-red card-outline">
        <div class="card-header">
            List of Questions
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm table-stripe">
                <tr>
                    <th style="width:20px; text-align: center;">#</th>
                    <th class="col-lg-8">Question</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Action</th>
                </tr>
                <?php
                $r=1;
                    foreach($questions as $q):
                ?>
                <tr class="questionsList" id="tr_<?php echo $q->sys_code ?>">
                    <td><?php echo $r++ ?></td>
                    <td><?php echo substr($q->question,0,50).'...' ?></td>
                    <td class="text-center"><?php echo $q->qm_type ?></td>
                    <th class="text-center">
                        <button class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                        <button onclick="deleteQuestion('<?php echo $q->sys_code ?>')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                    </th>
                </tr>
                
                <?php        
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</section>
<section class="col-lg-6 col-xs-12 float-left">
    <div class="card card-blue card-outline">
        <div class="card-header">
            List of Quizzes
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm table-stripe">
                <tr>
                    <th>#</th>
                    <th class="col-lg-6">Quiz Title</th>
                    <th class="text-center">Number of Items</th>
                    <th class="text-center">Action</th>
                </tr>
                <?php 
                    $i = 1;
                    $quizes = Modules::run('opl/qm/getAllQuizzes', $this->session->username, $this->session->school_year);
                    foreach($quizes as $q):
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td class="pointer"><?php echo $q->qi_title; ?></td>
                    <td class="text-center"><?php echo count(explode(',', $q->qi_qq_ids)); ?></td>
                    <td class="text-center">
                        <button onclick="document.location='<?php echo base_url('opl/qm/quizDetails/'.$q->qi_sys_code.'/'.$school_year); ?>'" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                        <button onclick="deleteQuiz('<?php echo $q->qi_sys_code ?>')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </table>    
        </div>
    </div>
</section>

<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<script type="text/javascript">
    
    $(document).ready(function(){
        
        deleteQuiz = function (sys_code) {
            var base = $('#base').val();
            var url = base + 'opl/qm/deleteQuiz';
            
            var con = confirm('Are you sure you want to delete this Assessment, please note that you cannot undo the process');
            if(con===true)
            {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        school_year : $('#school_year').val(),
                        quizCode    : sys_code,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    }, // serializes the form's elements.
                    //dataType: 'json',
                    beforeSend: function () {
                        $('#loadingModal').modal('show');
                    },
                    success: function (data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        };
        
        deleteQuestion = function (sys_code) {
            var base = $('#base').val();
            var url = base + 'opl/qm/deleteQuestion';
            
            var con = confirm('Are you sure you want to delete this question, please note that you cannot undo the process');
            if(con===true)
            {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        school_year : $('#school_year').val(),
                        sys_code: sys_code,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    }, // serializes the form's elements.
                    //dataType: 'json',
                    beforeSend: function () {
                        $('#loadingModal').modal('show');
                    },
                    success: function (data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        };
    });
    
</script>    