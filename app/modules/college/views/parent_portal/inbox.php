<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">
            <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i></a> | My Messages
            <small onclick="logout()" class="pull-right pointer" style="margin-top:10px;"><?php echo $this->eskwela->getSet()->set_school_name;?></small>
            <input type="hidden" id="parent_id" value="<?php echo $this->session->userdata('parent_id') ?>" />
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 well">
        <ul class="nav nav-pills nav-stacked">
            <li class="">
              <a href="#">
               <i class="fa fa-pencil fa-fw"></i>
                Create Message
              </a>
            </li>
            <li class="active">
              <a href="#">
                 <i class="fa fa-envelope fa-fw"></i>  
                 Unread Messages
                <span class="badge pull-right">2</span>
                
              </a>
            </li>
          </ul>
       
    </div>
    <div class="col-lg-8">

    </div>
    
    
</div>
