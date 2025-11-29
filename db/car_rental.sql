-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 15, 2025 lúc 08:29 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `car_rental`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `image`, `author`, `created_at`) VALUES
(13, 'Why Renting is Better Than Buying in 2025', 'Car ownership comes with numerous hidden costs including depreciation, maintenance, insurance, and taxes. In contrast, renting a vehicle provides flexibility, especially for those who don’t drive daily. With rentals, you can choose the right car for each occasion – a compact for city driving or an SUV for road trips. Furthermore, rental services cover maintenance and often provide access to newer models with better fuel efficiency and safety features. For modern urban lifestyles, renting can be smarter both financially and practically.', 'blog-1.jpg', 'Liam Tran', '2025-06-24'),
(14, 'Top 5 Family Cars to Rent This Summer', 'Looking for a family vacation vehicle? Here are the top picks: 1) Toyota Innova – spacious and reliable. 2) Kia Carnival – luxury meets practicality. 3) Ford Everest – perfect for off-road trips. 4) Hyundai Santa Fe – safety features plus comfort. 5) Mitsubishi Xpander – affordable yet roomy. Each model offers unique advantages depending on your needs.\r\n', 'blog-2.jpg', 'Emma Le', '2025-06-24'),
(15, 'What to Do If You Damage a Rental Car?', 'Stay calm. First, ensure everyone is safe. Then, take clear photos of the damage, the scene, and any third-party vehicles. Contact your rental company immediately and follow their instructions. Avoid repairing the car yourself. Depending on your agreement and insurance, you may or may not be liable. Full guide inside.\r\n', 'blog-3.jpg', 'Noah Nguyen', '2025-06-24'),
(16, 'Benefits of Electric Vehicle Rentals', 'EV rentals are becoming more popular, especially in urban areas with good charging infrastructure. They are quiet, eco-friendly, and offer lower operating costs. Before renting, check the charging network in your area and understand how long full charging takes. Many companies provide apps for locating chargers. Also, familiarize yourself with regenerative braking and EV-specific controls. Renting an EV is also a great way to try before you buy.\r\n', 'blog-4.png', 'Mia Pham', '2025-06-20'),
(17, 'Should You Get Rental Car Insurance?', 'Travel insurance may not cover rental cars. Consider purchasing coverage if you lack credit card protection or are traveling internationally.\r\n', 'blog-5.png', 'Lucas Hoang', '2025-06-15'),
(18, 'Tips for Renting Cars on a Budget', 'Book early, use discount codes, compare prices online, and avoid airport pickup surcharges. Consider fuel policies and avoid unnecessary extras.\r\n', 'blog-6.jpg', 'Olivia Vo', '2025-06-10'),
(19, 'How to Choose the Right Car for Your Trip', 'Sedans are great for city driving, SUVs for families or off-road, hatchbacks for budget travelers. Consider space, fuel economy, and terrain.\r\n', 'blog-7.png', 'William Do', '2025-06-05'),
(20, 'Is Renting Long-Term Cheaper Than Leasing?', 'Long-term rentals offer flexibility with no long-term contract obligations, especially for travelers, expatriates, or seasonal workers. Leasing often involves a fixed period and penalties for early termination. However, renting may cost more per month. We analyze which is better based on your usage, location, and duration.\r\n', 'blog-8.png', 'Sophia Nguyen', '2025-05-30'),
(21, 'Common Mistakes to Avoid When Renting', 'Check for damages before driving. Read fuel and mileage policies. Don’t forget to carry all documents and inspect the spare tire.\r\n', 'blog-9.png', 'James Bui', '2025-05-25'),
(22, 'How to Book a Car with a Driver Included', 'Many services now offer rental cars with drivers for extra convenience. Great for tourists or business travelers. Booking is usually through premium services or direct agency contact.\r\n', 'blog-10.png', 'Isabella Truong', '2025-05-20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_date` datetime NOT NULL DEFAULT current_timestamp(),
  `pickup_location` varchar(255) NOT NULL,
  `dropoff_location` varchar(255) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `voucher_code` varchar(50) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `price_per_hour` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `model`, `year`, `seats`, `price_per_hour`, `image`, `status`, `description`) VALUES
