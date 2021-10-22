
document.addEventListener("DOMContentLoaded", function(event) { 
 
    document.getElementById('sidebarCollapse').onclick = function()
    {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('content').classList.toggle('active');
    };

    document.querySelectorAll('.more-button, .body-overlay').onclick = function()
    {
        document.querySelectorAll('#sidebar, .body-overlay').classList.toggle('show-nav');
    }
});