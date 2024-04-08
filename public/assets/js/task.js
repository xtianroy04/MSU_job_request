document.addEventListener('DOMContentLoaded', function () {
    const searchAlert = document.getElementById('searchAlert');
    if (searchAlert) {
        searchAlert.addEventListener('closed.bs.alert', function () {
            window.location.href = servicesRoute;
        });
    }
});
