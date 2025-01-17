    document.querySelectorAll('.node').forEach(node => {
    node.addEventListener('click', function () {
        // Get the route from the data-route attribute
        const route = this.getAttribute('data-route');

        // Redirect to the route
        if (route) {
            window.location.href = route;
        } else {
            alert('No route defined for this node.');
        }
    });
});
