<form class="form-inline ml-3" onsubmit="event.preventDefault();">
  <div class="input-group input-group-sm">
    <input class="form-control form-control-navbar" grade="<?php echo $grade_id; ?>" section="<?php echo $section_id; ?>" subject="<?php echo $subject_id; ?>" type="search" placeholder="Search" aria-label="Search" id="searchInput" onkeyup="if(event.which === 13) doSearch(this)">
    <div class="input-group-append">
      <button class="btn btn-navbar" type="button" onclick="doSearch($(this).parent().parent().find('#searchInput'))">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</form>
<script>
    function doSearch(input){
        var put = $(input),
            grade = put.attr('grade'),
            section = put.attr('section'),
            subject = put.attr('subject'),
            value = put.val();
        $.ajax(
            {
                url: "<?php echo site_url('opl/searchDiscussion'); ?>",
                type: "POST",
                data:{
                    value: value,
                    grade: grade,
                    section: section,
                    subject: subject,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(data){
                    $("#discussionBody").html(data);
                }
            }
        )
    }
</script>