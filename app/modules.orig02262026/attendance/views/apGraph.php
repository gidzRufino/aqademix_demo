<div id="graph" class="col-lg-7 pull-left" style="height:450px;">
    
</div>
<div class="col-lg-5 pull-right" style="height:450px; overflow-y: scroll;">
    <table class="table table-striped">
        <tr>
            <td>Date</td>
            <td>Students Present</td>
        </tr>
        <?php
        $i=0;
            $numberOfSchoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay);
            for($x=1; $x<=$lastDay;$x++):
                $i++;
                if($x<10):
                    $x = '0'.$x;
                endif;
                $day = date('D', strtotime($d[0].'-'.$d[1].'-'.$x));

                if($day=='Sat'||$day=='Sun')
                {

                }else{
                    $presents = Modules::run('attendance/getNumberOfPresents', $d[0].'-'.$d[1].'-'.$x, $section_id);
                    //echo date("m/$x/Y");
                    $numberOfPresents += $presents->num_rows();
        ?>
        <tr>
            <td><?php echo $d[0].'-'.$x ?></td>
            <td><?php echo $numberOfPresents ?></td>
        </tr>
        <?php
                }
                unset($numberOfPresents);
            endfor;
            ?>
    </table>
</div>

<script type="text/javascript">
    
(function basic(container) {

    var
    d1 = [[0,0],
        <?php
        $i=0;
        $numberOfSchoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay);
        for($x=1; $x<=$lastDay;$x++):
            
            if($x<10):
                $x = '0'.$x;
            endif;
            $day = date('D', strtotime($d[0].'-'.$d[1].'-'.$x));

            if($day=='Sat'||$day=='Sun')
            {

            }else{
                $i++;
                $presents = Modules::run('attendance/getNumberOfPresents', $d[0].'-'.$d[1].'-'.$x, $section_id);
                //echo date("m/$x/Y");
                $numberOfPresents += $presents->num_rows();
                if($numberOfPresents==''):
                    $numberOfPresents=0;
                endif;
                
                echo '['.$i.','.$numberOfPresents.']';
                if($x<$lastDay):
                    echo ',';
                endif;
            }
                
                //$numberOfPresents = 0;
                unset($numberOfPresents);
        endfor;
        ?>//
    ],
        // First data series


    // Draw Graph
    graph = Flotr.draw(container, [
          {data:
            d1, 
            lines: {
                show: true,
                fill: true
            }
            
          }], 
        {
        fontSize: 10,
        xaxis: {
            ticks:[
                <?php
                        $numberOfSchoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay);
                        $i=0;
                        for($x=1; $x<=$lastDay;$x++):
                            
                            if($x<10):
                                $x = '0'.$x;
                            endif;
                            $date = $d[0].'-'.$d[1].'/'.$x;
                            $day = date('D', strtotime($d[0].'-'.$d[1].'-'.$x));

                            if($day=='Sat'||$day=='Sun')
                            {

                            }else{
                                $i++;
                                echo '['.$i.',\''.$date.'\']';
                                if($x<$lastDay):
                                    echo ',';
                                endif;
                            }
                        endfor;
                    ?>//
            ],
            labelsAngle: 45,
            //tickDecimals:0,
            title: 'Dates',
            font:{
                size:20
            }
        },
        yaxis: {
            
            titleAngle: 90,
            title: 'Number of Students',
            max: '<?php echo $numberOfStudents->num_rows()+10; ?>'
        },
        grid: {
            minorVerticalLines: true
        },
        HtmlText: false
    });
})(document.getElementById("graph"));    
</script>