CREATE DATABASE your_database;

USE your_database;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item VARCHAR(255) NOT NULL,
    qty INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    date DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL
);

INSERT INTO orders (item, qty, price, date, status) VALUES
('Spaghetti Bolognese', 1, 21.20, '2024-09-07 22:47:10', 'Served'),
('Chicken Sandwich', 2, 15.00, '2024-09-08 12:30:25', 'Preparing'),
('Vegetable Salad', 1, 10.50, '2024-09-08 13:15:45', 'Cancelled');
