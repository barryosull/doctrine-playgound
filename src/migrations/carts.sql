CREATE TABLE `carts` (
  `customer_id` varchar(255) NOT NULL DEFAULT '',
  `cart_id` varchar(255) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;