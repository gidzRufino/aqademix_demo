<br>
<div class="col-md-12">
    <div class="well" id="eligElem">
        <h4 style="text-align: center">Eligibility For Elementary School Enrollment</h4>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <label>Credential Presented for Grade 1:</label>
                <div class="form-check" id="credPresented">
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <label>Name of School :</label>
                    <span id="sch_name"></span>
                    <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer" rel="clickover"  id="schoolName" onclick="displaySchoolList()"
                       data-content="
                           <?php $this->load->view('schoolSelect'); ?>"></i>
                    <span></span><br>
                    <label>School ID :</label>
                    <span id="sch_sid"></span><br>
                    <label>Address of School :</label>
                    <span></span><br>
                </div>
            </div>
            <div class="col-md-4">
                <label>Other Credential Presented</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pept" />
                    <label class="form-check-label" for="pept">PEPT Passer</label>
                </div>
                <label class="control-label">Rating :</label>
                <span></span><br>
                <label>Date of Examination : </label>
                <span></span><br>
                <label for="others">Others(Pls. Specify) : </label>
                <span></span><br>
                <label>Name and Address of Testing Center : </label>
                <span></span><br>
                <label>Remarks : </label>
                <span></span>
            </div>
        </div>
    </div>
    <div id="eligJHS" hidden="">
        Junior High Eligibility
    </div>
    <div id="eligSHS" hidden="">
        Senior High Eligibility
    </div>
</div>