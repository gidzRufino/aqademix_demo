<div style="margin-top: 15px;">
    <h5 class="pull-left">Extra Curricular</h5>
    <button onclick="saveCoCurricular($('#student_id').html(),<?php echo $this->session->userdata('school_year') ?>,$('#cc_1').val(),$('#cc_2').val(),$('#cc_3').val(),$('#cc_4').val())" class="pull-right btn btn-small btn-success"> Save</button>
    <br />
    <hr>
    <?php
        switch ($term):
            case 4:
            $cc_first = Modules::run('gradingsystem/co_curricular/getCoCurricular', $this->uri->segment(3), 1);
            $cc_second = Modules::run('gradingsystem/co_curricular/getCoCurricular', $this->uri->segment(3), 2);
            $cc_third = Modules::run('gradingsystem/co_curricular/getCoCurricular', $this->uri->segment(3), 3);
            $cc_fourth = Modules::run('gradingsystem/co_curricular/getCoCurricular', $this->uri->segment(3), 4);
        ?>
    <table class="table table-bordered">
        <tr>
            <td class="text-center" colspan="2">Activities</td>
            <td class="text-center">Rating</td>
        </tr>
        <tr>
            <td class="text-center">FIRST</td>
            <td>True Love Waits, Savings Day/Time Capsule, Know Your School/Safe Kids Week, Think.Eat.Save., SSC Election, Intl. Youth Day, Clown Day, Nutrition Days</td>
            <td term="1" class="editable text-center"><?php echo $cc_first->rate ?></td>
            <input type="hidden" id="cc_1" value="<?php echo $cc_first->rate ?>" />
        </tr>
        <tr>
            <td class="text-center">SECOND</td>
            <td>Linggo ng Wika, Intl. Youth Day, Academy Days, Geek Day, Hall of Curiousity, BGB Joint Enrollment Service, BGB Day</td>
            <td term="2" class="editable text-center"><?php echo $cc_second->rate ?></td>
            <input type="hidden" id="cc_2" value="<?php echo $cc_second->rate ?>" />
        </tr>
        <tr>
            <td class="text-center">THIRD</td>
            <td>Children’s Month, School-in-the-park, Not for Sale, Coffee House, Moustache and Braids Day, Sharity, Christmas Party, Choral Competition, Year-End Collection</td>
            <td term="3" class="editable text-center"><?php echo $cc_third->rate; ?></td>
            <input type="hidden" id="cc_3" value="<?php echo $cc_third->rate ?>" />
        </tr>
        <tr>
            <td class="text-center">FOURTH</td>
            <td>Pink Shirt Day, School Field Trip, School Camp, Book Fair/Trade Fair, Teacher’s Day/ Outrageous Slippers Day, Family Day, Dear Next Year’s Class/Career Day, Music Recital, Tribute to Seniors/1920’s Day, BGB Awarding, Behavioral Awarding</td>
            <td term="4" class="editable text-center"><?php echo $cc_fourth->rate ?></td>
            <input type="hidden" id="cc_4" value="<?php echo $cc_fourth->rate ?>" />
        </tr>
    </table>
        <?php
            break;
        endswitch;
    ?>
</div>

<script type="text/javascript">
   $(function () { 
$(".editable").dblclick(function () 
{   
    var OriginalContent = $(this).text(); 
    var st_id = '<?php echo $st_id ?>'
    var term = $(this).attr('term');
    $(this).addClass("cellEditing"); 
    $(this).html("<input type='text' id='cc_"+term+"' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
   
}); 
});

function saveCoCurricular(st_id, school_year, first, second, third, fourth)
{
       if(first=='undefined'){
           first = $('#cc_1').val();
       }
       if(second=='undefined'){
           second = $('#cc_2').val();
       }
       if(third=='undefined'){
           third = $('#cc_3').val();
       }
       if(fourth=='undefined'){
           fourth = $('#cc_4').val();
       }
   
       var answer = confirm("Is this the Final Rating? The result will be the printed result. Warning: You cannot undo this action.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/co_curricular/saveCoCurricular/'?>"
           $.ajax({
            type: "POST",
            url: url,
            data: 'st_id='+st_id+'&school_year='+school_year+'&cc_1='+first+'&cc_2='+second+'&cc_3='+third+'&cc_4='+fourth+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {
               console.log(data)
            }
          });
        }else{
           $('#'+subject_id).html('no Final Grade Yet')
           return FALSE
        }




}
</script>