<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <form id="add_quantity">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b># of quantity</b></h4>
            </div>
            <div class="modal-body">
                <input type="text" id="itemname" hidden="">
                <div class="row1">
                    <div class="col-md-12">
                        <p id="itemtity" style="color: red">This field is required!</p>
                        <input type="tel" name="quantity" id="quantity" onkeypress="if(event.keyCode==13){okbtn1()}" class="form-control tel" required="" placeholder="Enter Quantity"/>
                        <?php $this->load->view("num_pad"); ?>
                        <div class="clearfix">
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-lg" onclick="clearing();">Clear</button>
                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="okbtn1()" class="btn btn-primary btn-lg">OK</button>
            </div>
        </form>
    </div>

</div>

<script>
    
function okbtn1(){

    if($('#quantity').val() == ""){
        document.getElementById("itemtity").style.fontWeight = "700";
        $('#quantity').focus();
        return false;
    } else {
        $('#qModal').modal('hide');
        document.getElementById("itemtity").style.fontWeight = "";
        okbtn();
    }
}
    
</script>
