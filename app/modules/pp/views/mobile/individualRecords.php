<div class="col-xs-12">
    <div class="col-xs-5 text-right">
        <img class="img-circle img-thumbnail" style="width:100px;" src="<?php echo base_url('uploads/noImage.png') ?> " />
   </div>
   <div class="col-xs-7 text-white text-center">
       <h4 style="margin:5px 0 5px; font-weight: 700;"><?php echo $students->firstname.' '.$students->lastname; ?></h4>
       <h5 style="margin:5px 0 5px;"><?php echo $students->level; ?></h5>
       <h6 style="margin:5px 0 5px;"><?php echo $students->st_id; ?></h6>
   </div>
</div>
<div id="accordion" class="col-xs-12 no-padding">
        <div style="height:30px; font-weight: 600;" class="mobile-panel-blue padding-5 " data-toggle="collapse" data-parent="#accordion" data-target="#personalInfo">
                Personal Information 
       </div> 
    <div id="personalInfo" class="panel-collapse collapse in">
      <div class="mobile-panel-white clearfix padding-5">
            <dl class="dl-horizontal no-margin">
                <dt>
                Address:
                </dt>
                <dd >
                    <span><?php echo $students->street.', '.$students->barangay.' '.$students->mun_city.', '. $students->province.', '. $students->zip_code; ?></span>

                </dd>
            </dl>
            <dl class="dl-horizontal no-margin">
                <dt>
                Contact No:
                </dt>
                <dd>
                    <span ><?php if($students->cd_mobile!=""):echo $students->cd_mobile; else: echo "[empty]"; endif; ?></span>

                </dd>
            </dl>
          <dl class="dl-horizontal no-margin">
                    <dt>
                        Birthdate: 
                    </dt>
                    <dd>
                        <span id="a_bdate" >
                            <?php echo $students->cal_date; ?>
                        </span> 
                    </dd>
                </dl>

                <dl class="dl-horizontal no-margin">
                    <dt>
                        Religion: 
                    </dt>
                    <dd>
                        <span id="a_religion" >
                            <?php echo $students->religion; ?>
                        </span>                  
                    </dd>
                </dl>

        </div>
    </div>
    <div  style="height:30px; font-weight: 600;" class="mobile-panel-blue padding-5 " data-toggle="collapse" data-parent="#accordion" data-target="#familyInfo">
                Family Information 
    </div>   
     
    <div id="familyInfo" class="panel-collapse collapse in">
      <div class="mobile-panel-white clearfix padding-5">
          <div class="col-xs-6 margin-right">
            <dl class="dl-horizontal no-margin">
                    <dt>
                        Father's Name :
                    </dt>
                    <dd>
                        <span><?php if($f->lastname!=""):echo $f->firstname.' '.$f->lastname; else: echo "[empty]"; endif;  ?> </span>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="F_educAttainValue" ><?php echo $f->attainment;   ?></span>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                         Occupation :
                    </dt>
                    <dd>
                        <span id="a_f_occupation"><?php echo $f->occupation; ?></span>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span ><?php if($students->f_office_name!=""):echo $students->f_office_name; else: echo "[empty]"; endif; ?></span>
                        

                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fmobile" ><?php if($f->cd_mobile!=""):echo $f->cd_mobile; else: echo "[empty]"; endif; ?></span>
                        
                    </dd>
                </dl>
                
            </div>
            
            <div class="col-xs-6">
                 <dl class="dl-horizontal no-margin">
                    <dt>
                        Mother's Name :
                    </dt>
                    <dd>
                        <span ><?php if($m->lastname!=""):echo $m->firstname.' '.$m->lastname; else: echo "[empty]"; endif; ?> </span>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="M_educAttainValue" ><?php echo $m->attainment;   ?></span>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                         Occupation :
                    </dt>
                    <dd>
                        <span id="a_m_occupation"><?php echo $m->occupation; ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span id="a_m_office_name" ><?php if($students->m_office_name!=""):echo $students->m_office_name; else: echo "[empty]"; endif; ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mmobile" ><?php if($m->cd_mobile!=""):echo $m->cd_mobile; else: echo "[empty]"; endif; ?></span>
                    
                    </dd>
                </dl>
            </div>
      </div> 
    </div>
    <div style="height:30px; font-weight: 600;"  class="mobile-panel-blue padding-5 " data-toggle="collapse" data-parent="#accordion" data-target="#ICE">
           In Case of Emergency
    </div>
    <div id="ICE" class="panel-collapse collapse in">
        <div class="mobile-panel-white clearfix padding-5">
            <div class="col-xs-6" style="padding-left: 0;">
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Contact Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_ice_name" ><?php if($students->ice_name!=""):echo $students->ice_name; else: echo "[empty]"; endif; ?></span>

                    </dd>
                </dl>
            </div>
            <div class="col-xs-6">
                <dl class="dl-horizontal no-margin">
                    <dt>
                        Contact Number :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_ice_contact" ><?php if($students->ice_contact!=""):echo $students->ice_contact; else: echo "[empty]"; endif; ?></span>

                    </dd>
                </dl>

            </div>
        </div>
    </div>
</div>
