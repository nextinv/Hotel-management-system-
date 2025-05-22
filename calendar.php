<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Booking Calendar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales-all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <style>
    body { background: #f8f9fa; }
    #calendar { background: #fff; padding: 20px; border-radius: 10px; }
  </style>
</head>
<body>

<div class="container mt-4">
  <h3>📅 Booking Calendar View</h3>
  <div id="calendar"></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: "auto",
      locale: 'en',
      events: 'ajax/fetch_bookings.php',
      eventColor: '#0d6efd',
      eventTextColor: '#fff',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      eventClick: function(info) {
        alert("Room: " + info.event.title + "\nGuest: " + info.event.extendedProps.guest + "\nCheck-in: " + info.event.startStr + "\nCheck-out: " + info.event.endStr);
      }
    });
    calendar.render();
  });
</script>

</body>
</html>
