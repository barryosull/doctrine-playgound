CREATE TABLE `cart_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;