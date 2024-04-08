document.addEventListener('DOMContentLoaded', function () {
    const searchAlert = document.getElementById('searchAlert');
    if (searchAlert) {
        searchAlert.addEventListener('closed.bs.alert', function () {
            window.location.href = servicesRoute;
        });
    }
});

// Approve Button
function showApproveConfirmationModal() {
    $('#confirmationApproveModal').modal('show');
}
function closeApproveModal() {
    $('#confirmationApproveModal').modal('hide');
}
function submitApproveForm() {
    $('#approveForm').submit();
}


// Decline Button
function showConfirmationModal() {
    $('#confirmationModal').modal('show');
}
function closeModal() {
    $('#confirmationModal').modal('hide');
}
function submitDeclineForm() {
    $('#declineForm').submit();
}

