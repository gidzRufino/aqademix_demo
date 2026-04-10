<?php
echo link_tag('assets/calendar/fullcalendar.min.css');
?>
<link rel="stylesheet" href="<?php echo base_url('assets/calendar/fullcalendar.print.min.css'); ?>" media="print">

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/calendar/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/calendar/fullcalendar.min.js'); ?>"></script>
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">
            <i class="fa fa-calendar text-primary me-2"></i> School Calendar
        </h4>

        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
            <i class="fa fa-plus me-1"></i> Add Event
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex flex-wrap gap-3 align-items-center small">
            <span class="fw-semibold">Legend:</span>

            <span class="d-flex align-items-center gap-1">
                <span class="badge rounded-pill" style="background:#198754;">&nbsp;</span>
                Regular Event
            </span>

            <span class="d-flex align-items-center gap-1">
                <span class="badge rounded-pill" style="background:#dc3545;">&nbsp;</span>
                Holiday / No Classes
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="calendar" style="min-height:650px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold bg-light">
                Event List
            </div>
            <div class="card-body">
                <div id="list-calendar" style="min-height:600px;"></div>
            </div>
        </div>
    </div>
</div>

<?php
$year  = $this->uri->segment(3) ?? date('Y');
$month = $this->uri->segment(4) ?? date('m');

$events = Modules::run('calendar/getAllEvents', $year, $month);
?>
<script>
$(document).ready(function () {

    const holidayKeywords = ['holiday', 'no class', 'no classes'];

    function isHoliday(categoryName) {
        if (!categoryName) return false;
        categoryName = categoryName.toLowerCase();
        return holidayKeywords.some(k => categoryName.includes(k));
    }

    // ================== LOAD EVENTS ==================
    function loadEvents() {
        return [
            <?php foreach ($events as $e):

                // Holiday = category_id 4
                $isHoliday = ($e->category_id == 4);

                $color = $isHoliday ? '#dc3545' : '#198754';
            ?>
            {
                id: '<?php echo $e->id ?>',
                title: '<?php echo addslashes($e->event) ?>',
                start: '<?php echo $e->event_date ?>',
                color: '<?php echo $color ?>',
                extendedProps: {
                    isHoliday: <?php echo $isHoliday ? 'true' : 'false'; ?>,
                    categoryId: '<?php echo $e->category_id ?>'
                },
                className: '<?php echo $isHoliday ? "fc-holiday" : "fc-regular"; ?>'
            },
            <?php endforeach; ?>
        ];
    }

    // ================== CALENDAR ==================
    $('#calendar').fullCalendar({
        height: 650,
        editable: true,
        selectable: true,
        defaultDate: '<?php echo "$year-$month-01" ?>',

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek'
        },

        events: loadEvents(),

        // Prevent adding events on holidays
        dayClick: function(date) {
            const holiday = $('#calendar').fullCalendar('clientEvents', function (ev) {
                return ev.extendedProps?.isHoliday && ev.start.isSame(date, 'day');
            });

            if (holiday.length) {
                alert('Cannot add events on holidays / no class days.');
                return;
            }

            $('#fromDate').val(date.format('YYYY-MM-DD'));
            $('#toDate').val(date.format('YYYY-MM-DD'));
            $('#addEventModal').modal('show');
        },

        dayRender: function(date, cell) {
            const holiday = $('#calendar').fullCalendar('clientEvents', function (ev) {
                return ev.extendedProps?.isHoliday && ev.start.isSame(date, 'day');
            });

            if (holiday.length) {
                cell.addClass('fc-day-holiday');
            }
        },

        eventDrop: updateEvent,
        eventResize: updateEvent,

        // Tooltip with badge
        eventMouseover: function(event, jsEvent) {
            let badge = event.extendedProps.isHoliday
                ? '<span class="badge bg-danger">Holiday / No Class</span>'
                : '<span class="badge bg-success">Regular Event</span>';

            const tooltip = `
                <div class="fc-tooltip">
                    <strong>${event.title}</strong><br>
                    ${moment(event.start).format('MMMM D, YYYY')}<br>
                    ${badge}
                </div>
            `;

            $('body').append(tooltip);
            $('.fc-tooltip').css({
                top: jsEvent.pageY + 10,
                left: jsEvent.pageX + 10
            });
        },

        eventMousemove: function(jsEvent) {
            $('.fc-tooltip').css({
                top: jsEvent.pageY + 10,
                left: jsEvent.pageX + 10
            });
        },

        eventMouseout: function() {
            $('.fc-tooltip').remove();
        }
    });


// ================== LIST VIEW ==================
$('#list-calendar').fullCalendar({
        header: false,
        defaultView: 'listMonth',
        height: 600,
        defaultDate: '<?php echo "$year-$month-01" ?>',
        events: loadEvents(),

        eventClick: function(event) {
            if (confirm('Delete this event?')) {
                $.get('<?php echo base_url("calendar/deleteEvent/") ?>' + event.id, function () {
                    location.reload();
                });
            }
        }
    });

    // ================== SAVE EVENT ==================
    $('#saveEvent').click(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('calendar/addEvent'); ?>",
            data: {
                event: $('#eventTitle').val(),
                category: $('#eventCategory').val(),
                ev_from: '0800',
                ev_to: '1700',
                fromDate: $('#fromDate').val(),
                toDate: $('#toDate').val(),
                person_involved: 'All',
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (res) {
                if (res === 'success') {
                    alert('Event added');
                    location.reload();
                } else {
                    alert(res);
                }
            },
            error: function () {
                alert('AJAX error');
            }
        });
    });

    // ================== UPDATE EVENT ==================
    function updateEvent(event) {
        $.post('<?php echo base_url("calendar/updateEvent") ?>', {
            id: event.id,
            date: event.start.format('YYYY-MM-DD'),
            csrf_test_name: $.cookie('csrf_cookie_name')
        });
    }

});
</script>
<style>
.fc-holiday {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.fc-regular {
    background-color: #198754 !important;
    border-color: #198754 !important;
}

.fc-day-holiday {
    background: repeating-linear-gradient(
        45deg,
        #f8f9fa,
        #f8f9fa 5px,
        #e9ecef 5px,
        #e9ecef 10px
    );
}

.fc-event {
    cursor: pointer;
}

.fc-tooltip {
    position: absolute;
    z-index: 10001;
    background: #212529;
    color: #fff;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.25);
    pointer-events: none;
    white-space: nowrap;
}

</style>

