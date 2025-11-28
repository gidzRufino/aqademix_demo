<div id="addCategory" style="display: none;">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn" aria-hidden="true">Cancel</button>
            <button id="addCategoryBtn" class="btn btn-primary">Add</button>
        </div>
        <h4 id="myModalLabel">Add Category</h4>
    </div>
    <div class="modal-body">
    <form id="addCategoryForm" action="" method="post">  
        <div class="control-group">
            <div class="controls">
                <input name="categoryName" type="text" id="categoryName" placeholder="Category Name" required>
              </div>
          </div>
          
      </form> 
   </div>
</div>

<script type="text/javascript">
    
    $('#addCategoryBtn').click(function() {
     
    var url = "<?php echo base_url().'index.php/gradingSystem/addCategory' ?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#addCategoryForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               $("form#addCategoryForm")[0].reset();
                
              //$("#msgResult").innerHTML='<textarea id="inputMessage" name="message"  onclick="" placeholder="Type in Your Message..." style="margin-left:4px;width:550px; "></textarea>'
               //alert(data) // show response from the php script.
               //document.location = '<?php echo base_url()?>gradingSystem/'
               alert('Category Successfully Added')
               document.getElementById('selectQuizCategory').innerHTML = data
                document.getElementById('createQuiz').style.display =""
               document.getElementById('addCategory').style.display ="none"
               
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    })
    
</script>