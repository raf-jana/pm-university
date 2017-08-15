function article_action(type) {
    if (type != 'export' && $('.check').filter(':checked').length == 0) {
        alert('Please select the article to ' + type);
        return false;
    }
    if (confirm('Are you sure want to ' + type + '?')) {
        $('#action_type').val(type);
        $('#article_form').submit();
    }
}