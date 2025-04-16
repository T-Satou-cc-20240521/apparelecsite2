window.onpageshow = function(event) {
    if (event.persisted) {
        const passwordField = document.querySelector('input[name="password"]');
        if (passwordField) {
            passwordField.value = '';
        }

        const errorMessages = document.querySelectorAll('.error_message');
        errorMessages.forEach(function(error) {
            error.remove();
        });

        const inputFields = document.querySelectorAll('input');
        inputFields.forEach(function(input) {
            input.blur();
            input.value = input.value; 
        });
    }
};