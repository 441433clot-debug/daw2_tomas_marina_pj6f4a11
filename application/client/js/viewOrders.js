// Get the form elements
const viewOrdersForm = document.getElementById("viewOrdersForm");
const viewOption = document.getElementById("viewOption");
const orderIdContainer = document.getElementById("orderIdContainer");
const orderIdInput = document.getElementById("orderId");
const ordersContainer = document.getElementById("ordersContainer");

// Show or hide the order ID input
viewOption.addEventListener("change", () => {
    const isSingleOrder = viewOption.value === "single";

    orderIdContainer.style.display = isSingleOrder ? "block" : "none";
    orderIdInput.required = isSingleOrder;
});

// Send the selected query to PHP
viewOrdersForm.addEventListener("submit", (event) => {
    event.preventDefault();

    // Check that an ID was entered for a single order
    if (viewOption.value === "single" && orderIdInput.value.trim() === "") {
        ordersContainer.innerHTML = "<p>Please enter an order ID.</p>";
        return;
    }

    // Build the URL depending on the selected option
    let url = "../../server/orders/viewOrders.php";

    if (viewOption.value === "single") {
        url += "?orderId=" + encodeURIComponent(orderIdInput.value.trim());
    }

    // Request the orders from PHP
    fetch(url)
        .then(response => response.text())
        .then(html => {
            ordersContainer.innerHTML = html;
        })
        .catch(() => {
            ordersContainer.innerHTML = "<p>An error occurred while loading orders.</p>";
        });
});
