<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>

    <link rel = "stylesheet" href="new_event.css">
    <!-- Link to Google Places API (Replace YOUR_API_KEY with your actual key) -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

    <!-- Link to FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <link rel="stylesheet" href="styles.css"> <!-- External CSS File -->

    <script>


        function save_event(event){
            console.log("ok new event now added")
        }

        // Initialize the calendar
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: [
                    { title: 'Fundraiser', start: '2024-11-10', color: 'blue' },
                    { title: 'Workshop', start: '2024-11-15', color: 'red' },
                    { title: 'Program', start: '2024-11-20', color: 'green' }
                ]
            });
            calendar.render();
        });
    </script>
</head>
<body>

<h2>Add New Event</h2>
<br>
<!-- Form to add an event -->
<form action="#" method="post">
    <br>
    <label for="event_name">Event Name:</label>
    <input type="text" id="event_name" name="event_name" required><br><br>

    <!-- Location Dropdown with popular places in Cairo, Egypt -->
    <label for="location">Location:</label>
    <select id="location" name="location" required>
        <option value="">Select a Location</option>
        <option value="The Egyptian Museum">The Egyptian Museum</option>
        <option value="Cairo Tower">Cairo Tower</option>
        <option value="Pyramids of Giza">Pyramids of Giza</option>
        <option value="Al-Azhar Park">Al-Azhar Park</option>
        <option value="Khan el-Khalili">Khan el-Khalili</option>
        <option value="Cairo Opera House">Cairo Opera House</option>
        <option value="Citadel of Saladin">Citadel of Saladin</option>
        <option value="Mall of Egypt">Mall of Egypt</option>
        <option value="Downtown Cairo">Downtown Cairo</option>
        <option value="Zamalek District">Zamalek District</option>
        <option value="Maadi District">Maadi District</option>
    </select><br><br>

    <label for="event_date">Date:</label>
    <input type="date" id="event_date" name="event_date" required><br><br>

    <label for="event_time">Time:</label>
    <input type="time" id="event_time" name="event_time" required><br><br>

    <label for="price">Price ($):</label>
    <input type="number" id="price" name="price" step="0.01" required><br><br>

    <!-- Event Type Dropdown (Combobox) -->
    <label for="event_type">Event Type:</label>
    <select id="event_type" name="event_type" required>
        <option value="fundraiser">Fundraiser</option>
        <option value="workshop">Workshop</option>
        <option value="program">Program</option>
    </select><br><br>

    <button type="submit" onclick="save_event(event)">Add Event</button>
</form>

<!-- Calendar container -->
<div id="calendar"></div>

</body>
</html>
