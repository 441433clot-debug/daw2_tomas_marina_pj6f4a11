//console.log("login.js loaded");
const loginForm = document.getElementById("loginForm");
if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        if (username === "" || password === "") {
            document.getElementById("message").textContent =
                "Please complete all fields.";
            return;
        }

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
        .then(response => response.json())
        .then(data => {

            const message = document.getElementById("message");
            message.textContent = data.message;

        if (data.success) {
            message.style.color = "green";
            message.textContent = data.message;
            setTimeout(function () {
                window.location.href = "menu.html";
            }, 800);
        } else {
            message.style.color = "red";
            message.textContent = data.message;
        }
        });
    });
    }