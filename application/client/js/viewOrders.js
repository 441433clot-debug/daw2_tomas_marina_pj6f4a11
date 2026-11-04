// Load all orders when the page is opened
fetch("../../server/orders/viewOrders.php")

    .then(response => response.json())
    .then(data => {
        const ordersContainer = document.getElementById("ordersContainer");

        // Remove previous content
        ordersContainer.innerHTML = "";

        if (!data.success) {
            ordersContainer.innerHTML = "<p>No orders found.</p>";
            return;
        }
        // Show every stored order
        data.data.forEach(order => {
            ordersContainer.innerHTML += `
                <div class="orderCard">
                    <h3>Order ${order.orderId}</h3>
                    <p><strong>Customer:</strong> ${order.customerName}</p>
                    <p><strong>Email:</strong> ${order.customerEmail}</p>
                    <p><strong>Phone:</strong> ${order.customerPhone}</p>
                    <p><strong>Total:</strong> €${order.total}</p>
                    <hr>
                </div>
            `;
        });
    });