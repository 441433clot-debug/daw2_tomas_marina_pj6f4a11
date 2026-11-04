# ShoeStore Order Management Application

## Description

This project is a web application developed for managing customer orders in a shoe store.

Employees can log in, create new orders and consult previously stored orders.

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- JSON
- Apache
- HTTPS

## Main Features

### Authentication
Employees must log in using a username and password.

### Create Orders
Employees can:
- Enter customer information.
- Select shoe products and quantities.
- Create new orders.
- Calculate the subtotal, 21% VAT and final price.

### View Orders
Employees can:
- View all stored orders.
- Search for a specific order using its ID.
- Consult customer and product information.

## Data Storage

Orders are stored in the following JSON file:

`orders/orders.json`

User information is stored in:

`users/users.json`

## Installation and Execution

1. Install XAMPP.
2. Copy the project folder into the `htdocs` directory.
3. Start Apache from the XAMPP Control Panel.
4. Open the application using:

`https://localhost/orderManagementApp/application/client/html/index.html`

## Project Structure

- `application/client/`: HTML, CSS and JavaScript files.
- `application/server/`: PHP server-side files.
- `orders/`: JSON file containing customer orders.
- `users/`: JSON file containing user information.

## Marina Tomas

DAW2 Project