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

        //window.location.href = "menu.html";
        fetch("../../server/authentication/login.php", {
            method: "POST"
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        });
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

const orderForm = document.getElementById("orderForm");

if (orderForm) {
    orderForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const orderId = document.getElementById("orderId").value.trim();
        const customerName = document.getElementById("customerName").value.trim();
        const customerAddress = document.getElementById("customerAddress").value.trim();
        const customerEmail = document.getElementById("customerEmail").value.trim();
        const customerPhone = document.getElementById("customerPhone").value.trim();
        const products = document.querySelectorAll('input[name="products[]"]:checked');
        const message = document.getElementById("orderMessage");
        message.textContent = "";
        message.style.color = "red";

        if (
            orderId === "" ||
            customerName === "" ||
            customerAddress === "" ||
            customerEmail === "" ||
            customerPhone === ""
        ) {
            message.textContent = "Please complete all fields.";
            return;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(customerEmail)) {
            message.textContent = "Invalid email address.";
            return;
        }

        const phonePattern = /^[0-9]{9,15}$/;

        if (!phonePattern.test(customerPhone)) {
            message.textContent = "Invalid phone number.";
            return;
        }

        if (products.length === 0) {
            message.textContent = "Select at least one product.";
            return;
        }
        message.style.color = "green";
        message.textContent = "Client validation completed successfully.";
    });
}