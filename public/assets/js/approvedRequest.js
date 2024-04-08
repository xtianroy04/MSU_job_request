document.addEventListener('DOMContentLoaded', function () {
    const searchAlert = document.getElementById('searchAlert');
    if (searchAlert) {
        searchAlert.addEventListener('closed.bs.alert', function () {
            window.location.href = servicesRoute;
        });
    }
});


function showAssignModal(requestId) {
    $('#requestId').val(requestId); 
    $('#assignPersonnelModal').modal('show');
}

function closeModal() {
    $('#assignPersonnelModal').modal('hide');
}

function assignPersonnel() {
    $('#assignPersonnelForm').submit();
}