<h4 class="text-center">Quick Access</h4>
<hr style="margin:0; width:95%;">
<div style="padding:20px; margin-left:35px;"> 
   <ul class="thumbnails"> 
    <?php
        $advisory = Modules::run('academic/getAdvisory', $this->session->userdata('user_id'), NULL);
        //echo $advisory->row()->section_id;
        $icon = $icons->dash_access;
        if($icon!=""){
        $item = explode(",", $icon);
        $count = count($item);
        $c=0;
        foreach ($item as $i)
        {
        $c++;
        $icon = Modules::run('nav/getDashAccess', $i);
    ?>
       <li style="" class="span2">
                <?php if($this->session->userdata('is_admin')): ?>
                    <a title="<?php echo $icon->dash_name; ?>" href="<?php echo base_url().$icon->dash_link ?>" class="thumbnail text-center dash-link">
                        <img class="dash-icon" src="<?php echo base_url().'images/'.$icon->dash_image?>" /> 
                        <?php //echo $icon->dash_name; ?>
                    </a>
                <?php elseif($this->session->userdata('is_adviser')): 
                    if($icon->dash_id==2):
                    ?>
                        <a title="<?php echo $icon->dash_name; ?>" href="<?php echo base_url().$icon->dash_link ?>/<?php echo $advisory->row()->section_id ?>" class="thumbnail text-center dash-link">
                            <img class="dash-icon" src="<?php echo base_url().'images/'.$icon->dash_image?>" /> 
                            <?php //echo $icon->dash_name; ?>
                        </a>
                <?php else: ?>
                    <a title="<?php echo $icon->dash_name; ?>" href="<?php echo base_url().$icon->dash_link ?>" class="thumbnail text-center dash-link">
                            <img class="dash-icon" src="<?php echo base_url().'images/'.$icon->dash_image?>" /> 
                            <?php //echo $icon->dash_name; ?>
                    </a>
           
                <?php endif; 
                else: ?>
                    <a title="<?php echo $icon->dash_name; ?>" href="<?php echo base_url().$icon->dash_link ?>" class="thumbnail text-center dash-link">
                        <img class="dash-icon" src="<?php echo base_url().'images/'.$icon->dash_image?>" /> 
                        <?php //echo $icon->dash_name; ?>
                    </a>
                <?php endif; ?>
            </li>
    <?php
        }
        }
    
    if($this->session->userdata('position_id')!=4){    
        
    ?>
    <li class="span2">
            <a title="Pass Slip Form" href="#passSlipModal" class="thumbnail text-center dash-link" data-toggle="modal">
                <img class="dash-icon" src="<?php echo base_url().'images/passlipform.png'?>" /> 
              <!--Pass Slip Form-->
            </a>
    </li>          
    <li class="span2">
            <a title="My DTR" href="<?php echo base_url().'hr/dtr/'.$this->session->userdata('user_id')?>" class="thumbnail text-center dash-link">
                <img class="dash-icon" src="<?php echo base_url().'images/dtr.png' ?>" /> 
              <!--My DTR-->
            </a>
    </li>  
    <?php
    }
    ?>
   </ul>          

</div>

<?php
echo Modules::run('hr/passSlip');
    