<?php
$subjects = Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year);

// Helper to get avatar
function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}
?>

<!-- FLOATING QUICK POST BUTTON -->
<button id="quickPostBtn" class="btn btn-primary rounded-circle shadow-lg" data-toggle="modal" data-target="#quickPostModal">
    <i class="fa fa-plus"></i>
</button>

<!-- QUICK POST MODAL -->
<div class="modal fade" id="quickPostModal" tabindex="-1" role="dialog" aria-labelledby="quickPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="quickPostModalLabel"><i class="fa fa-edit mr-2"></i> Create a Post</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="quickPostForm" method="post">
                <div class="modal-body">
                    <textarea id="quickPostText" name="op_post" class="form-control summernote"></textarea>
                </div>

                <div class="modal-footer">
                    <select class="form-control form-control-sm w-auto mr-auto" id="postTarget"
                        onchange="setStudentExceptions($(this).val())">
                        <option value="0">All</option>
                        <?php if ($this->session->isOplAdmin == 1): ?>
                            <option value="1">Teachers</option>
                        <?php endif; ?>
                        <option value="2">Parents</option>
                        <?php if ($this->session->isOplAdmin == 1): ?>
                            <option value="3">Grades / Courses</option>
                        <?php endif; ?>
                        <option value="4">Sections / Classes</option>
                    </select>
                    <input type="hidden" id="postTargetID" />
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane mr-1"></i> Post</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php
echo Modules::run('opl/opl_widgets/teachersWidget', $subjectDetails);
?>

<!-- LOADER -->
<section id="postLoad" class="text-center my-3">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</section>


<input type="hidden" id="scrollPage" scroll-page="0" />

<!-- DELETE CONFIRM MODAL -->
<div class="modal rounded" id="confirmDelete">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Post?</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <small class="text-muted">This action cannot be undone.</small>
                <div class="mt-3 text-right">
                    <button type="button" class="btn btn-light btn-sm mr-2" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deletePostBtn" onclick="deletePost(this)">Proceed</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SELECT MODALS -->
<div class="modal fade" id="selectInclusion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-sm">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Select Included Levels</h5>
            </div>
            <div class="modal-body overflow-auto" style="height: 500px;">
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="search" class="form-control border-left-0" placeholder="Search Class..." />
                    </div>
                </div>
                <div class="form-group row" id="classSelection">
                    <div class="col-12 text-center mt-5 text-success">
                        <i class="fa fa-circle-notch fa-spin fa-3x"></i>
                        <p class="text-dark">Loading... Please wait...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" onclick="getGrades(this)">Accept</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectSections">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-sm">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Select Included Classes</h5>
            </div>
            <div class="modal-body overflow-auto" style="height: 500px;">
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="search" class="form-control border-left-0"
                            fac-id="<?php echo ($this->session->isOplAdmin) ? 'NULL' : $this->session->employee_id; ?>"
                            onkeyup="if(event.which === 13) searchSection(this)"
                            placeholder="Search Class..." />
                    </div>
                </div>
                <div class="form-group row" id="sectionSelect">
                    <div class="col-12 text-center mt-5 text-success">
                        <i class="fa fa-circle-notch fa-spin fa-3x"></i>
                        <p class="text-dark">Loading... Please wait...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" onclick="getClasses(this)">Accept</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    /* Floating Post Button */
    #quickPostBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
    }

    /* Post Section Header */
    .post-header {
        padding: 14px 22px;
        background: linear-gradient(90deg, #0d6efd, #4dabf7);
        border-radius: 8px;
        margin-bottom: 18px;
        color: #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .post-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    /* Scrollable Feed */
    .post-scroll {
        /* max-height: 600px; */
        /* adjust height as needed */
        overflow-y: auto;
        padding-right: 5px;
    }

    /* Elegant Scrollbar */
    .post-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .post-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .post-scroll::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 10px;
    }

    .post-scroll::-webkit-scrollbar-thumb:hover {
        background: #868e96;
    }

    /* Post Holder */
    #postHolder {
        width: 100%;
        max-height: 600px;
        /* adjust as you like */
        overflow-y: auto;
        padding-right: 5px;
        /* space for scrollbar */
    }

    /* Smooth scrollbar styling (modern browsers) */
    #postHolder::-webkit-scrollbar {
        width: 8px;
    }

    #postHolder::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #postHolder::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 10px;
    }

    #postHolder::-webkit-scrollbar-thumb:hover {
        background: #868e96;
    }

    #postHolder .post-banner {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 18px;
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease;
    }

    #postHolder .post-banner:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #postHolder .banner-avatar {
        flex: 0 0 55px;
        margin-right: 15px;
    }

    #postHolder .banner-avatar img {
        border-radius: 50%;
        width: 55px;
        height: 55px;
        object-fit: cover;
        border: 2px solid #dee2e6;
    }

    #postHolder .banner-content {
        flex: 1;
    }

    #postHolder .banner-content h6 {
        margin: 0;
        font-weight: 600;
        color: #212529;
    }

    #postHolder .banner-content small {
        color: #6c757d;
        display: block;
        margin-bottom: 8px;
    }

    #postHolder .banner-text {
        margin-top: 5px;
        font-size: 15px;
        color: #444;
        line-height: 1.5;
    }

    /* Actions */
    #postHolder .banner-actions {
        margin-top: 12px;
        display: flex;
        gap: 20px;
    }

    #postHolder .banner-actions a {
        font-size: 14px;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }

    #postHolder .banner-actions a i {
        margin-right: 6px;
    }

    #postHolder .banner-actions a:hover {
        color: #0d6efd;
    }

    /* Elegant Divider Between Posts */
    #postHolder .post-banner::after {
        content: "";
        position: absolute;
        bottom: -9px;
        left: 20px;
        right: 20px;
        height: 1px;
        background: #dee2e6;
    }
