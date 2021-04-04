-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2021 at 09:14 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `turktrade_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `date_opened` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `balance` double(10,2) NOT NULL,
  `available_balance` double(10,2) NOT NULL,
  `overdraft_limit` double(10,2) NOT NULL,
  `defined_overdraft_limit` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_number_count`
--

CREATE TABLE `account_number_count` (
  `id` int(11) NOT NULL,
  `account_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_status_record`
--

CREATE TABLE `account_status_record` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_transaction_history`
--

CREATE TABLE `account_transaction_history` (
  `id` int(11) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(100) NOT NULL,
  `before_balance` double(10,2) NOT NULL,
  `after_balance` double(10,2) NOT NULL,
  `amount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_verification`
--

CREATE TABLE `account_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `country_name` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(36) NOT NULL,
  `currency` varchar(39) NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form_session`
--

CREATE TABLE `form_session` (
  `id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `description` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_deposit_session`
--

CREATE TABLE `fund_deposit_session` (
  `id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_deposit_session_payment_id`
--

CREATE TABLE `fund_deposit_session_payment_id` (
  `id` int(11) NOT NULL,
  `funds_session_token` varchar(200) NOT NULL,
  `stripe_id` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_transfer_log`
--

CREATE TABLE `fund_transfer_log` (
  `id` int(11) NOT NULL,
  `account_from_transaction_id` varchar(200) NOT NULL,
  `account_to_transaction_id` varchar(200) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_transfer_session`
--

CREATE TABLE `fund_transfer_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `transfer_type` tinyint(4) NOT NULL,
  `account_from` varchar(10) NOT NULL,
  `account_to` varchar(10) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `completed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_change`
--

CREATE TABLE `password_change` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `new_password` varchar(200) NOT NULL,
  `email_code` varchar(8) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_recovery`
--

CREATE TABLE `password_recovery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `utoken` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_history`
--

CREATE TABLE `portfolio_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `utoken` varchar(200) NOT NULL,
  `date_updated` datetime NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile_picture`
--

CREATE TABLE `profile_picture` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `directory` varchar(500) NOT NULL,
  `original_name` varchar(500) NOT NULL,
  `date_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `security` varchar(100) NOT NULL,
  `gics_sector` varchar(100) NOT NULL,
  `gics_sub` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_buy_session`
--

CREATE TABLE `stock_buy_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date_data` datetime NOT NULL,
  `stock_code` varchar(10) NOT NULL,
  `price_per_stock` double(10,2) NOT NULL,
  `total_price` double(10,2) NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `account_debited` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_prices`
--

CREATE TABLE `stock_prices` (
  `id` int(11) NOT NULL,
  `stock_code` varchar(6) NOT NULL,
  `stock_current` double(10,2) NOT NULL,
  `stock_high` double(10,2) NOT NULL,
  `stock_low` double(10,2) NOT NULL,
  `stock_open` double(10,2) NOT NULL,
  `previous_close` double(10,2) NOT NULL,
  `value_date` datetime NOT NULL,
  `pulled_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_sell_session`
--

CREATE TABLE `stock_sell_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `date_data` datetime NOT NULL,
  `stock_code` varchar(10) NOT NULL,
  `price_per_stock` double(10,2) NOT NULL,
  `total_price` double(10,2) NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `account_credited` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transaction_log`
--

CREATE TABLE `stock_transaction_log` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_type` varchar(4) NOT NULL,
  `portfolio_token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transaction_type`
--

CREATE TABLE `stock_transaction_type` (
  `id` int(11) NOT NULL,
  `type` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(512) NOT NULL,
  `last_name` varchar(512) NOT NULL,
  `email` varchar(512) NOT NULL,
  `date_of_birth` datetime NOT NULL,
  `address` varchar(512) NOT NULL,
  `city` varchar(512) NOT NULL,
  `state` varchar(512) NOT NULL,
  `country` int(11) NOT NULL,
  `postal_code` varchar(512) NOT NULL,
  `password` varchar(512) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `account_number` (`account_number`);

--
-- Indexes for table `account_number_count`
--
ALTER TABLE `account_number_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_status_record`
--
ALTER TABLE `account_status_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`user_id`);

--
-- Indexes for table `account_transaction_history`
--
ALTER TABLE `account_transaction_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number` (`account_number`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `account_verification`
--
ALTER TABLE `account_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `form_session`
--
ALTER TABLE `form_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fund_deposit_session`
--
ALTER TABLE `fund_deposit_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number` (`account_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `fund_deposit_session_payment_id`
--
ALTER TABLE `fund_deposit_session_payment_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funds_session_token` (`funds_session_token`);

--
-- Indexes for table `fund_transfer_log`
--
ALTER TABLE `fund_transfer_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_from_transaction_id` (`account_from_transaction_id`),
  ADD KEY `account_to_transaction_id` (`account_to_transaction_id`);

--
-- Indexes for table `fund_transfer_session`
--
ALTER TABLE `fund_transfer_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_from` (`account_from`),
  ADD KEY `account_to` (`account_to`);

--
-- Indexes for table `password_change`
--
ALTER TABLE `password_change`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `utoken` (`utoken`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `portfolio_history`
--
ALTER TABLE `portfolio_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_id` (`stock_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symbol` (`symbol`);

--
-- Indexes for table `stock_buy_session`
--
ALTER TABLE `stock_buy_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_code` (`stock_code`),
  ADD KEY `account_debited` (`account_debited`),
  ADD KEY `stock_buy_session_ibfk_1` (`user_id`);

--
-- Indexes for table `stock_prices`
--
ALTER TABLE `stock_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_code` (`stock_code`);

--
-- Indexes for table `stock_sell_session`
--
ALTER TABLE `stock_sell_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_creditted` (`account_credited`),
  ADD KEY `stock_code` (`stock_code`);

--
-- Indexes for table `stock_transaction_log`
--
ALTER TABLE `stock_transaction_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `stock_id` (`stock_id`),
  ADD KEY `transaction_type` (`transaction_type`),
  ADD KEY `portfolio_token` (`portfolio_token`);

--
-- Indexes for table `stock_transaction_type`
--
ALTER TABLE `stock_transaction_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`country`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_number_count`
--
ALTER TABLE `account_number_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_status_record`
--
ALTER TABLE `account_status_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_transaction_history`
--
ALTER TABLE `account_transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_verification`
--
ALTER TABLE `account_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_session`
--
ALTER TABLE `form_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_deposit_session`
--
ALTER TABLE `fund_deposit_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_deposit_session_payment_id`
--
ALTER TABLE `fund_deposit_session_payment_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_transfer_log`
--
ALTER TABLE `fund_transfer_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_transfer_session`
--
ALTER TABLE `fund_transfer_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_change`
--
ALTER TABLE `password_change`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_recovery`
--
ALTER TABLE `password_recovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_history`
--
ALTER TABLE `portfolio_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_picture`
--
ALTER TABLE `profile_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_buy_session`
--
ALTER TABLE `stock_buy_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_prices`
--
ALTER TABLE `stock_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_sell_session`
--
ALTER TABLE `stock_sell_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transaction_log`
--
ALTER TABLE `stock_transaction_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transaction_type`
--
ALTER TABLE `stock_transaction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `currency` (`code`);

--
-- Constraints for table `account_status_record`
--
ALTER TABLE `account_status_record`
  ADD CONSTRAINT `account_status_record_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `account_transaction_history`
--
ALTER TABLE `account_transaction_history`
  ADD CONSTRAINT `account_transaction_history_ibfk_1` FOREIGN KEY (`account_number`) REFERENCES `accounts` (`account_number`);

--
-- Constraints for table `account_verification`
--
ALTER TABLE `account_verification`
  ADD CONSTRAINT `account_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `fund_deposit_session`
--
ALTER TABLE `fund_deposit_session`
  ADD CONSTRAINT `fund_deposit_session_ibfk_1` FOREIGN KEY (`account_number`) REFERENCES `accounts` (`account_number`),
  ADD CONSTRAINT `fund_deposit_session_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `fund_deposit_session_payment_id`
--
ALTER TABLE `fund_deposit_session_payment_id`
  ADD CONSTRAINT `fund_deposit_session_payment_id_ibfk_1` FOREIGN KEY (`funds_session_token`) REFERENCES `fund_deposit_session` (`token`);

--
-- Constraints for table `fund_transfer_log`
--
ALTER TABLE `fund_transfer_log`
  ADD CONSTRAINT `fund_transfer_log_ibfk_1` FOREIGN KEY (`account_from_transaction_id`) REFERENCES `account_transaction_history` (`transaction_id`),
  ADD CONSTRAINT `fund_transfer_log_ibfk_2` FOREIGN KEY (`account_to_transaction_id`) REFERENCES `account_transaction_history` (`transaction_id`);

--
-- Constraints for table `fund_transfer_session`
--
ALTER TABLE `fund_transfer_session`
  ADD CONSTRAINT `fund_transfer_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `fund_transfer_session_ibfk_2` FOREIGN KEY (`account_from`) REFERENCES `accounts` (`account_number`),
  ADD CONSTRAINT `fund_transfer_session_ibfk_3` FOREIGN KEY (`account_to`) REFERENCES `accounts` (`account_number`);

--
-- Constraints for table `password_change`
--
ALTER TABLE `password_change`
  ADD CONSTRAINT `password_change_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD CONSTRAINT `password_recovery_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `portfolio_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`);

--
-- Constraints for table `portfolio_history`
--
ALTER TABLE `portfolio_history`
  ADD CONSTRAINT `portfolio_history_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `portfolio_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD CONSTRAINT `profile_picture_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `stock_buy_session`
--
ALTER TABLE `stock_buy_session`
  ADD CONSTRAINT `stock_buy_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `stock_buy_session_ibfk_2` FOREIGN KEY (`stock_code`) REFERENCES `stocks` (`symbol`),
  ADD CONSTRAINT `stock_buy_session_ibfk_3` FOREIGN KEY (`account_debited`) REFERENCES `accounts` (`account_number`);

--
-- Constraints for table `stock_prices`
--
ALTER TABLE `stock_prices`
  ADD CONSTRAINT `stock_prices_ibfk_1` FOREIGN KEY (`stock_code`) REFERENCES `stocks` (`symbol`);

--
-- Constraints for table `stock_sell_session`
--
ALTER TABLE `stock_sell_session`
  ADD CONSTRAINT `stock_sell_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `stock_sell_session_ibfk_2` FOREIGN KEY (`account_credited`) REFERENCES `accounts` (`account_number`),
  ADD CONSTRAINT `stock_sell_session_ibfk_3` FOREIGN KEY (`stock_code`) REFERENCES `stocks` (`symbol`);

--
-- Constraints for table `stock_transaction_log`
--
ALTER TABLE `stock_transaction_log`
  ADD CONSTRAINT `stock_transaction_log_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `account_transaction_history` (`transaction_id`),
  ADD CONSTRAINT `stock_transaction_log_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `stock_transaction_log_ibfk_3` FOREIGN KEY (`transaction_type`) REFERENCES `stock_transaction_type` (`type`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`country`) REFERENCES `country` (`country_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
