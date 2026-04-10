<?php 
    if($this->session->isOplAdmin || strcmp($this->session->position, "Grade School Principal") == 0 || strcmp($this->session->position, "High School Principal") == 0):
        echo Modules::run('opl/opl_widgets/getAdminListOfClasses');
    elseif($this->session->isParent):
        echo Modules::run('opl/p/myChildren');
    else:
?>
<div class="card">
    <div class="card-header text-center">
        <span>My Classes</span>
        <span><i class="fa fa-search float-right fa-xs mt-2" style="cursor: pointer;" onclick="readySearch(this)"></i></span>
    </div>
    <div class="card-body" id="subjectListMain">
        <div class="list-group">
         <?php
                foreach ($getAssignment as $ga)
                {   
            ?><a class="list-group-item list-group-item-action search-list" subject="<?php echo $ga->subject; ?>" college="0" href="<?php echo base_url();?>opl/classBulletin/<?php echo $this->session->school_year?>/NULL/<?php echo $ga->grade_id;?>/<?php echo $ga->section_id;?>/<?php echo $ga->subject_id;?>">
                        <span style="color:#BB0000;">
                            <?php 
                            if($ga->specs_id==0):
                                echo $ga->subject; ?>&nbsp;-&nbsp;<?php echo $ga->level;?>&nbsp;[&nbsp;<?php echo $ga->section; ?>&nbsp;]
                            <?php 
                            else:
                                echo $ga->specialization; ?>&nbsp;-&nbsp;<?php echo $ga->level;?>
                            <?php endif; ?>
                        </span>
                        <!--<span class="badge badge-danger right float-right">2</span>-->  
                    </a>  
                    
            <?php } ?>
        </div>
         <?php
            $collegeAssignment = Modules::run('opl/college/getTeacherAssignment', $this->session->username, Modules::run('main/getSemester'), $this->session->school_year);
            //print_r($collegeAssignment);
                if($collegeAssignment):
                    ?>
                <div class="list-group">
                    <label class="text-center">College</label>
                    <?php
                    foreach ($collegeAssignment as $ga)
                    {   
                        ?><a class="list-group-item list-group-item-action search-list" subject="<?php echo $ga->s_desc_title ?>" college="1" href="<?php echo base_url('opl/college/classBulletin/'.$ga->sec_sub_id.'/'.$ga->sec_id.'/'.$ga->sec_sem.'/'.$this->session->school_year);?>">
                                <span style="color:#BB0000;">
                                    <?php 
                                        echo $ga->s_desc_title.' [ '.$ga->sub_code .' ]';
                                     ?>
                                </span>  
                                <!--<span class="badge badge-danger right float-right">2</span>-->  
                            </a>  

                    <?php 
                    
                    } 
                    ?>
                    
                </div>
                <?php    
                endif;
                ?>
    </div>
    <div class="card-body" id="subjectListSearch"></div>
</div>
<script>
    $(document).ready(function(){
        $("#subjectListSearch").hide();
    });
    
    function readySearch(btn){
        $(btn).parent().prev().html("<input type='text' class='w-75' placeholder='Type subject...' onkeypress='if(event.which == 13) searchSubjects(this.value)' />");
    }
    
    function searchSubjects(value)
    {
        if(value.length !== 0){
            var subjects = $(".search-list").filter(function(){
                return $(this).attr('subject').toLowerCase().indexOf(value.toLowerCase()) > -1;
            });
            var html = '',
                lowhtml = "<div class='list-group'>",
                colhtml = "<div class='list-group'><label class='text-center'>College</label>",
                low = 0,
                col = 0;
            $.each(subjects, function (idx, val){
                if($(val).attr('college') === '0')
                {
                    low++;
                    lowhtml += "<a class='list-group-item list-group-item-action' href='"+$(val).attr('href')+"'>"+$(val).html()+"</a>";
                }else{
                    col++;
                    colhtml += "<a class='list-group-item list-group-item-action' href='"+$(val).attr('href')+"'>"+$(val).html()+"</a>";
                }
            });
            colhtml += "</div>";
            lowhtml += "</div>";
            if(low !== 0){
                html += lowhtml;
            }else{
                html += "<p class='text-center'>No such subject found</p>";
            }
            if(col !== 0){
                html += colhtml;
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
<?php endif; ?>