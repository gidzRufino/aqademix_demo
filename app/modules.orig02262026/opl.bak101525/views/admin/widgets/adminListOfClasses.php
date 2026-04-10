<div class="card">
    <div class="card-header text-center">
        <span>List of Section</span>
        <span><i class="fa fa-search float-right fa-xs mt-2" style="cursor: pointer;" onclick="readySearch(this)"></i></span>
    </div>
    <div class="card-body" id="subjectListMain">
        <div class="list-group">
            <?php
                $sections = Modules::run('registrar/getAllSection');
                
                foreach ($sections->result() as $section):
                    $totalStudents = Modules::run('registrar/getNumberOfStudentPerSection',$section->section_id, $this->session->school_year, 1);
                ?>
                <a class="list-group-item list-group-item-action search-list" subject="<?php echo $section->level; ?>" href="<?php echo base_url();?>opl/sectionDashboardForAdmin/<?php echo $section->grade_id;?>/<?php echo $section->section_id;?>/<?php echo $this->session->school_year ?>">
                        <span style="color:#BB0000;">
                            <?php echo $section->level;?>&nbsp;[&nbsp;<?php echo $section->section; ?>&nbsp;]
                        </span>
                        <span class="badge badge-danger right float-right"><?php echo $totalStudents ?></span>  
                    </a>  
            <?php
                endforeach;
            ?>
            
        </div>
    </div>
    <div class="card-body" id="subjectListSearch"></div>
</div>
<script>
    $(document).ready(function(){
        $("#subjectListSearch").hide();
    });
    
    function readySearch(btn){
        $(btn).parent().prev().html("<input type='text' class='w-75' placeholder='Type Grade Level...' onkeypress='if(event.which == 13) searchSubjects(this.value)' />");
    }
    
    function searchSubjects(value)
    {
        if(value.length !== 0){
            var subjects = $(".search-list").filter(function(){
                return $(this).attr('subject').toLowerCase().indexOf(value.toLowerCase()) > -1;
            });
            var html = '',
                lowhtml = "<div class='list-group'>",
                low = 0;
            $.each(subjects, function (idx, val){
                low++;
                lowhtml += "<a class='list-group-item list-group-item-action' href='"+$(val).attr('href')+"'>"+$(val).html()+"</a>";
            });
            lowhtml += "</div>";
            if(low !== 0){
                html += lowhtml;
            }else{
                html += "<p class='text-center'>No such subject found</p>";
            }
            $("#subjectListSearch").html(html);
            $("#subjectListMain").hide();
            $("#subjectListSearch").show();
        }else{
            $("#subjectListSearch").html('');
            $("#subjectListMain").show();
            $("#subjectListSearch").hide();
        }
    }
</script>