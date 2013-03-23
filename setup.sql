CREATE TABLE `cars` (
  `id` int(9) NOT NULL auto_increment,
  `slug` varchar(100) NOT NULL,
  `year` int(4) NOT NULL,
  `make` varchar(100),
  `model` varchar(100),
  `trim` varchar(100),
  `retired_on` date,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `car_services` (
  `id` int(9) NOT NULL auto_increment,
  `car_id` int(9) NOT NULL,
  `mileage` varchar(7),
  `serviced_at` datetime,
  `serviced_by` varchar(100),
  `service_cost` decimal(9,2) NOT NULL default '0.00',
  `parts` varchar(255),
  `parts_cost` decimal(9,2) NOT NULL default '0.00',
  `parts_from` varchar(100),
  `service_details` text,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB;