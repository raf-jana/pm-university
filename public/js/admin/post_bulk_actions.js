function post_action(type) {
    if (type != 'export' && $('.check').filter(':checked').length == 0) {
        alert('Please select the post to ' + type);
        return false;
    }
    if (confirm('Are you sure want to ' + type + '?')) {
        $('#action_type').val(type);
        $('#post_form').submit();
    }
}