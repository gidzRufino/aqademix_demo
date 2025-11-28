<div class="modal-dialog modal-sm">

    <div class="modal-content">
        <form id="add_quantity">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Enter Amount</b></h4>
            </div>
            <div class="modal-body">
                <input type="text" id="itemname" hidden="">
                <input type="number" id="itemprice" hidden="">
                <div class="row1">
                    <div class="col-md-12">
                        <p id="cashmod" style="color: red">* This field is required!</p>
                        <input type="tel" name="cash" id="cash" class="form-control tel" placeholder="Cash Amount" />
                        <?php $this->load->view("num_pad"); ?>
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-lg" onclick="clearing();">Clear</button>
                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="cashBtn1()" class ="btn btn-primary btn-lg">OK</button>
            </div>
        </form>
    </div>

</div>
<script>
    function cashBtn1() {
        if ($('#cash').val() == "") {
            document.getElementById("cashmod").style.fontWeight = "700";
            $('#cash').focus();
        } else {
            var x = document.getElementById("total-price").innerText;
            var y = document.getElementById("cash").value;
            x = x.replace('Php', '');
            var z = y - x;
            
            if(z < 0){
                $('#cashmod').html("Cash should be greater than or equal to the total amount payable");
                $('#cash').focus();
            } else {
                $('#cashModal').modal('hide');
                cashbtn();
            }
        }


    }
</script>