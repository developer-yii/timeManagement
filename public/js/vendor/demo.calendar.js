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
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
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