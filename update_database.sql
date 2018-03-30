CREATE TABLE `se_booking` (
  `booking_id` int(11) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `office_id` int(11) NOT NULL DEFAULT '0',
  `money` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `state_receive` tinyint(1) NOT NULL DEFAULT '1',
  `fee_ticket` int(11) NOT NULL DEFAULT '0',
  `fee_fuel` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_execute` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `se_booking`
  ADD PRIMARY KEY (`booking_id`);

ALTER TABLE `se_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `se_booking` CHANGE `office_id` `manufacturer_id` INT(11) NOT NULL DEFAULT '0';