<div data-role="page" id="classRecord"  >
    <?php $this->load->view('headerPanel'); ?>
     <div data-position="fixed" data-role="header" data-theme="b">
         <button onclick="document.location='<?php echo base_url().'main/dashboard' ?>'" class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-notext ui-icon-home">Back</button>
        <h4 id="myModalLabel">Class Record</h4>
        <button onclick="window.history.back()" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-right ui-icon-back">Back</button>
    </div>
    <div id="classRecordTables">
     
   </div>
    <div data-position="fixed"  data-theme="b" data-role="footer" >
        <div data-role="navbar">
            <ul>
                <li><a data-transition="slideup"  href="#" onclick="document.location='<?php echo base_url().'gradingsystem' ?>'" data-icon="home">GS Home</a></li>
                <li><a data-transition="slideup"  href="#createQuiz" onclick="getAssessmentCategory()" data-icon="plus">Create</a></li>
                <li><a data-transition="slideup"  href="#recordScore" href="#" onclick="enterRawScore()" data-icon="edit" class="">Enter RS</a></li>
                <li><a data-transition="slideup"  href="#createQuiz"  onclick="getClassRecord()" data-icon="grid"  class="ui-btn-active">View</a></li>
            </ul>
        </div>

    </div>
</div>