// Enable Bootstrap 5 Popovers for this page
    document.addEventListener("DOMContentLoaded", function(event) { 
        // Select all elements with attribute 'data-bs-toggle="popover"'
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        
        // Enable all selected elements as bootstrap popover
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
        });
    });