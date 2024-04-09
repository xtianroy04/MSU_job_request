function updateCheckboxesFromHiddenField() {
    var capabilitiesText = document.querySelector('input[name="roles"]').value;
    var selectedCapabilities = capabilitiesText.split(',').map(function(capability) {
        return capability.trim();
    });

    var checkboxes = document.querySelectorAll('input[name="checkbox[]"]');
    checkboxes.forEach(function(checkbox) {
        switch (checkbox.value) {
            case 'Admin':
                checkbox.checked = selectedCapabilities.includes('Admin');
                break;
            case 'Manager (Approved Service Request)':
                checkbox.checked = selectedCapabilities.includes('Manager1');
                break;
            case 'Manager (Assign Personel)':
                checkbox.checked = selectedCapabilities.includes('Manager2');
                break;
            case 'Requester (Secretary | Chairman)':
                checkbox.checked = selectedCapabilities.includes('Requester');
                break;
            case 'Personnel':
                checkbox.checked = selectedCapabilities.includes('Personnel');
                break;
        }
    });
}

window.onload = function() {
    updateCheckboxesFromHiddenField();
};

function updateHiddenField() {
    var selectedCapabilities = [];
    var checkboxes = document.querySelectorAll('input[name="checkbox[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        switch (checkbox.value) {
            case 'Admin':
                selectedCapabilities.push('Admin');
                break;
            case 'Manager (Approved Service Request)':
                selectedCapabilities.push('Manager1');
                break;
            case 'Manager (Assign Personel)':
                selectedCapabilities.push('Manager2');
                break;
            case 'Requester (Secretary | Chairman)':
                selectedCapabilities.push('Requester');
                break;
            case 'Personnel':
                selectedCapabilities.push('Personnel');
                break;
        }
    });

    document.querySelector('input[name="roles"]').value = selectedCapabilities.join(',');
    
    updateCheckboxesFromHiddenField();
}

var checkboxInputs = document.querySelectorAll('input[name="checkbox[]"]');
checkboxInputs.forEach(function(checkbox) {
    checkbox.addEventListener('click', updateHiddenField);
});
