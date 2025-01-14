function validatePhoneNumber(input) {
    const errorMessage = document.getElementById("error-message");
    const phonePattern = /^0\d{9}$/;

    if (!phonePattern.test(input.value)) {
        errorMessage.style.display = "block";
    } else {
        errorMessage.style.display = "none";
    }
}