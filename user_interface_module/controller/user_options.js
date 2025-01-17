// Fetch user data from the server (using AJAX) and alert the user ID
fetch('../controller/controller.php') // Replace with your PHP file that returns session data
    .then(response => response.json())
    .then(data => {
        const userId = data.user_id ?? 'No User ID'; // Get user_id from the response
        alert("User ID: " + userId);
    })
    .catch(error => console.error('Error fetching user data:', error));


document.querySelectorAll('.node').forEach(node => {

    node.addEventListener('click', function () {
        const route = this.getAttribute('data-route');

        if (route) {
            window.location.href = route;
        } else {
            alert('No route defined for this node.');
        }
    });



});


