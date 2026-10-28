const documentationButton = document.getElementById("documentationButton");

if (documentationButton) {
    documentationButton.addEventListener("click", function () {
        window.location.href = "documentation.html";
    });
}

const loginButton = document.getElementById("loginButton");

if (loginButton) {
    loginButton.addEventListener("click", function () {
        window.location.href = "login.html";
    });
}

const homeButton = document.getElementById("homeButton");

if (homeButton) {
    homeButton.addEventListener("click", function () {
        window.location.href = "index.html";
    });
}

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

        window.location.href = "menu.html";
    });
}

const continueButton = document.getElementById("continueButton");

if (continueButton) {
    continueButton.addEventListener("click", function () {
        const operation = document.getElementById("operation").value;
        window.location.href = operation;
    });
}