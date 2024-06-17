CREATE DATABASE food_menu;

USE food_menu;

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50),
    name VARCHAR(100),
    price DECIMAL(10, 2),
    image text(255),
    description VARCHAR(255)
);

INSERT INTO menu_items (category, name, price, image, description) VALUES
('pasta', 'Spaghetti Bolognese', 20.00, 'spaghetti-bolognese.jpg', "Delicious Bolognese sauce served with spaghetti."),
('pasta', 'Spaghetti Carbonara', 25.00, 'spaghetti-carbonara.jpg',"Creamy carbonara sauce with pancetta."), 
('pasta', 'Spaghetti Meatball', 18.00, 'spaghetti-meatball.jpg',"Classic meatballs served with spaghetti."),
('pasta', 'Spaghetti Aglio Olio', 20.00, 'spaghetti-aglio-olio.jpg', "Simple yet flavorful garlic and olive oil pasta."),
('pasta', 'Creamy Cheese Spaghetti', 25.00, 'spaghetti-creamy-cheese.jpg',"Rich and creamy cheese sauce over spaghetti." ),
('pasta', 'Spaghetti Marinara', 30.00, 'spaghetti-marinara.jpg',"Fresh tomato marinara sauce over spaghetti."),
('burgers', 'Italian Chicken Burger', 25.00, 'italian-chicken-burger.jpg',"Grilled chicken patty with Italian seasoning."),
('burgers', 'Cheesy Beef Burger', 28.00, 'cheesy-beef-burger.jpg', "Beef patty with melted cheese and special sauce." ),
('burgers', 'Mexican Spicy Chicken Burger', 30.00, 'mexican-spicy-chicken-burger.jpg', "Spicy grilled chicken with Mexican flavors."),
('burgers', 'Classic Cheese Burger', 17.00, 'classic-cheese-burger.jpg',  "All-time favorite burger with cheddar cheese." ),
('burgers', 'Southwestern Beef Burger', 25.00, 'southwestern-beef-burger.jpg', "Beef patty with southwestern spices and toppings."),
('burgers', 'Smoked Turkey Burger', 25.00, 'smoked-turkey-burger.jpg', "Smoked turkey patty with fresh vegetables."),
('desserts', 'Oreo Cheesecake', 12.00, 'oreo-cheesecake.jpg', "Creamy cheesecake with Oreo cookies."),
('desserts', 'Brownie Salted Caramel Cheesecake', 15.00, 'brownie-salted-caramel-cheesecake.jpg',"Warm chocolate cake with a molten center."),
('desserts', 'Molten Lava Cake', 13.00, 'molten-lava-cake.jpg', "Warm chocolate cake with a molten center."),
('desserts', 'Earl Grey Mille Crepe', 11.00, 'earl-grey-mille-crepe.jpg', "Delicate Earl Grey layers."),
('desserts', 'Strawberry Crepe Cake', 10.00, 'strawberry-crepe-cake.jpg', "Fresh strawberry delight."),
('desserts', 'Matcha Crepe Cake', 17.00, 'matcha-crepe-cake.jpg', "Creamy matcha delight." ),
('beverages', 'Iced Cappuccino', 12.00, 'iced-cappuccino.jpg', "Chilled espresso blend." ),
('beverages', 'Iced Latte', 12.00, 'iced-latte.jpg', "Cool, smooth coffee."),
('beverages', 'Peach Ice Tea', 10.00, 'peach-ice-tea.jpg', "Crisp, peachy refreshment."),
('beverages', 'Iced Mocha', 12.00, 'iced-mocha.jpg',  "Icy mocha goodness." ),
('beverages', 'Mango Frappe', 15.00, 'mango-frappe.jpg', "Frosty mango treat."),
('beverages', 'Strawberry Frappe', 15.00, 'strawberry-frappe.jpg', "Chilled berry bliss." );

CREATE TABLE user_cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_items_id INT,
    quantity INT,
    FOREIGN KEY (menu_items_id) REFERENCES menu_items(id)
);

-- CREATE TABLE user_cart_items (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     menu_items_id INT,
--     user_id INT,
--     FOREIGN KEY (menu_items_id) REFERENCES menu_items(id),
--     FOREIGN KEY (user_id) REFERENCES users(id)
-- );

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

CREATE TABLE `users` (
  `u_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`u_id`, `role`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(001, 'admin', 'admin', 'Jocelyn', 'Aslan', 'admin@gmail.com', '1234567890', '1234', 'M01, KTDI, 80990, Johor Bahru, Johor', 1, '2023-02-22 07:18:13');

ALTER TABLE `users`
  MODIFY `u_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;