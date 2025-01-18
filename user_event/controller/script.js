function attendEvent(event_id, user_id) {
    // Create the data object
    var eventData = {
        attend: "true",
        event_id: event_id,
        user_id: user_id
    };
    alert(JSON.stringify(eventData));
    fetch("/user_event/controller/attending_controller.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
        .then(response => response.text())
        .then(result => {
            if (result === "success") {
                alert("Successfully registered for the event!");
                location.reload();
            } else {
                alert("Error registering for the event.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
}
