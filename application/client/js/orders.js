// Get the order form
const orderForm = document.getElementById("orderForm");

if (orderForm) {

    orderForm.addEventListener("submit", function (event) {
        event.preventDefault();

        // Get customer information
        const orderId = document.getElementById("orderId").value.trim();
        const customerName = document.getElementById("customerName").value.trim();
        const customerAddress = document.getElementById("customerAddress").value.trim();
        const customerEmail = document.getElementById("customerEmail").value.trim();
        const customerPhone = document.getElementById("customerPhone").value.trim();

        const products = document.querySelectorAll('input[name="products[]"]:checked');
        const message = document.getElementById("orderMessage");

        message.textContent = "";
        message.style.color = "red";

        // Check required fields
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

        // Validate email and phone
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

        // Check that at least one product is selected
        if (products.length === 0) {
            message.textContent = "Select at least one product.";
            return;
        }

        // Get selected products
        const selectedProducts = [];

        if (document.getElementById("nike").checked) {
            selectedProducts.push({
                product: "Nike Air Max 270",
                price: 120,
                quantity: Number(document.getElementById("nikeQuantity").value)
            });
        }

        if (document.getElementById("adidas").checked) {
            selectedProducts.push({
                product: "Adidas Samba",
                price: 95,
                quantity: Number(document.getElementById("adidasQuantity").value)
            });
        }

        if (document.getElementById("converse").checked) {
            selectedProducts.push({
                product: "Converse Chuck Taylor",
                price: 70,
                quantity: Number(document.getElementById("converseQuantity").value)
            });
        }

        if (document.getElementById("newbalance").checked) {
            selectedProducts.push({
                product: "New Balance 530",
                price: 110,
                quantity: Number(document.getElementById("newBalanceQuantity").value)
            });
        }

        // Send the order to PHP
        fetch("../../server/orders/createOrder.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                orderId: orderId,
                customerName: customerName,
                customerAddress: customerAddress,
                customerEmail: customerEmail,
                customerPhone: customerPhone,
                products: selectedProducts
            })
        })
        .then(response => response.json())
        .then(data => {

            message.style.color = data.success ? "green" : "red";

            if (data.success) {

                // Show the order information returned by PHP
                message.innerHTML =
                    "<strong>" + data.message + "</strong><br><br>" +
                    "Subtotal: €" + data.data.subtotal.toFixed(2) + "<br>" +
                    "VAT (21%): €" + data.data.vat.toFixed(2) + "<br>" +
                    "<strong>Total: €" + data.data.total.toFixed(2) + "</strong>";

            } else {

                // Show the error message
                message.textContent = data.message;

            }

        })
        .catch(() => {

            message.style.color = "red";
            message.textContent = "An error occurred while creating the order.";

        });
        });
}