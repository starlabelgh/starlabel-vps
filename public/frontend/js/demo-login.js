(function($) {
    "use strict"; // Start of use strict

    $('#demo-admin').click(function() {
        $('#email').val('admin@example.com');
        $('#password').val('123456');
        $('#password').attr('type','text');
    });

    $('#demo-reception').click(function() {
        $('#email').val('reception@example.com');
        $('#password').val('123456');
        $('#password').attr('type','text');
    });

    $('#demo-employee').click(function() {
        $('#email').val('employee@example.com');
        $('#password').val('123456');
        $('#password').attr('type','text');
    });
})(jQuery); // End of use strict
