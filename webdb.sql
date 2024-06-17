
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

CREATE TABLE `users` (
  `u_id` int NOT NULL,
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