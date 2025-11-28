

<div class="row">
    <div class="col-md-7">
        <table class="table">
                <thead>
                    <th>Studen ID</th>
                    <th>Trans_id</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Amount</th>
                    <th>Disc id</th>
                    <th>Date</th>
                    <th>action</th>
                </thead>
                <tbody>
                    <?php $c =1; foreach($students as $st):?>
                        <tr>
                            <td><?php echo $st->st_id?> </td>
                            <td><?php echo $st->trans_id?> </td>
                            <td><?php echo $st->lastname?> </td>
                            <td><?php echo $st->firstname?> </td>
                            <td><?php echo $st->t_amount?> </td>
                            <td><?php echo $st->disc_id?> </td>
                            <td><?php echo $st->t_timestamp?> </td>
                            <td>
                                <button type="button" class="btn btn-primary" dID ="<?php echo $st->disc_id?>" transID ="<?php echo $st->trans_id?>" onclick="updateDiscount(this)">Update</button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    
                </tbody>
        </table>
    </div>
    <div class="col-md-5">
        <table class="table">
                <thead>
                    <th>Student ID</th>
                    <th>Dis ID</th>
                    <th>amount</th>
                    <th>Timestamp</th>
                </thead>
                <tbody>
                    <?php $c =1; foreach($discounts as $st):?>
                        <tr>
                            <td><?php echo $st->disc_st_id?> </td>
                            <td><?php echo $st->disc_id?> </td>
                            <td><?php echo $st->disc_amount?> </td>
                            <td><?php echo $st->disc_timestamp?> </td>
                        </tr>
                    <?php endforeach;?>
                    
                </tbody>
        </table>
    </div>
</div>






<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="">Trans ID</label>
            <input type="text" class="form-control" id="transID" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Disc ID</label>
            <input type="text" class="form-control" id="discID" placeholder="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveDis">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script>


    function updateDiscount(btn){     
        $('#transID').val($(btn).attr('transID'));
        $('#discID').val($(btn).attr('dID'));
        $("#exampleModal").modal('show');
        
        
    }


    $("#saveDis").click(function(){
        var t = $('#transID').val();
        var d = $('#discID').val();

        var data = {
            trans_id: t,
            disc_id: d,
            csrf_test_name: $.cookie('csrf_cookie_name')
        }

        console.log(data);
        $.ajax(
            {
                url: '<?php echo base_url("finance/updateDis")?>',
                type: "POST",
                data: data,
                success: function(data){
                    alert(data);
                    console.log(data);
                    // alert(data.message);
                    location.reload();
                }
            }
        )
    });

    

</script>