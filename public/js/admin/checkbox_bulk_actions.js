$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $('#check_all').on('ifChecked', function (event) {
        $('.check').iCheck('check');
        triggeredByChild = false;
    });

    $('#check_all').on('ifUnchecked', function (event) {
        if (!triggeredByChild) {
            $('.check').iCheck('uncheck');
        }
        triggeredByChild = false;
    });
    // Removed the checked state from "All" if any checkbox is unchecked
    $('.check').on('ifUnchecked', function (event) {
        triggeredByChild = true;
        $('#check_all').iCheck('uncheck');
    });

    $('.check').on('ifChecked', function (event) {
        if ($('.check').filter(':checked').length == $('.check').length) {
            $('#check_all').iCheck('check');
        }
    });
});