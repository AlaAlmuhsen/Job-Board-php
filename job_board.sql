-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 30, 2023 at 04:52 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_board`
--

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id`, `title`, `description`, `recruiter_id`) VALUES
(1, 'lorem', 'lorem lorem', 59),
(2, 'lorem', 'lorem lorem', 59);

--
-- Dumping data for table `job_application`
--

INSERT INTO `job_application` (`id`, `job_id`, `seeker_id`, `created_at`) VALUES
(1, 1, 56, '2023-10-30 15:22:34'),
(2, 1, 58, '2023-10-30 15:47:09'),
(3, 2, 56, '2023-10-30 15:56:36');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `auth_key`, `type`) VALUES
(56, 'ahdemadds', 'ahmedaadd@gmail.com', '$2y$13$QdxjhySigreSyhLdDEuG5OuiF/xn/CGlB93lZ3.xEFXTfeGpJgpBu', 'BlvNbk6fvFi9joVNVEmo_tfezrWsCXTH', 2),
(58, 'ahdemadds', 'ahmedaaddd@gmail.com', '$2y$13$XeD7XTGIkfRwkk6UFhzH/uuIHPoK28oyoHFaWdDo2mPvPJ8fSQPS6', '7bFcusnznyj9isZ-8bFbNho4k8KB_fgl', 1),
(59, 'cc', 'cc@gmail.com', '$2y$13$K9CJY03saHmO2t9zdt7SRe1.UZRywKdSPId84X3FQGRHBHNoxKbE6', 'LEEP3h3HjphnWTuqSnGtcO6gFOY5_UWK', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
