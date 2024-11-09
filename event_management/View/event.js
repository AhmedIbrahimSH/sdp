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
    events: [
{ title: 'Fundraiser', start: '2024-11-10', color: 'blue' },
{ title: 'Workshop', start: '2024-11-15', color: 'red' },
{ title: 'Program', start: '2024-11-20', color: 'green' }
    ]
});
    calendar.render();
});

    // JavaScript function to handle the button click and add event to calendar
    function addEventFunction(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get form values
    const eventName = document.getElementById('event_name').value;
    const location = document.getElementById('location').value;
    const eventDate = document.getElementById('event_date').value;
    const eventTime = document.getElementById('event_time').value;
    const price = document.getElementById('price').value;
    const eventType = document.getElementById('event_type').value;

    // Validate input
    if (!eventName || !location || !eventDate || !eventTime || !price || !eventType) {
    alert('Please fill in all fields');
    return;
}

    // Combine date and time for event start
    const eventStart = new Date(`${eventDate}T${eventTime}`);

    // Add event to FullCalendar
    calendar.addEvent({
    title: `${eventName} - ${eventType}`,
    start: eventStart,
    description: `Location: ${location}\nPrice: $${price}`,
    color: 'blue'
});

    // Display confirmation message
    alert('Event added to the calendar!');

    // Optionally, reset the form
    document.getElementById('eventForm').reset();
}