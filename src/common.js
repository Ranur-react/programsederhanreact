// Token csrf protection
function resetToken(token) {
    $('input[name=csrf_token]').val(token);
    $("#csrf_token,.csrf_token").val(token);
}