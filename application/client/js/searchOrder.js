const searchForm = document.getElementById("searchForm");

if (searchForm) {
    searchForm.addEventListener("submit", function (event) {
        // Prevent page reload
        event.preventDefault();

        const orderId = document.getElementById("orderId").value.trim();
        const message = document.getElementById("searchMessage");

        message.textContent = "";
        message.style.color = "red";

        // Check that the ID is not empty
        if (orderId === "") {
            message.textContent = "Order ID is required.";
            return;
        }

        // Send the order ID to PHP
        fetch("../../server/orders/searchOrder.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                orderId: orderId
            })
        })

        .then(response => response.json())

        .then(data => {
            message.style.color = data.success ? "green" : "red";
            if (data.success) {
                message.textContent =
                    "Order found: " +
                    data.data.customerName +
                    " | Total: " +
                    data.data.total + " €";
            } else {
                message.textContent = data.message;
            }
        });
    });
}