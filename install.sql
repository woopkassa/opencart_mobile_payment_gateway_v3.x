CREATE TABLE IF NOT EXISTS `wooppay_mobile_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `wooppay_transaction_id`  CHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;