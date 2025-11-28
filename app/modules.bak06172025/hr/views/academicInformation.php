<table class="table table-striped table-bordered">
    <thead>
      <tr>
            <th class="col-lg-1" style="vertical-align: middle; text-align: center" rowspan="2">
                LEVEL
            </th>
            <th class="col-lg-3" style="vertical-align: middle; text-align: center"  rowspan="2">
                NAME OF SCHOOL
            </th>
            <th class="col-lg-3" style="vertical-align: middle; text-align: center"  rowspan="2">
                DEGREE / COURSE
            </th>
            <th class="col-lg-1" style="vertical-align: middle; text-align: center"  rowspan="2">
                YEAR GRADUATED
            </th>
            <th class="col-lg-1 text-center" colspan="2">
                YEARs ATTENDED
            </th>
            <th class="col-lg-1" style="vertical-align: middle; text-align: center" rowspan="2">

            </th>
        </tr>
        <tr>
            <th class="text-center">from</th>
            <th class="text-center ">to</th>
        </tr>  
    </thead>
    <tbody id="educHisBody">  
        <?php
            foreach ($edHis->result() as $edInfo):

        ?>        
        <tr>
            <td><?php echo $edInfo->el_level; ?></td>
            <td><?php echo $edInfo->school_name; ?></td>
            <td><?php echo $edInfo->course; ?></td>
            <td><?php echo $edInfo->eb_year_grad; ?></td>
            <td><?php echo $edInfo->eb_dates_from; ?></td>
            <td><?php echo $edInfo->eb_dates_to; ?></td>
            <td><button onclick="getEducHis('<?php echo $edInfo->eb_id; ?>')" data-toggle="modal" data-target="#addEdHis" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button> <button  onclick="deleteEducBac('<?php echo $edInfo->eb_id; ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
    
</table>

<hr>
<h5>College Education:</h5>

<dl class="dl-horizontal">
    <dt>
    Major:
    </dt>
    <dd>
        <?php 
            $major = Modules::run('hr/getMajorSubjects', $basicInfo->employee_id );
            
        ?>
        <span class='hide' id="major_wrapper">
        <input style="width:250px !important; font-size:14px;"  id="major"  class="select2-offscreen" name="major" type="text"  placeholder="Click Here to Select" />
        <i style="font-size:15px;" class="fa fa-save pointer" onclick="saveMinMaj($('#major').val(), '<?php echo $basicInfo->employee_id?>','major')"></i>
        </span>
        <span title="double click to edit" id="a_major" >
            <?php if($basicInfo->course!=""|| $basicInfo->course!="N/A"):echo $major->maj_min; else: echo "[empty]"; endif; ?> 
            <i onclick="$('#a_major').hide(), $('#major_wrapper').removeClass('hide'), $('#major').focus() " style="font-size:15px; color:#777;" class="fa fa-pencil-square-o pointer "></i>
        </span>
        
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    Minor:
    </dt>
    <dd>
        <?php 
            $minor = Modules::run('hr/getMinorSubjects',$basicInfo->employee_id  )
        ?>
        <span class='hide' id="minor_wrapper">
        <input style="width:250px !important; font-size:14px;"  id="minor"  class="select2-offscreen" name="major" type="text"  placeholder="Click Here to Select" 
               onblur="$('#minor_wrapper').addClass('hide'), $('#a_minor').show()"
               />
        <i style="font-size:15px;" class="fa fa-save pointer" onclick="saveMinMaj($('#minor').val(), '<?php echo $basicInfo->employee_id?>','minor')"></i>
        </span>
        <span title="double click to edit" id="a_minor" >
            <?php if($basicInfo->course!="" || $basicInfo->course!="N/A"):echo $minor->maj_min; else: echo "[empty]"; endif; ?> 
            <i onclick="$('#a_minor').hide(), $('#minor_wrapper').removeClass('hide'),$('#minor_wrapper').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o pointer "></i>
        </span>
        
    </dd>
</dl>


