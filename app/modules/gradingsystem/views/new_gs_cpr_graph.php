<?php
    $i=0;
    $a = 0;
    $p=0;
    $ap=0;
    $d = 0;
    $b = 0;
   foreach ($details->result() as $assess)
   {
       $flg = Modules::run('gradingsystem/getDescriptor', $assess->assess_id, $assess->raw_score);
       switch($flg):
           case 'O':
               $a += 1;
           break;    
           case 'VS':
               $p += 1;
           break;    
           case 'S':
               $ap+=1;
           break;    
           case 'FS':
               $d += 1;
           break;
           case 'F':
               $b += 1;
           break;    
       endswitch;
   }

   
?>
<div class="col-lg-4 panel" style="position: fixed; width: 250px; margin-top:10px;">
    <div class="panel-heading" style="height:40px;">
        <h6 class="text-center" style="margin:0">Graph Breakdown</h6>
    </div>
    <div class="panel-body" style="padding:0;">
        <table class="table table-bordered text-center">
            <tr>
                <td># of Students</td>
                <td>Level of Proficiency</td>
            </tr>
            <tr style="background:#5CC1EC;">
                <td><?php echo $a; ?></td>
                <td>Outstanding</td>
            </tr>
            <tr style="background: #CFDE5C;">
                <td><?php echo $p; ?></td>
                <td>Very Satisfactory</td>
            </tr>
            <tr style="background: #D68989;">
                <td><?php echo $ap; ?></td>
                <td>Satisfactory</td>
            </tr>
            <tr style="background:#8AC08A;">
                <td><?php echo $d; ?></td>
                <td>Fairly Satisfactory</td>
            </tr>
            <tr style="background: #B582EA;">
                <td><?php echo $b; ?></td>
                <td>Did Not Meet Expectations</td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $details->num_rows().' - total students'; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<input type="hidden" id="a" value="<?php echo ($a==""?0:$a) ?>" />
<input type="hidden" id="p" value="<?php if($p!=''):echo $p; else: echo '0'; endif; ?>" />
<input type="hidden" id="ap" value="<?php if($ap!=''):echo $ap; else: echo '0'; endif; ?>" />
<input type="hidden" id="d" value="<?php if($d!=''):echo $d; else: echo '0'; endif; ?>" />
<input type="hidden" id="b" value="<?php if($b!=''):echo $b; else: echo '0'; endif; ?>" />
<div id="graph_pie" class="col-lg-12" style="height:400px;">
    <span id="loadingObject" class="pull-right"><i class="fa fa-spinner fa-spin fa-fw" ></i> Loading Graphical Data... Please Wait...</span>
</div>
<script type="text/javascript">
   
    setTimeout(function(){
    (function basic_pie(container) {
    
    var
    a = $('#a').val(),
    p = $('#p').val(),
    ap = $('#ap').val(),
    d = $('#d').val(),
    b = $('#b').val(),
    d1 = [[0, parseInt(a)]],
    d2 = [[0, parseInt(p)]],
    d3 = [[0, parseInt(ap)]],
    d4 = [[0, parseInt(d)]],
    d5 = [[0, parseInt(b)]],
        graph;

    graph = Flotr.draw(container, [
        {
        
        data: d1, label: 'Outstanding',
        pie: {
            explode: 20
        }}, 
        {
        data: d2,label: 'Very Satisfactory'}, 
        {
        data: d3,
        label: 'Satisfactory'
        
    }, {
        data: d4,
        label: 'Fairly Satisfactory'
    }, {
        data: d5,
        label: 'Did not meet expectations'
    }
], {
        HtmlText: false,
        fontSize   : 8,
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
            backgroundColor: '#D2E8FF',
            
        }
    });
})(document.getElementById("graph_pie")); 
$('#loadingObject').hide();
},1200);
   
</script>