<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Accounts
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('main/dashboard') ?>'">Dashboard</button>
          </div>
    </h3>
    <div class='col-lg-12'>
            
            <div class="row" id="searchWrapper">
                <div class="col-lg-2"></div>
                <div class="form-group col-lg-8">
                    <h4>Search Name:</h4>
                    <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

                    </div>
                </div>
            </div>
            
        <div class='col-lg-12'  id="AccountBody">
            <?php if($id!=NULL): 
                echo Modules::run('finance/viewLoadAccountDetails', $id, $school_year);
            endif;
?>
        </div>
    </div>
</div>
<?php
?>

<script type="text/javascript">
    
   function loadDetails(st_id)
   {
       var url = '<?php echo base_url().'finance/viewLoadAccountDetails/' ?>'+st_id;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+st_id, // serializes the form's elements.
               success: function(data)
               {
                    // $('#AccountBody').html(data);
                    document.location = '<?php echo base_url().'finance/viewFinAccounts/' ?>'+st_id;
               }
             });

        return false;
   }

   function search(value)
      {
          
          var url = '<?php echo base_url().'search/searchStudentAccountsK12/' ?>'+value;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                     $('#searchName').show();
                     $('#searchName').html(data);
               }
             });

        return false;
      }
     
     
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
     
    

</script>

<?php $this->load->view('financeModals'); 