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

const continueButton = document.getElementById("continueButton");

if (continueButton) {
    continueButton.addEventListener("click", function () {
        const operation = document.getElementById("operation").value;
        window.location.href = operation;
    });
}

const menuButton = document.getElementById("menuButton");

if (menuButton) {
    menuButton.addEventListener("click", function () {
        window.location.href = "menu.html";
    });
}