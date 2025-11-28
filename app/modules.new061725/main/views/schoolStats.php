<div>
    <div class="contentHeader">
          <button type="button" class="btn-info pull-right" onclick="window.history.back()">BACK</button>
          <h3>School Statistics</h3>
    </div>
    
    <div class="span12 row-fluid">
        <div class="span5 pull-left" style="height:500px; overflow-y: scroll;">
            <h4>School Enrollment <small onclick="showBarGraph(document.getElementById('graphics'))">[ Show  Details ]</small></h4>
             <div style="width:100%;
                        height: 300px;
                        margin: 8px auto; float: right" id="graphics">
            </div>
        </div>
        <div class="span5 pull-right">
            <h4>Nutritional Status</h4>
        </div>
    </div>
</div>
<script type="text/javascript">
(function basic_pie(container) {
    var
    <?php 
     
       foreach ($grade_level as $gl)
       {
           $students = Modules::run('registrar/getStudentsByGradeLevel',$gl->grade_id);
           $totalStudents = $students->num_rows() ;
           if($totalStudents!=0):
            echo 'd'.$gl->grade_id." = [[0,$totalStudents ]],";
           endif;
       }
    ?>
    
    graph;

    graph = Flotr.draw(container, [
        //loop data
        <?php 
            $x = 1;
            foreach ($grade_level as $gl)
            {
                 $students = Modules::run('registrar/getStudentsByGradeLevel',$gl->grade_id);
                 $totalStudents = $students->num_rows() ;
                 $label = $gl->level.' - '. $totalStudents;
                if($totalStudents!=0):
                 echo "{data: d".$gl->grade_id.", label: '$label'},";
                endif;
            }
         ?>     
        ],{
        
        HtmlText: false,
        grid: {
            verticalLines: false,
            horizontalLines: false
        },
        xaxis: {
            showLabels: false
        },
        yaxis: {
            showLabels: false
        },
        pie: {
            show: true,
            explode: 6
        },
        mouse: {
            track: true
        },
        legend: {
            position: 'se',
            backgroundColor: '#D2E8FF'
        }
    });
})(document.getElementById("graphics"))

function showBarGraph(container,horizontal) {

    var horizontal
    var wins = [[0,13],[1,11],[2,15],[3,15]];
   var loss = [[0,5],[1,2],[2,3],[3,5]];
var years = [
  [0, "Grade 7"],
  [1, "Grade 8"],
  [2, "Grade 9"],
  [3, "Fourth Year"],
];

    // Draw the graph
  Flotr.draw(container,[wins, loss], {
                      title: "Enrollment Statistics",
                      bars: {
                          show: true,
                          barWidth: 0.5,
                          shadowSize: 0,
                          fillOpacity: 1,
                          linewidth: 0,
                          
                      },
                      yaxis: {
                          min: 0,
                          tickDecimals: 0,
                      },
                      xaxis: {

                      },
                      grid: {
                        horizontalLines: false,
                        verticalLines: false,
                      },
                      mouse: {
                            track: true,
                        },
                  });
}
</script>
