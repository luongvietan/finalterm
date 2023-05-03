create database CuoiKy

use CuoiKy 

CREATE TABLE products (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE agents (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT
);

CREATE TABLE orders (
    id INT PRIMARY KEY,
    order_date DATE NOT NULL,
    agent_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (agent_id) REFERENCES agents(id)
);

CREATE TABLE order_items (
    id INT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE goods_received (
    id INT PRIMARY KEY,
    received_date DATE NOT NULL,
    quantity_received INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE goods_delivery_note (
    id INT PRIMARY KEY,
    delivery_date DATE NOT NULL,
    agent_id INT NOT NULL,
    quantity_delivered INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (agent_id) REFERENCES agents(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE revenue_report (
    id INT PRIMARY KEY,
    report_date DATE NOT NULL,
    product_id INT NOT NULL,
    total_sales DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (id, name, description, price, quantity)
VALUES 
    (1, 'iPhone X', 'Apple smartphone', 1000, 20),
    (2, 'Samsung Galaxy S10', 'Samsung smartphone', 900, 30),
    (3, 'Google Pixel 4', 'Google smartphone', 800, 25),
    (4, 'Huawei P30', 'Huawei smartphone', 700, 35),
    (5, 'Xiaomi Mi 9', 'Xiaomi smartphone', 600, 40),
    (6, 'OnePlus 7T', 'OnePlus smartphone', 650, 30),
    (7, 'LG G8 ThinQ', 'LG smartphone', 750, 25),
    (8, 'Sony Xperia 1', 'Sony smartphone', 900, 20),
    (9, 'Motorola Moto G7', 'Motorola smartphone', 400, 50),
    (10, 'Nokia 7.2', 'Nokia smartphone', 350, 60),
    (11, 'JBL Flip 5', 'Bluetooth speaker', 100, 80),
    (12, 'Beats Solo3', 'Wireless headphones', 200, 40),
    (13, 'Sony WH-1000XM3', 'Noise-cancelling headphones', 300, 30),
    (14, 'Apple AirPods Pro', 'Wireless earbuds', 250, 50),
    (15, 'Samsung Galaxy Watch', 'Samsung smartwatch', 300, 25),
    (16, 'Apple Watch Series 5', 'Apple smartwatch', 400, 20),
    (17, 'Fitbit Versa 2', 'Fitness tracker', 150, 70),
    (18, 'Garmin Forerunner 945', 'GPS running watch', 500, 15),
    (19, 'GoPro HERO8 Black', 'Action camera', 400, 30),
    (20, 'DJI Mavic Air 2', 'Drone', 800, 10),
    (21, 'HP Pavilion 15', 'Laptop', 800, 15),
    (22, 'Dell XPS 13', 'Ultrabook', 1200, 10),
    (23, 'Apple MacBook Air', 'Mac laptop', 1000, 20),
    (24, 'Lenovo ThinkPad X1 Carbon', 'Business laptop', 1500, 10),
    (25, 'Samsung Galaxy Tab S6', 'Samsung tablet', 600, 25),
    (26, 'Apple iPad Pro', 'iPad tablet', 800, 20),
    (27, 'Microsoft Surface Pro 7', 'Surface tablet', 900, 15),
    (28, 'Amazon Kindle Oasis', 'E-reader', 250, 40),
    (29, 'Canon EOS R', 'Mirrorless camera', 2000, 5),
    (30, 'Nikon D850', 'DSLR camera', 3000, 5);

select * from products

	INSERT INTO agents (id, name, email, phone, address)
VALUES
    (1, 'John Doe', 'johndoe@example.com', '+1 555-555-1234', '123 Main St'),
    (2, 'Jane Smith', 'janesmith@example.com', '+1 555-555-5678', '456 Elm St'),
    (3, 'Bob Johnson', 'bobjohnson@example.com', '+1 555-555-9012', '789 Oak St'),
    (4, 'Sara Lee', 'saralee@example.com', '+1 555-555-3456', '321 Pine St'),
    (5, 'Mike Williams', 'mikewilliams@example.com', '+1 555-555-7890', '654 Maple St'),
    (6, 'Linda Brown', 'lindabrown@example.com', '+1 555-555-2345', '987 Cedar St'),
    (7, 'Dave Wilson', 'davewilson@example.com', '+1 555-555-6789', '246 Oakwood Ave'),
    (8, 'Karen Davis', 'karendavis@example.com', '+1 555-555-1234', '1356 Willow Rd'),
    (9, 'Tom Johnson', 'tomjohnson@example.com', '+1 555-555-5678', '2468 Cedar Ave'),
    (10, 'Cathy Martin', 'cathymartin@example.com', '+1 555-555-9012', '13579 Elmwood Dr'),
    (11, 'Steve Baker', 'stevebaker@example.com', '+1 555-555-3456', '24680 Main St'),
    (12, 'Debbie Jackson', 'debbiejackson@example.com', '+1 555-555-7890', '24680 Elm St'),
    (13, 'Bill Clark', 'billclark@example.com', '+1 555-555-2345', '13579 Cedar St'),
    (14, 'Susan Johnson', 'susanjohnson@example.com', '+1 555-555-6789', '2468 Willow Rd'),
    (15, 'Joe Davis', 'joedavis@example.com', '+1 555-555-1234', '1357 Oakwood Ave'),
    (16, 'Jenny Lee', 'jennylee@example.com', '+1 555-555-5678', '24680 Willow Dr'),
    (17, 'Mark Jones', 'markjones@example.com', '+1 555-555-9012', '13579 Cedar Ave'),
    (18, 'Lisa Green', 'lisagreen@example.com', '+1 555-555-3456', '2468 Maple St'),
    (19, 'Mike Brown', 'mikebrown@example.com', '+1 555-555-7890', '1357 Elm St'),
    (20, 'Julie Wilson', 'juliewilson@example.com', '+1 555-555-2345', '24680 Cedar St'),
    (21, 'David Johnson', 'davidjohnson@example.com', '+1 555-555-6789', '13579 Main St'),
    (22, 'Amy Martin', 'amymartin@example.com', '+1 555-555-1234', '2468 Oakwood Ave'),
    (23, 'Robert Davis', 'robertdavis@example.com', '+1 555-555-5678', '1357 Willow Rd'),
	(24, 'Emily Smith', 'emilysmith@example.com', '+1 555-555-9012', '24680 Elmwood Dr'),
    (25, 'Greg Wilson', 'gregwilson@example.com', '+1 555-555-3456', '13579 Main St'),
    (26, 'Tina Lee', 'tinalee@example.com', '+1 555-555-7890', '2468 Oakwood Ave'),
    (27, 'Eric Johnson', 'ericjohnson@example.com', '+1 555-555-2345', '1357 Cedar St'),
    (28, 'Mandy Martin', 'mandymartin@example.com', '+1 555-555-6789', '24680 Maple St'),
    (29, 'Chris Davis', 'chrisdavis@example.com', '+1 555-555-1234', '13579 Elm St'),
    (30, 'Rachel Green', 'rachelgreen@example.com', '+1 555-555-5678', '2468 Cedar Ave');

select * from agents

	INSERT INTO orders (id, order_date, agent_id, payment_method, payment_status, total_amount)
VALUES
    (1, '2022-01-01', 1, 'Credit card', 'Paid', 1500.00),
    (2, '2022-01-02', 2, 'Cash on delivery', 'Pending', 2700.00),
    (3, '2022-01-03', 3, 'Debit card', 'Paid', 800.00),
    (4, '2022-01-04', 4, 'PayPal', 'Paid', 1400.00),
    (5, '2022-01-05', 5, 'Credit card', 'Paid', 600.00),
    (6, '2022-01-06', 6, 'Cash on delivery', 'Pending', 1950.00),
    (7, '2022-01-07', 7, 'Debit card', 'Paid', 1500.00),
    (8, '2022-01-08', 8, 'PayPal', 'Paid', 1800.00),
    (9, '2022-01-09', 9, 'Credit card', 'Paid', 2000.00),
    (10, '2022-01-10', 10, 'Cash on delivery', 'Pending', 2100.00),
    (11, '2022-01-11', 1, 'Debit card', 'Paid', 900.00),
    (12, '2022-01-12', 2, 'PayPal', 'Paid', 1200.00),
    (13, '2022-01-13', 3, 'Credit card', 'Paid', 300.00),
    (14, '2022-01-14', 4, 'Cash on delivery', 'Pending', 1600.00),
    (15, '2022-01-15', 5, 'Debit card', 'Paid', 750.00),
    (16, '2022-01-16', 6, 'PayPal', 'Paid', 850.00),
    (17, '2022-01-17', 7, 'Credit card', 'Paid', 1100.00),
    (18, '2022-01-18', 8, 'Cash on delivery', 'Pending', 1450.00),
    (19, '2022-01-19', 9, 'Debit card', 'Paid', 2500.00),
    (20, '2022-01-20', 10, 'PayPal', 'Paid', 1750.00),
    (21, '2022-01-21', 1, 'Credit card', 'Paid', 1000.00),
    (22, '2022-01-22', 2, 'Cash on delivery', 'Pending', 900.00),
    (23, '2022-01-23', 3, 'Debit card', 'Paid', 1200.00),
    (24, '2022-01-24', 4, 'PayPal', 'Paid', 800.00),
    (25, '2022-01-25', 5, 'Credit card', 'Paid', 600.00),
    (26, '2022-01-26', 6, 'Cash on delivery', 'Pending', 120),
	(27, '2022-01-22', 2, 'Cash on delivery', 'Pending', 900.00),
    (28, '2022-01-23', 3, 'Debit card', 'Paid', 1200.00),
    (29, '2022-01-24', 4, 'PayPal', 'Paid', 800.00),
    (30, '2022-01-25', 5, 'Credit card', 'Paid', 600.00);

	

INSERT INTO order_items (id, order_id, product_id, quantity, unit_price)
VALUES 
(1, 1, 1, 2, 10.99),
(2, 1, 3, 1, 19.99),
(3, 1, 5, 3, 7.99),
(4, 2, 2, 1, 8.99),
(5, 2, 4, 2, 12.50),
(6, 3, 1, 1, 10.99),
(7, 3, 2, 2, 8.99),
(8, 3, 6, 1, 25.99),
(9, 4, 3, 3, 19.99),
(10, 4, 4, 1, 12.50),
(11, 4, 5, 2, 7.99),
(12, 5, 1, 1, 10.99),
(13, 5, 6, 1, 25.99),
(14, 5, 7, 2, 16.99),
(15, 6, 2, 1, 8.99),
(16, 6, 4, 3, 12.50),
(17, 7, 1, 2, 10.99),
(18, 7, 3, 1, 19.99),
(19, 8, 4, 1, 12.50),
(20, 8, 5, 2, 7.99),
(21, 8, 7, 3, 16.99),
(22, 9, 1, 1, 10.99),
(23, 9, 2, 2, 8.99),
(24, 9, 6, 1, 25.99),
(25, 10, 3, 3, 19.99),
(26, 10, 4, 1, 12.50),
(27, 10, 5, 2, 7.99),
(28, 11, 1, 1, 10.99),
(29, 11, 6, 1, 25.99),
(30, 11, 7, 2, 16.99);


INSERT INTO goods_received (id, received_date, quantity_received, product_id) VALUES 
(1, '2022-01-01', 100, 1),
(2, '2022-01-02', 75, 2),
(3, '2022-01-03', 50, 3),
(4, '2022-01-04', 25, 4),
(5, '2022-01-05', 20, 5),
(6, '2022-01-06', 30, 6),
(7, '2022-01-07', 15, 7),
(8, '2022-01-08', 10, 8),
(9, '2022-01-09', 5, 9),
(10, '2022-01-10', 100, 10),
(11, '2022-01-11', 75, 11),
(12, '2022-01-12', 50, 12),
(13, '2022-01-13', 25, 13),
(14, '2022-01-14', 20, 14),
(15, '2022-01-15', 30, 15),
(16, '2022-01-16', 15, 16),
(17, '2022-01-17', 10, 17),
(18, '2022-01-18', 5, 18),
(19, '2022-01-19', 100, 19),
(20, '2022-01-20', 75, 20),
(21, '2022-01-21', 50, 21),
(22, '2022-01-22', 25, 22),
(23, '2022-01-23', 20, 23),
(24, '2022-01-24', 30, 24),
(25, '2022-01-25', 15, 25),
(26, '2022-01-26', 10, 26),
(27, '2022-01-27', 5, 27),
(28, '2022-01-28', 100, 28),
(29, '2022-01-29', 75, 29),
(30, '2022-01-30', 50, 30);

select * from products

select * from agents

select * from orders

select * from order_items

select * from goods_received 