
    let calendar;

    // Initialize the calendar
    document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth'
},
    events: function(fetchInfo, successCallback, failureCallback) {
        // AJAX call to get events from PHP
        fetch('../Model/load_events.php')
            .then(response => response.json())
            .then(data => successCallback(data))
            .catch(error => failureCallback(error));
    }
});
    calendar.render();
});

    function addEventFunction(event) {


    const eventName = document.getElementById('event_name').value;
    const location = document.getElementById('location').value;
    const eventDate = document.getElementById('event_date').value;
    const eventTime = document.getElementById('event_time').value;
    const price = document.getElementById('price').value;
    // const eventType = document.getElementById('event_type').value;
    console.log(eventDate)
    // Validate input
    if (!eventName || !location || !eventDate || !eventTime || !price ) {
    alert('Please fill in all fields');
    return;
}

    const eventStart = new Date(`${eventDate}T${eventTime}`);
    eventData = {
        title: eventName,
        location : location,
        date: eventDate,
        eventTime: eventTime,
        price: price
    };
        console.log(eventData)
    // Add event to FullCalendar
    calendar.addEvent({
    title: `${eventName} - `,
    start: eventStart,
    description: `Location: ${location}\nPrice: $${price}`,
    color: 'blue'
});

    alert('Event added to the calendar!');
    fetch('../Controller/add_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
        .then(response => response.text())  // Use text() to inspect raw response first
        .then(data => {
            console.log("Raw data:", data);  // Log the raw response to check for issues
            const jsonData = JSON.parse(data);  // Parse JSON manually
            if (jsonData.success) {
                alert("Event added successfully!");
            } else {
                alert("Failed to add event: " + jsonData.message);
            }
        })
        .catch(error => console.error('Error:', error));

        document.getElementById('eventForm').reset();
}