
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


