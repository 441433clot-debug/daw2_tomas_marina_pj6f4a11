// Get the login form
const loginForm = document.getElementById("loginForm");

// Check that the form exists before using it
if (loginForm) {

    // Execute this code when the form is submitted
    loginForm.addEventListener("submit", function (event) {

        // Prevent the page from reloading
        event.preventDefault();

        // Read the values entered by the user
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        // Get the message element
        const message = document.getElementById("message");

        // Check that all fields are completed
        if (username === "" || password === "") {
            message.style.color = "red";
            message.textContent = "Please complete all fields.";
            return;
        }

        // Send the login information to PHP
        fetch("../../server/authentication/login.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                username: username,
                password: password
            })

        })

        // Read the JSON response
        .then(response => response.json())

        .then(data => {

            if (data.success) {

                // Login successful
                message.style.color = "green";
                message.textContent = data.message;

                // Wait a moment and open the operations menu
                setTimeout(function () {
                    window.location.href = "menu.html";
                }, 800);

            } else {

                // Login failed
                message.style.color = "red";
                message.textContent = data.message;

                // Return to the home page after showing the error
                setTimeout(function () {
                    window.location.href = "index.html";
                }, 1500);
            }
        });
    });
}