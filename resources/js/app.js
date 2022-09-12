import './bootstrap';
$(document).ready(function () {
    $("#product-add").submit(function (e) {
        $("#btn-submit").attr('disabled', true);
        return true;
    });
});
