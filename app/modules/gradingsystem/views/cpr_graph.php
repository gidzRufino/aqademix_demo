<?php
    $i=0;
    $a = 0;
    $p=0;
    $ap=0;
    $d = 0;
    $b = 0;
   foreach ($details->result() as $assess)
   {
       $flg = Modules::run('gradingsystem/getEquivalent', $assess->equivalent);
       switch($flg):
           case 'A':
               $a += 1;
           break;    
           case 'P':
               $p += 1;
           break;    
           case 'AP':
               $ap = $i++;
               if($ap!=''):
                    $ap+=1;
                else:
                    $ap +=0;
                endif;
           break;    
           case 'D':
               $d += 1;
           break;
           case 'B':
               $b += 1;
           break;    
       endswitch;
       
//       $totalScore += $assess->raw_score;
//       $items = $assess->no_items;
   }
//   echo $totalScore.'<br />';
//    $x = ($totalScore / $details->num_rows());
//    echo $x.' is the average. <br />';
//   $pl = ($x/$assessment->row()->no_items);
//   echo $pl;
   
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
                <td>Advanced</td>
            </tr>
            <tr style="background: #CFDE5C;">
                <td><?php echo $p; ?></td>
                <td>Proficient</td>
            </tr>
            <tr style="background: #D68989;">
                <td><?php echo $ap; ?></td>
                <td>Approaching Proficient</td>
            </tr>
            <tr style="background:#8AC08A;">
                <td><?php echo $d; ?></td>
                <td>Developing</td>
            </tr>
            <tr style="background: #B582EA;">
                <td><?php echo $b; ?></td>
                <td>Beginning</td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $details->num_rows().' - total students'; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<input type="hidden" id="a" value="<?php if($a!=''):echo $a; else: echo '0'; endif; ?>" />
<input type="hidden" id="p" value="<?php if($p!=''):echo $p; else: echo '0'; endif; ?>" />
<input type="hidden" id="ap" value="<?php if($ap!=''):echo $ap; else: echo '0'; endif; ?>" />
<input type="hidden" id="d" value="<?php if($d!=''):echo $d; else: echo '0'; endif; ?>" />
<input type="hidden" id="b" value="<?php if($b!=''):echo $b; else: echo '0'; endif; ?>" />
<div id="graph_pie" class="col-lg-12" style="height:400px;">
    
</div>
<script type="text/javascript">
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
        
        data: d1, label: 'Advance',
        pie: {
            explode: 20
        }}, 
        {
        data: d2,label: 'Proficient'}, 
        {
        data: d3,
        label: 'Aproaching Proficient'
        
    }, {
        data: d4,
        label: 'Developing'
    }, {
        data: d5,
        label: 'Beginning'
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
</script>