</style>

<!-- FEED JS -->
<script src="<?php echo site_url('opl_assets/timeago/dist/timeago.min.js'); ?>"></script>
<script>
    // Example: Append posts (replace with your AJAX response loop)
    // $(document).ready(function() {
    //     var samplePosts = [{
    //             user: "John Doe",
    //             avatar: "https://i.pravatar.cc/60?img=1",
    //             datetime: "2 hours ago",
    //             text: "Excited to share some updates on our new project! 🚀"
    //         },
    //         {
    //             user: "Jane Smith",
    //             avatar: "https://i.pravatar.cc/60?img=2",
    //             datetime: "Yesterday at 5:30 PM",
    //             text: "Reminder: Parent-teacher conference will be held this Friday. Don’t miss it!"
    //         }
    //     ];

    //     samplePosts.forEach(p => {
    //         var html = '<div class="post-banner">\
    //           <div class="banner-avatar"><img src="' + p.avatar + '" alt="User Avatar"></div>\
    //           <div class="banner-content">\
    //               <h6>' + p.user + '</h6>\
    //               <small><i class="fa fa-clock mr-1"></i>' + p.datetime + '</small>\
    //               <div class="banner-text">' + p.text + '</div>\
    //               <div class="banner-actions">\
    //                   <a href="#"><i class="fa fa-thumbs-up"></i> Like</a>\
    //                   <a href="#"><i class="fa fa-comment"></i> Comment</a>\
    //                   <a href="#"><i class="fa fa-share"></i> Share</a>\
    //               </div>\
    //           </div>\
    //       </div>';
    //         $("#postHolder").append(html);
    //     });
    // });

    var sbList, limit = 10,
        loadingPost = false;
    const dateoption = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };

    $(document).ready(function() {
        $("#postLoad").hide();
        $("#postHolder").hide();

        $.ajax({
            type: "GET",
            url: '<?php echo base_url('opl/sbPost') ?>',
            dataType: 'JSON',
            beforeSend: function() {
                $("#postLoad").show();
            },
            success: function(response) {
                sbList = response.post;
                loadBody();
            },
            error: function() {
                alert("Operation Failed");
            }
        });

        if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
        window.scrollTo(0, 0);

        window.onscroll = function() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                if (!loadingPost) {
                    $("#postLoad").show();
                    $("#postHolder").hide();
                    loadBody();
                }
            }
        }
    });

    var loadBody = async () => {
        let sbBody = $("#postHolder"),
            html = sbBody.html(),
            i = parseInt($("#scrollPage").attr('scroll-page')),
            sbLength = sbList.length,
            length = (sbLength >= (i + limit)) ? i + limit : sbLength;

        while (i < length) {
            data = sbList[i];
            let image = (data.avatar != '' ? '<?= base_url() . 'uploads/' ?>' + data.avatar : (data.sex == 'Female' ? '<?php echo base_url() . 'images/avatar/female.png' ?>' : '<?php echo base_url() . 'images/avatar/male.png' ?>')),
                date = new Date(data.op_timestamp),
                datetime = new Intl.DateTimeFormat('en-US', dateoption).format(date);

            button = '<?php if ($p->op_owner_id == $this->session->username || $this->session->isOplAdmin || strcmp($this->session->position, "School Administrator") == 0) : ?>\
              <button type="button" class="btn btn-light btn-sm text-danger float-right" title="Delete Post" post-id="' + data.op_id + '" onclick="readyDelete(this)">\
                  <i class="fa fa-trash"></i>\
              </button>\
          <?php endif; ?>';

            html += '<div class="post-banner">\
              <div class="banner-avatar"><img src="' + image + '" alt="User Image"></div>\
              <div class="banner-content">\
                  <h6>' + data.firstname + ' ' + data.lastname + '</h6>\
                  <small><i class="fa fa-clock mr-1"></i>' + datetime + '</small>\
                  <div class="banner-text">' + data.op_post + '</div>\
              </div>\
          </div>';
            i++;
        }

        $("#scrollPage").attr("scroll-page", i);
        sbBody.html(html);
        $("#postLoad").hide();
        $("#postHolder").show();
    };

    function deletePost(btn) {
        var id = $(btn).attr('post-id');
        $.ajax({
            url: "<?php echo site_url('opl/deletePost'); ?>",
            type: "POST",
            data: {
                postid: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                alert(data);
                location.reload();
            }
        })
    }

    function readyDelete(btn) {
        var id = $(btn).attr('post-id');
        $("#confirmDelete").find("#deletePostBtn").attr('post-id', id);
        $("#confirmDelete").modal('show');
    }

    // Summernote Init
    $(function() {
        // Summernote Init
        $('.summernote').summernote({
            placeholder: "Hey! What's up? Anything interesting?",
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });

        // Fix Summernote focus inside modal
        $('#quickPostModal').on('shown.bs.modal', function() {
            $('.summernote').summernote('focus');
        });

        // Quick Post Submit
        $('#quickPostForm').on('submit', function(e) {
            e.preventDefault();

            var postContent = $('#quickPostText').val();
            if (postContent.trim() === '') return;

            // Example placeholders (replace with backend values)
            var image = "<?= base_url('assets/img/default-avatar.png'); ?>";
            var userName = "<?= $this->session->userdata('name'); ?>";
            var datetime = "Just now";

            var newPost = '<div class="post-banner">\
            <div class="banner-avatar">\
                <img src="' + image + '" alt="User Image">\
            </div>\
            <div class="banner-content">\
                <h6>' + userName + '</h6>\
                <small><i class="fa fa-clock mr-1"></i>' + datetime + '</small>\
                <div class="banner-text">' + postContent + '</div>\
                <div class="banner-actions">\
                    <a href="#"><i class="fa fa-thumbs-up"></i> Like</a>\
                    <a href="#"><i class="fa fa-comment"></i> Comment</a>\
                    <a href="#"><i class="fa fa-share"></i> Share</a>\
                </div>\
            </div>\
        </div>';

            $('#postHolder').prepend(newPost); // Add new post to top
            $('#quickPostModal').modal('hide');
            $('#quickPostForm')[0].reset();
            $('.summernote').summernote('reset');
        });
    });
</script>