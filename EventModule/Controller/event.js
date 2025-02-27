// let calendar; // Declare it outside the event listener

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch('/EventModule/Model/events_json_retrieval.php')
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => failureCallback(error));
        },


    });

    calendar.render();
});

function addEventFunction(event) {
    const title = document.getElementById('title').value;
    const location = document.getElementById('location').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const price = document.getElementById('price').value;
    const type = document.getElementById('type').value;

    // Validate input
    if (!title || !location || !date || !time || !price) {
        alert('Please fill in all fields');
        return;
    }

    const eventStart = new Date(`${date}T${time}`);
    const eventData = {
        Title: title,
        Location: location,
        Date: date,
        Time: time,
        Price: price,
        Type: type
    };

    calendar.addEvent({
        title: `${title} - `,
        start: eventStart,
        description: `Location: ${location}\nPrice: $${price}`,
        backgroundColor: type === 'fundraiser' ? 'blue' :
            type === 'workshop' ? 'green' :
                type === 'program' ? 'red' : 'default'
    });

    alert(JSON.stringify(eventData, null, 2));
    alert('Event added to the calendar!');

    fetch('/EventModule/Controller/add_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
        .then(response => {
            console.log("Response status:", response.status);
            return response.text();
        })
        .then(data => {
            console.log("Raw response data:", data);
        })
        .catch(error => console.error('Error:', error));

    alert('oooo added to the calendar!');
    document.getElementById('eventForm').reset();
}
