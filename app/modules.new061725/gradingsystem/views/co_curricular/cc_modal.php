<div id="cc" class="modal fade" style="width:30%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="panel panel-info">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Contest and Competitions
            </h4>
        </div>
        <div class="panel-body">
            <input type="hidden" id="cc_id_1"/>
            <label>Select Level of Participation</label>
            <select  onclick="getCC_level(this.value, 1)" style="width:230px; font-size:14px"  name="inputSection" id="level" class="pull-left col-lg-12" required>
               <option>[Select Here]</option> 
               <?php $cc_level = Modules::run('gradingsystem/co_curricular', 'getCC_level', 1); 
                foreach ($cc_level as $result):
            ?>
               <option value="<?php echo $result->part_pos ?>"><?php echo $result->part_pos ?></option>  
             <?php endforeach; ?>
            </select>&nbsp;<small class="text-danger" id="level_1"></small>
            <div class="row"></div>
            <label>Select Rank Achieved</label>
            <select style="width:230px; font-size:14px"   name="inputSection" id="inputPart_Pos_1" required>
            </select>&nbsp;<small class="text-danger"  id="inputPart_Pos_current_1"></small>
            <div class="row"></div>
            
            <label>Enter the Name of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" id="eventName_1" placeholder="Name of Event" required>
          </div>
            <div class="row"></div>
            <label>Enter the Date of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" data-date-format="mm-dd-yyyy" id="eventDate_1" placeholder="Date" required>
          </div>
            
            
            
            
        </div>
      <div class="panel-footer clearfix">
          <button onclick="saveCCParticipation(1)" data-dismiss="modal" class="btn btn-success btn-sm pull-right">SAVE</button>
          <button class="btn btn-danger btn-sm pull-right" style="margin-right: 5px;" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
</div>

<div id="sl" class="modal fade" style="width:30%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="panel panel-red">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Student Leadership
            </h4>
        </div>
        <div class="panel-body">
            <input type="hidden" id="cc_id_2"/>
            <div class="row"></div>
            <label>Position</label><br />
            <select  onclick="getCC_level(this.value, 2)" style="width:230px; font-size:14px"  name="inputSection" id="level" class="pull-left col-lg-12" required>
               <option>[Select Here]</option> 
               <?php $cc_level = Modules::run('gradingsystem/co_curricular', 'getCC_level', 2); 
                foreach ($cc_level as $result):
            ?>
               <option value="<?php echo $result->part_pos ?>"><?php echo $result->part_pos ?></option>  
             <?php endforeach; ?>
          </select>&nbsp;<small class="text-danger" id="level_2"></small>
            <div class="row"></div>
            <label>Area Covered</label><br />
            <select style="width:230px; font-size:14px"   name="inputSection" id="inputPart_Pos_2" required>
            </select>&nbsp;<small class="text-danger"  id="inputPart_Pos_current_2"></small>
            <div class="row"></div>
            
            <label>Enter the Name of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" id="eventName_2" placeholder="Name of Event" required>
          </div>
            <div class="row"></div>
            <label>Enter the Date of Event</label>
            <div class="controls">
                <input style="width:230px;" class="form-control eventDate" name="eventdate" type="text" data-date-format="mm-dd-yyyy" id="eventDate_2" onclick="getDate(this.id)" onmouseover="getDate(this.id)" placeholder="Date" required>
          </div>
            
            
            
            
        </div>
      <div class="panel-footer clearfix">
          <button onclick="saveCCParticipation(2)" data-dismiss="modal" class="btn btn-success btn-sm pull-right">SAVE</button>
          <button class="btn btn-danger btn-sm pull-right" style="margin-right: 5px;" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
</div>

<div id="cj" class="modal fade" style="width:30%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Campus Journalism
            </h4>
        </div>
        <div class="panel-body">
            <input type="hidden" id="cc_id_3"/>
            <div class="row"></div>
            <label>Position</label><br />
            <select  onclick="getCC_level(this.value, 3)" style="width:230px; font-size:14px"  name="inputSection" id="level" class="pull-left col-lg-12" required>
               <option>[Select Here]</option> 
               <?php $cc_level = Modules::run('gradingsystem/co_curricular', 'getCC_level', 3); 
                foreach ($cc_level as $result):
            ?>
               <option value="<?php echo $result->part_pos ?>"><?php echo $result->part_pos ?></option>  
             <?php endforeach; ?>
          </select>&nbsp;<small class="text-danger" id="level_2"></small>
            <div class="row"></div>
            <label>Verify Position</label><br />
            <select style="width:230px; font-size:14px"   name="inputSection" id="inputPart_Pos_3" required>
            </select>&nbsp;<small class="text-danger"  id="inputPart_Pos_current_3"></small>
            <div class="row"></div>
            
            <label>Enter the Name of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" id="eventName_3" placeholder="Name of Event" required>
          </div>
            <div class="row"></div>
            <label>Enter the Date of Event</label>
            <div class="controls">
                <input style="width:230px;" class="form-control eventDate" name="eventdate" type="text" data-date-format="mm-dd-yyyy" id="eventDate_3" onclick="getDate(this.id)" onmouseover="getDate(this.id)" placeholder="Date" required>
          </div>

        </div>
      <div class="panel-footer clearfix">
          <button onclick="saveCCParticipation(3)" data-dismiss="modal" class="btn btn-success btn-sm pull-right">SAVE</button>
          <button class="btn btn-danger btn-sm pull-right" style="margin-right: 5px;" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
