<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="6" class="text-center">ACADEMIC</th>
        </tr>
        <tr class="quarterTitle">
            <th style="width:20%;">SUBJECT</th>
            <th class="text-center" style="width:15%;">FIRST</th>
            <th class="text-center" style="width:15%;">SECOND</th>
            <th class="text-center" style="width:15%;">THIRD</th>
            <th class="text-center" style="width:15%;">FOURTH</th>
            <th class="text-center" style="width:15%;">FINAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
        $gs_settings = Modules::run('gradingsystem/getSet', $sy);
        
        $i=0;
        foreach($subject as $s):
            $i++;
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->uid, $s->sub_id, $sy));
            switch ($gs_settings->gs_used):
                case 1:
                    $first = $grade->first;
                    $second = $grade->second;
                    $third = $grade->third;
                    $fourth = $grade->fourth;
                break;
                case 2:
                    $first = $grade->first;
                    $second = $grade->second;
                    $third = $grade->third;
                    $fourth = $grade->fourth;
                    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
                break;
            endswitch;
            
        ?>
        <tr class="data">
            <td><?php echo $singleSub->subject ?></td>
            <td class="text-center text-strong value"><?php echo ($first==""? 0 : $first) ?></td>
            <td class="text-center text-strong value"><?php echo ($second=="" ? 0 : $second) ?></td>
            <td class="text-center text-strong value"><?php echo ($third=="" ? 0 : $third) ?></td>
            <td class="text-center text-strong value"><?php echo ($fourth=="" ? 0 : $fourth) ?></td>
            <td class="text-center"><strong class="sum"></td>
        </tr>
        <?php
        endforeach;    
        ?>
<!--        <tr>
            <td class="text-strong">General Average<br><small class="text-center">Extra Co not Included</small></td>
            <td class="quarterTotal"></td>
            <td class="quarterTotal"></td>
            <td class="quarterTotal"></td>
            <td class="quarterTotal"></td>
            <td class="text-strong text-center" id="generalAve"></td>
        </tr>-->
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
              
              var final = (total/4).toFixed(2);
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