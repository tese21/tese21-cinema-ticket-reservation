// admin_dashboard.js
$(document).ready(function () {
    $('.button-collapse').sideNav();
    $('.collapsible').collapsible();
    $('.dropdown-button').dropdown();

    $('#menu-toggle').click(function () {
        $('#slide-out').toggleClass('open');
        $(this).attr('aria-expanded', $('#slide-out').hasClass('open')); // Update aria-expanded
    });

    // Logo Toggle (Optional - If you want the logo to also toggle the sidebar)
    $('#toggle-logo').click(function () {
        $('#slide-out').toggleClass('open');
        $('#menu-toggle').attr('aria-expanded', $('#slide-out').hasClass('open')); // Update aria-expanded on menu too

        // Optional: Smooth logo rotation with CSS transition (add rotated class to CSS)
        $(this).toggleClass('rotated');
    });


    // Close the side nav if clicking outside on smaller screens (optional)
    $('body').click(function (event) {
        if ($(window).width() < 993 && $('#slide-out').hasClass('open') && !$(event.target).closest('#slide-out').length && !$(event.target).closest('#menu-toggle').length && !$(event.target).closest('#toggle-logo').length) {
            $('#slide-out').removeClass('open');
            $('#menu-toggle').attr('aria-expanded', false); // Update aria-expanded
            $('#toggle-logo').removeClass('rotated');
        }
    });

});
$(document).ready(function () {
    // Initialize collapsible menus
    $('.collapsible').collapsible();

    // Initialize sidebar
    $('.sidenav').sidenav();

    // Toggle Sidebar on Menu Button Click
    $('#menu-toggle').click(function () {
        var instance = M.Sidenav.getInstance($('#slide-out'));
        instance.open();
    });

    // Make sidebar draggable
    $("#slide-out").draggable({
        axis: "x",
        containment: "body"
    });
});