</div>

<div id="om" class="modal fade" style="width:30%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Officership and Membership
            </h4>
        </div>
        <div class="panel-body">
            <input type="hidden" id="cc_id_4"/>
            <div class="row"></div>
            <label>Level of Participation</label><br />
            <select  onclick="getCC_level(this.value, 4)" style="width:230px; font-size:14px"  name="inputSection" id="level" class="pull-left col-lg-12" required>
               <option>[Select Here]</option> 
               <?php $cc_level = Modules::run('gradingsystem/co_curricular', 'getCC_level', 4); 
                foreach ($cc_level as $result):
            ?>
               <option value="<?php echo $result->part_pos ?>"><?php echo $result->part_pos ?></option>  
             <?php endforeach; ?>
          </select>&nbsp;<small class="text-danger" id="level_4"></small>
            <div class="row"></div>
            <label>Position</label><br />
            <select style="width:230px; font-size:14px"   name="inputSection" id="inputPart_Pos_4" required>
            </select>&nbsp;<small class="text-danger"  id="inputPart_Pos_current_4"></small>
            <div class="row"></div>
            
            <label>Enter the Name of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" id="eventName_4" placeholder="Name of Event" required>
          </div>
            <div class="row"></div>
            <label>Enter the Date of Event</label>
            <div class="controls">
                <input style="width:230px;" class="form-control eventDate" name="eventdate" type="text" data-date-format="mm-dd-yyyy" id="eventDate_4" onclick="getDate(this.id)" onmouseover="getDate(this.id)" placeholder="Date" required>
          </div>

        </div>
      <div class="panel-footer clearfix">
          <button onclick="saveCCParticipation(4)" data-dismiss="modal" class="btn btn-success btn-sm pull-right">SAVE</button>
          <button class="btn btn-danger btn-sm pull-right" style="margin-right: 5px;" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
</div>

<div id="pa" class="modal fade" style="width:30%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Participation and Attendances
            </h4>
        </div>
        <div class="panel-body">
            <input type="hidden" id="cc_id_5"/>
            <div class="row"></div>
            <label>Level of Participation</label><br />
            <select  onclick="getCC_level(this.value, 5)" style="width:230px; font-size:14px"  name="inputSection" id="level_5" class="pull-left col-lg-12" required>
               <option>[Select Here]</option> 
               <?php $cc_level = Modules::run('gradingsystem/co_curricular', 'getCC_level', 5); 
                foreach ($cc_level as $result):
            ?>
               <option value="<?php echo $result->part_pos ?>"><?php echo $result->part_pos ?></option>  
             <?php endforeach; ?>
          </select>&nbsp;<small class="text-danger" id="level_5"></small>
            <div class="row"></div>
            <label>Position</label><br />
            <select style="width:230px; font-size:14px"   name="inputSection" id="inputPart_Pos_5" required>
            </select>&nbsp;<small class="text-danger"  id="inputPart_Pos_current_5"></small>
            <div class="row"></div>
            
            <label>Enter the Name of Event</label>
            <div class="controls">
              <input style="width:230px;" class="form-control" name="eventdate" type="text" id="eventName_5" placeholder="Name of Event" required>
          </div>
            <div class="row"></div>
            <label>Enter the Date of Event</label>
            <div class="controls">
                <input style="width:230px;" class="form-control eventDate" name="eventdate" type="text" data-date-format="mm-dd-yyyy" id="eventDate_5" onclick="getDate(this.id)" onmouseover="getDate(this.id)" placeholder="Date" required>
          </div>

        </div>
      <div class="panel-footer clearfix">
          <button onclick="saveCCParticipation(5)" data-dismiss="modal" class="btn btn-success btn-sm pull-right">SAVE</button>
          <button class="btn btn-danger btn-sm pull-right" style="margin-right: 5px;" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
</div>