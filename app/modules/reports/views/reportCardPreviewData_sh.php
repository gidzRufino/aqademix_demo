<?php
    switch ($term){
        case 1:
        case 2:
            $sem = 1;
//                    $term = 'First';
            $one = '1';
            $two = '2';
        break;
        case 3:
        case 4:
            $sem = 2;
//                    $term = 'Second';
            $one = '3';
            $two = '4';
        break;
   }
?>           
<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="6" class="text-center">ACADEMIC</th>
        </tr>
        <tr class="quarterTitle">
            <th style="width:20%;">SUBJECT</th>
            <?php if($sem==1): ?>
            <th class="text-center" style="width:15%;">FIRST</th>
            <th class="text-center" style="width:15%;">SECOND</th>
            <?php else: ?>
            <th class="text-center" style="width:15%;">THIRD</th>
            <th class="text-center" style="width:15%;">FOURTH</th>
            <?php endif; ?>
            <th class="text-center" style="width:15%;">FINAL</th>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #b6d9ef;" colspan="5">Core Subjects</td>
        </tr>
    </thead>
    <tbody>
        <?php
        //$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
        $gs_settings = Modules::run('gradingsystem/getSet', $sy);
        $coreSubs = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, $sem, $this->uri->segment(6), 1);
        
        $i=0;
        foreach($coreSubs as $cs):
            $i++;
            $singleSub = Modules::run('academic/getSpecificSubjects', $cs->sh_sub_id);
            $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->uid, $cs->sh_sub_id, $sy));
            
            $first = $grade->first;
            $second = $grade->second;
            $third = $grade->third;
            $fourth = $grade->fourth;
            $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $cs->sub_id, $term, $sy);
            
        ?>
        
        <tr class="data">
            <td><?php echo $singleSub->subject ?></td>
            <?php if($sem==1): ?>
                <td class="text-center text-strong value"><?php echo ($first==""? 0 : $first) ?></td>
                <td class="text-center text-strong value"><?php echo ($second=="" ? 0 : $second) ?></td>
            <?php else: ?>
            <td class="text-center text-strong value"><?php echo ($third=="" ? 0 : $third) ?></td>
            <td class="text-center text-strong value"><?php echo ($fourth=="" ? 0 : $fourth) ?></td>
            <?php endif; ?>
            <td class="text-center"><strong class="sum"></td>
        </tr>
        <?php
        endforeach;  
        ?>
        
        <tr>
            <td style="font-weight: bold; background: #b6d9ef;" colspan="5">Applied and Specialized Subjects</td>
        </tr>
        <?php
        $appliedSubs = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, $sem, $this->uri->segment(6));
        
        $i=0;
        foreach($appliedSubs as $as):
            $i++;
            $singleSub = Modules::run('academic/getSpecificSubjects', $as->sh_sub_id);
            $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->uid, $as->sh_sub_id, $sy));
            
            $first = $grade->first;
            $second = $grade->second;
            $third = $grade->third;
            $fourth = $grade->fourth;
            $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $cs->sub_id, $term, $sy);
            
        ?>
        
        <tr class="data">
            <td><?php echo $singleSub->subject ?></td>
            <?php if($sem==1): ?>
            <td class="text-center text-strong value"><?php echo ($first==""? 0 : $first) ?></td>
            <td class="text-center text-strong value"><?php echo ($second=="" ? 0 : $second) ?></td>
            <?php else: ?>
            <td class="text-center text-strong value"><?php echo ($third=="" ? 0 : $third) ?></td>
            <td class="text-center text-strong value"><?php echo ($fourth=="" ? 0 : $fourth) ?></td>
            <?php endif; ?>
            <td class="text-center"><strong class="sum"></td>
        </tr>
        <?php
        endforeach; 
        ?>
    </tbody>
    
</table>

<script type="text/javascript">
        $(document).ready(function()
       {
           var genAve = 0;
           var totalRows = $('table tr.data').length;
           $('table tr.data').each(function(i){
              var total = 0;
              $(this).find('.value').each(function(){
                  
                  var value = $(this).html();
                  if (!isNaN(value))
                  {
                       total += parseFloat(value);
                  }else{
                      value  = 0;
                      total += parseFloat(value);
                  }
                  
              });
              
              var final = (total/2).toFixed(2);
              if(final<75)
              {
                  $('.sum').eq(i).addClass('text-danger');
              }else{
                  $('.sum').eq(i).addClass('text-success');
              }
              
                  $('.sum').eq(i).text(final);
              genAve += final/totalRows;
           });
           
//            $('table .quarterTitle th:not(:first, :last)').each(function(index){
//                    calculateColumn(index);
//            });
           
           $('#generalAve').text(genAve.toFixed(3))
       });
       
        function calculateColumn(index)
        {
            var totalRows = $('table tr.data').length;
            var total = 0;
            $('table tr.data').each(function()
            {
                var value = parseFloat($('td.value', this).eq(index).html());
                //console.log(value);
                if (!isNaN(value))
                {   
                   // console.log(value);
                    total += value;
                    //alert(total)
                }
            });

            $('.quarterTotal').eq(index).text((total/totalRows).toFixed(2));
        }
      function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
</script> 