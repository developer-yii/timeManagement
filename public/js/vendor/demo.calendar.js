! function(l) {
    "use strict";

    function e() {
        this.$body = l("body"), this.$calendar = l("#calendar"), this.$formEvent = l("#form-event"), this.$btnNewEvent = l("#btn-new-event"), this.$btnDeleteEvent = l("#btn-delete-event"), this.$btnSaveEvent = l("#btn-save-event"), this.$modalTitle = l("#modal-title"), this.$calendarObj = null, this.$selectedEvent = null, this.$newEventData = null
    }
    e.prototype.onSelect = function(e) {
        this.$formEvent[0].reset(), this.$formEvent.removeClass("was-validated"), this.$selectedEvent = null, this.$newEventData = e, this.$btnDeleteEvent.hide(), this.$modalTitle.text("Add New Event"), this.$modal.show(), this.$calendarObj.unselect()
    }, e.prototype.init = function() {
        var e = new Date(l.now());
        var t = data_json,
            a = this;
        a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
            eventClick: function(info) {
            var eventObj = info.event;
            
            if (eventObj.extendedProps.log_id) {
                var log_ide = eventObj.extendedProps.log_id;
                $.ajax({
                    url: detailUrl+'?id='+log_ide,
                    type: 'GET',
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == true) {
                            $('#add-form').find('#student_id').val(result.data.student_id);
                            $('#add-form').find('#subject_id').val(result.data.subject_id);
                            $('#add-form').find('#log_date').val(result.data.log_date);
                            $('#add-form').find('#log_time').val(result.data.log_time);
                            $('#add-form').find('#start_time').val(result.data.start_time);
                            $('#add-form').find('#end_time').val(result.data.end_time);
                            $('#add-form').find("textarea#activity_notes").val(result.data.activity_notes); 
                            $('#add-form-lable').html('View Student Time Log');
                            $('#add-form').find('button[type="submit"]').hide();
                            if(result.data.is_attendance)
                                $('#add-form').find('#attendance').prop('checked',true);                                
                            $('.error').html("");                        
                            $("#add-modal").modal("show");
                        } else {                        
                            
                        }
                    },
                    error: function(error) {
                        console.log('error')
                    }
                });                                   
                info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
              } else {
                    var hId = eventObj.extendedProps.holiday_id;
                    $.ajax({
                        url: holidayDetailUrl+'?id='+hId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            $('#edit-modal').modal('show');
                            $('#edit-form').find('#edit_start_date').val(result.data.start_date);
                            $('#edit-form').find('#edit_end_date').val(result.data.end_date);
                            $('#edit-form').find('#edit_note').val(result.data.note);
                            $('#edit-form').find('#edit_event_color').val(result.data.event_color);
                            $('#edit_modal').html('');
                            $('#edit_modal').html(result.data.studentName);
                            document.querySelector('#edit_event_color').dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });
              }
            },
            slotDuration: "00:15:00",
            slotMinTime: "08:00:00",
            slotMaxTime: "19:00:00",
            themeSystem: "bootstrap",
            bootstrapFontAwesome: !1,
            buttonText: {
                today: "Today",
                month: "Month",
                week: "Week",
                day: "Day",
                list: "List",
                prev: "Prev",
                next: "Next"
            },
            initialView: "dayGridMonth",
            handleWindowResize: !0,
            height: l(window).height() - 200,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth"
                // right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialEvents: t,
            editable: !0,
            droppable: !0,
            selectable: !0,
            dateClick: function(e) {
                a.onSelect(e)
            }
        }), a.$calendarObj.render(), a.$btnNewEvent.on("click", function(e) {
            a.onSelect({
                date: new Date,
                allDay: !0
            })
        }), l(a.$btnDeleteEvent.on("click", function(e) {
            a.$selectedEvent && (a.$selectedEvent.remove(), a.$selectedEvent = null, a.$modal.hide())
        }))
    }, l.CalendarApp = new e, l.CalendarApp.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.CalendarApp.init()
}();