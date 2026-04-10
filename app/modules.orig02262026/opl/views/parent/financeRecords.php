<?php
function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}

// print_r($child['amount_due'])
?>

<style>
    /* Panel container styling */
    .panel-custom {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 25px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all .3s ease-in-out;
    }

    .panel-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Highlight active panel */
    .active-panel {
        border: 2px solid #4e73df !important;
        box-shadow: 0 0 15px rgba(78, 115, 223, 0.5) !important;
    }

    /* Panel heading */
    .panel-heading-custom {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        padding: 15px 20px;
    }

    .panel-heading-custom .media-left img {
        border: 3px solid #fff;
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

    .panel-heading-custom .media-heading {
        font-size: 18px;
        font-weight: bold;
    }

    .panel-heading-custom small {
        font-size: 13px;
        opacity: .9;
    }

    /* Footer button */
    .panel-footer-custom {
        background: #f9f9f9;
        padding: 12px 15px;
    }

    .toggle-btn {
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 13px;
        transition: all .3s;
    }

    /* Active panel body */
    .active-panel .panel-body {
        background: linear-gradient(135deg, #f8faff 0%, #e6ecff 100%);
        animation: fadeIn .4s ease-in-out;
        border-radius: 0 0 12px 12px;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tables */
    .table th {
        background: #f1f4fb;
        color: #333;
        font-weight: 600;
        text-align: center;
    }

    .table td {
        vertical-align: middle !important;
    }

    .card-custom {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all .3s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: #f8faff;
        padding: 10px 15px;
        border-bottom: 1px solid #e3e6f0;
    }

    .card-body {
        padding: 15px;
    }

    .payment-history-body {
        max-height: 300px;
        /* adjust height as needed */
        overflow-y: auto;
        padding: 0;
        /* tighter look */
    }

    /* Improve scroll look */
    .payment-history-body::-webkit-scrollbar {
        width: 8px;
    }

    .payment-history-body::-webkit-scrollbar-thumb {
        background: rgba(78, 115, 223, 0.6);
        border-radius: 4px;
    }

    .payment-history-body::-webkit-scrollbar-thumb:hover {
        background: rgba(78, 115, 223, 0.9);
    }
</style>

<div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">
    <div class="panel-group" id="studentAccordion">
        <?php foreach ($child as $ch):
            $stAvatar = getAvatarUrl($ch['avatar'], $ch['gender']); ?>

            <div class="panel panel-custom">
                <!-- Header -->
                <div class="panel-heading panel-heading-custom">
                    <div class="media">
                        <div class="media-left">
                            <img src="<?= $stAvatar ?>" class="img-circle">
                        </div>
                        <div class="media-body" style="padding-left:10px;">
                            <h4 class="media-heading"><?= $ch['name'] ?></h4>
                            <small><?= $ch['level'] ?> | ID: <?= $ch['stid'] ?></small>
                        </div>
                    </div>
                </div>

                <!-- Toggle Button -->
                <div class="panel-footer panel-footer-custom text-right">
                    <button class="btn btn-xs btn-primary toggle-btn"
                        data-toggle="collapse"
                        data-target="#<?= $ch['collapseId']; ?>"
                        data-parent="#studentAccordion"
                        aria-expanded="false"
                        aria-controls="<?= $ch['collapseId']; ?>">
                        <i class="fa fa-chevron-down"></i> <span>View Details</span>
                    </button>
                </div>

                <!-- Collapsible Body -->
                <div id="<?= $ch['collapseId']; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <!-- Finance Summary Card -->
                            <div class="col-md-6 col-sm-12">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h5 class="text-primary m-0">
                                            <i class="fa fa-money text-success"></i> Finance Summary
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed table-striped">
                                            <tr>
                                                <td><strong>Plan:</strong></td>
                                                <td><?= $ch['plan_title'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Charges:</strong></td>
                                                <td>₱<?= number_format($ch['total'], 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Balance:</strong></td>
                                                <td class="text-danger">₱ <?= number_format($ch['balance'], 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Amount Due:</strong></td>
                                                <td class="text-danger">₱ <?= number_format($ch['amount_due'], 2); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment History Card -->
                            <div class="col-md-6 col-sm-12">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h5 class="text-primary m-0">
                                            <i class="fa fa-list text-info"></i> Payment History
                                        </h5>
                                    </div>
                                    <div class="card-body payment-history-body">
                                        <div class="table-responsive table-scroll">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>OR #</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($ch['finance_transaction'] != ''):
                                                        foreach ($ch['finance_transaction'] as $ft): ?>
                                                            <tr>
                                                                <td><?= $ft['date'] ?></td>
                                                                <td><?= $ft['ref_num'] ?></td>
                                                                <td>₱ <?= $ft['amount'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        <tr>
                                                            <td colspan="2" style="font-weight: bold;">Total Paid</td>
                                                            <td style="font-weight: bold;">₱ <?= $ch['total_paid'] ?></td>
                                                        </tr>
                                                    <?php
                                                    else: ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">No payments recorded</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.row -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $('.toggle-btn').on('click', function() {
        var $btn = $(this);
        var $icon = $btn.find('i');
        var $text = $btn.find('span');
        var target = $($btn.data('target'));
        var $panel = $btn.closest('.panel');

        if (target.hasClass('in')) {
            target.collapse('hide');
            return;
        }

        target.on('shown.bs.collapse', function() {
            $('#studentAccordion .panel').removeClass('active-panel');
            $('#studentAccordion .toggle-btn')
                .removeClass('btn-danger')
                .addClass('btn-primary');
            $('#studentAccordion .btn i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $('#studentAccordion .btn span').text('View Details');

            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $text.text('Hide Details');
            $btn.removeClass('btn-primary').addClass('btn-danger');
            $panel.addClass('active-panel');

            var winHeight = $(window).height();
            var panelTop = $panel.offset().top;
            var panelHeight = $panel.outerHeight();
            var scrollPos = panelTop - (winHeight / 2) + (panelHeight / 2);

            $('html, body').animate({
                scrollTop: scrollPos
            }, 600, 'swing');
        });

        target.on('hidden.bs.collapse', function() {
            $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $text.text('View Details');
            $btn.removeClass('btn-danger').addClass('btn-primary');
            $panel.removeClass('active-panel');
        });
    });
</script>