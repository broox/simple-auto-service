$('tbody#serviceLogs tr').click(function() {
    var url = $(this).data('service-url');
    if (url) { window.location.href = url; }
});

$('.btn-retire').click(function() {
    var confirmation = $(this).data('confirmation');
    if (confirmation) {
        var response = confirm(confirmation);
        if (response !== true)
            return false;
    }
});
