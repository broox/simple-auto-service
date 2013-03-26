$('tbody#serviceLogs tr').click(function() {
    var url = $(this).data('service-url');
    if (url) { window.location.href = url; }
});
