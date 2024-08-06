document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const messageContainer = document.querySelector(".message");
    
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result.includes("Note uploaded successfully")) {
                showMessage("success", "Note uploaded successfully");
            } else if (result.includes("Error uploading file") || result.includes("Error:")) {
                showMessage("error", "An error occurred while uploading the file. Please try again.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage("error", "An unexpected error occurred. Please try again.");
        });
    });

    function showMessage(type, message) {
        messageContainer.className = `message ${type}`;
        messageContainer.textContent = message;
    }
});
