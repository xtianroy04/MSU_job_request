document.addEventListener('DOMContentLoaded', function () {
    const searchAlert = document.getElementById('searchAlert');
    if (searchAlert) {
        searchAlert.addEventListener('closed.bs.alert', function () {
            window.location.href = servicesRoute;
        });
    }
});

// Done Button
function showConfirmationModal() {
    $('#doneServiceModal').modal('show');
}
function closeModal() {
    $('#doneServiceModal').modal('hide');
}
function done() {
    $('#Form').submit();
}