(2, '', 'Toyota', 'Camry', 2025, 4, 800000.00, 'toyota-camry-2025.jpg', 'available', 'It is performance'),
(3, '', 'Toyota', 'Raize', 2025, 7, 850000.00, 'toyota-raize-2025.jpg', 'available', 'Perfect'),
(5, '', 'Mercedes-Benz', 'C300', 2025, 4, 1000000.00, 'mercedes-benz-c300-2025.png', 'available', 'It is powerfull'),
(7, '', 'Mercedes-Benz', 'GLC300', 2025, 4, 950000.00, 'mercedes-benz-glc300-2025.png', 'available', 'It is model'),
(8, '', 'Mercedes-Benz', 'GLE300', 2025, 4, 900000.00, 'mercedes-benz-gle53-2025.png', 'available', 'It saves more pertrol'),
(9, '', 'Huyndai', 'Elantra', 2025, 4, 650000.00, 'hyundai-elantra-2025.png', 'available', 'It is normal'),
(10, '', 'Huyndai', 'Tucson', 2022, 5, 550000.00, 'hyundai-tucson-2022.png', 'available', 'Not really good'),
(11, '', 'Mercedes-Benz', 'S450', 2025, 5, 1350000.00, 'mercedes-benz-s450-2025.png', 'available', 'Wow, it is amazing'),
(12, '', 'Huyndai', 'Tucson', 2024, 5, 550000.00, 'hyundai-tucson-2024.png', 'available', 'It is nothing to say about'),
(17, '', 'Honda', 'City', 2023, 5, 200000.00, 'honda-city-2023.png', 'available', 'It is a good choice'),
(19, '', 'Honda', 'CR-V', 2025, 6, 220000.00, 'honda-cr-v-2025.jpg', 'available', 'It is a good choice'),
(20, '', 'Toyota', 'Vios', 2023, 5, 700000.00, 'toyota-vios-2023.png', 'available', 'It is the best choice'),
(45, '', 'Honda', 'BR-V', 2025, 6, 500000.00, 'sieu-xe-oto-yamaha-sport-ride-motosaigon-17.jpg', 'available', ''),
(46, '', 'Honda', 'Civic e:HEV RS', 2025, 5, 7.00, 'honda-cr-v-2025.jpg', 'available', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `project` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `name`, `position`, `image`, `facebook`, `twitter`, `linkedin`, `bio`) VALUES
(1, 'John Smith', 'Fleet Manager', 'employee1.jpg', 'https://facebook.com/johnsmith', 'https://twitter.com/johnsmith', 'https://linkedin.com/in/johnsmith', 'John has over 10 years of experience managing transportation fleets.'),
(2, 'Emily Davis', 'Customer Support', 'employee2.jpg', 'https://facebook.com/emilydavis', '', 'https://linkedin.com/in/emilydavis', 'Dedicated to assisting customers with a smile.'),
(3, 'Michael Lee', 'Technician', 'employee3.jpg', 'https://www.facebook.com/phanchi.tinh', '', '', 'Expert in maintaining and repairing luxury vehicles.'),
(4, 'Sophia Brown', 'Marketing Specialist', 'employee4.jpg', 'https://facebook.com/sophiabrown', 'https://twitter.com/sophiabrown', '', 'Handles promotions and branding.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `booking_id` INT(11) NOT NULL,
  `rating` TINYINT(1) NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `vehicle_feedback` ENUM('Terrible', 'Below Average', 'Acceptable', 'Comfortable', 'Excellent') DEFAULT NULL,
  `staff_feedback` ENUM('Unhelpful', 'Inattentive', 'Average', 'Friendly', 'Outstanding') DEFAULT NULL,
  `policy_feedback` ENUM('Unclear', 'Confusing', 'Average', 'Clear', 'Very Clear') DEFAULT NULL,
  `price_feedback` ENUM('Too Expensive', 'Expensive', 'Fair', 'Affordable', 'Great Deal') DEFAULT NULL,
  `comments` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(100),
  `password` VARCHAR(255),
  `role` ENUM('admin', 'customer') NOT NULL,
  `full_name` VARCHAR(100),
  `phone` VARCHAR(20),
  `address` TEXT,
  `image` VARCHAR(255)
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `usage_limit` int(11) DEFAULT 1,
  `used_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_percent`, `expiry_date`, `usage_limit`, `used_count`) VALUES
(1, 'WELCOME10', 10.00, '2025-12-31', 100, 3),
(2, 'VIP30', 30.00, '2025-09-30', 10, 4),
(3, 'SUMMER20', 20.00, '2025-08-31', 50, 0),
(4, 'SUPER45', 45.00, '2025-08-31', 10, 1),
(7, 'SUPER56', 65.00, '2025-06-18', 10, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `car_id_2` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT cho bảng `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
