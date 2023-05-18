-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 18, 2023 at 10:08 AM
-- Server version: 8.0.33
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaverecne`
--

-- --------------------------------------------------------

--
-- Table structure for table `Available_task_sets`
--

CREATE TABLE `Available_task_sets` (
  `id` int UNSIGNED NOT NULL,
  `task_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
  `id` int UNSIGNED NOT NULL,
  `image_base64` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` text NOT NULL,
  `aisId` int NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `generated_task_sets_count` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Student_task_sets`
--

CREATE TABLE `Student_task_sets` (
  `id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `points_acquired` int UNSIGNED NOT NULL,
  `task_set_id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `state` enum('GENERATED','SUBMITED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tasks`
--

CREATE TABLE `Tasks` (
  `id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `task_set_id` int UNSIGNED NOT NULL,
  `task_text` text NOT NULL,
  `task_image_id` int UNSIGNED DEFAULT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tasks_sets`
--

CREATE TABLE `Tasks_sets` (
  `id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `latex_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `max_points` int UNSIGNED NOT NULL,
  `start_generate_date` datetime DEFAULT NULL,
  `end_generate_date` datetime DEFAULT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Tasks_sets`
--

INSERT INTO `Tasks_sets` (`id`, `created_at`, `latex_text`, `max_points`, `start_generate_date`, `end_generate_date`, `name`) VALUES
(1, '2023-05-18 09:20:35', '\\documentclass[a4paper, 12pt]{article}\r\n\\usepackage[utf8]{inputenc}\r\n\\usepackage[slovak]{babel}\r\n\\usepackage{graphicx}\r\n\\usepackage{amsmath,amssymb,amsfonts}\r\n\r\n\\newenvironment{task}{}{}\r\n\\newenvironment{solution}{\\noindent\\textbf{Riešenie:}}{}\r\n\r\n\r\n\\begin{document}\r\n\r\n\r\n\\section*{O23A7A}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%===============================================================\r\n\r\n\r\n\\section*{O5A67B}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{35}{(2s+5)^2}e^{-6s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{7}{5}-\\dfrac{7}{5}e^{-\\frac{5}{2}(t-6)}-\\dfrac{7}{2}(t-6)e^{-\\frac{5}{2}(t-6)} \\right] \\eta(t-6)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%=============================================================\r\n\r\n\\section*{OAC346}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{12}{(5s+4)^2}e^{-7s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{4}-\\dfrac{3}{4}e^{-\\frac{4}{5}(t-7)}-\\dfrac{3}{5}(t-7)e^{-\\frac{4}{5}(t-7)} \\right] \\eta(t-7)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n\r\n\r\n\\end{document}\r\n', 485, NULL, NULL, 'aaaas'),
(2, '2023-05-18 09:23:02', '\\documentclass[a4paper, 12pt]{article}\r\n\\usepackage[utf8]{inputenc}\r\n\\usepackage[slovak]{babel}\r\n\\usepackage{graphicx}\r\n\\usepackage{amsmath,amssymb,amsfonts}\r\n\r\n\\newenvironment{task}{}{}\r\n\\newenvironment{solution}{\\noindent\\textbf{Riešenie:}}{}\r\n\r\n\r\n\\begin{document}\r\n\r\n\r\n\\section*{O23A7A}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%===============================================================\r\n\r\n\r\n\\section*{O5A67B}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{35}{(2s+5)^2}e^{-6s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{7}{5}-\\dfrac{7}{5}e^{-\\frac{5}{2}(t-6)}-\\dfrac{7}{2}(t-6)e^{-\\frac{5}{2}(t-6)} \\right] \\eta(t-6)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%=============================================================\r\n\r\n\\section*{OAC346}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{12}{(5s+4)^2}e^{-7s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{4}-\\dfrac{3}{4}e^{-\\frac{4}{5}(t-7)}-\\dfrac{3}{5}(t-7)e^{-\\frac{4}{5}(t-7)} \\right] \\eta(t-7)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n\r\n\r\n\\end{document}\r\n', 485, NULL, NULL, 'aaaas'),
(3, '2023-05-18 09:23:14', '\\documentclass[a4paper, 12pt]{article}\r\n\\usepackage[utf8]{inputenc}\r\n\\usepackage[slovak]{babel}\r\n\\usepackage{graphicx}\r\n\\usepackage{amsmath,amssymb,amsfonts}\r\n\r\n\\newenvironment{task}{}{}\r\n\\newenvironment{solution}{\\noindent\\textbf{Riešenie:}}{}\r\n\r\n\r\n\\begin{document}\r\n\r\n\r\n\\section*{O23A7A}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%===============================================================\r\n\r\n\r\n\\section*{O5A67B}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{35}{(2s+5)^2}e^{-6s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{7}{5}-\\dfrac{7}{5}e^{-\\frac{5}{2}(t-6)}-\\dfrac{7}{2}(t-6)e^{-\\frac{5}{2}(t-6)} \\right] \\eta(t-6)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%=============================================================\r\n\r\n\\section*{OAC346}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{12}{(5s+4)^2}e^{-7s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{4}-\\dfrac{3}{4}e^{-\\frac{4}{5}(t-7)}-\\dfrac{3}{5}(t-7)e^{-\\frac{4}{5}(t-7)} \\right] \\eta(t-7)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n\r\n\r\n\\end{document}\r\n', 485, NULL, NULL, 'aaaas'),
(4, '2023-05-18 09:24:12', '\\documentclass[a4paper, 12pt]{article}\r\n\\usepackage[utf8]{inputenc}\r\n\\usepackage[slovak]{babel}\r\n\\usepackage{graphicx}\r\n\\usepackage{amsmath,amssymb,amsfonts}\r\n\r\n\\newenvironment{task}{}{}\r\n\\newenvironment{solution}{\\noindent\\textbf{Riešenie:}}{}\r\n\r\n\r\n\\begin{document}\r\n\r\n\r\n\\section*{O23A7A}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%===============================================================\r\n\r\n\r\n\\section*{O5A67B}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{35}{(2s+5)^2}e^{-6s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{7}{5}-\\dfrac{7}{5}e^{-\\frac{5}{2}(t-6)}-\\dfrac{7}{2}(t-6)e^{-\\frac{5}{2}(t-6)} \\right] \\eta(t-6)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%=============================================================\r\n\r\n\\section*{OAC346}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{12}{(5s+4)^2}e^{-7s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{4}-\\dfrac{3}{4}e^{-\\frac{4}{5}(t-7)}-\\dfrac{3}{5}(t-7)e^{-\\frac{4}{5}(t-7)} \\right] \\eta(t-7)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n\r\n\r\n\\end{document}\r\n', 485, NULL, NULL, 'aaaas'),
(5, '2023-05-18 09:49:48', '\\documentclass[a4paper, 12pt]{article}\r\n\\usepackage[utf8]{inputenc}\r\n\\usepackage[slovak]{babel}\r\n\\usepackage{graphicx}\r\n\\usepackage{amsmath,amssymb,amsfonts}\r\n\r\n\\newenvironment{task}{}{}\r\n\\newenvironment{solution}{\\noindent\\textbf{Riešenie:}}{}\r\n\r\n\r\n\\begin{document}\r\n\r\n\r\n\\section*{O23A7A}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%===============================================================\r\n\r\n\r\n\\section*{O5A67B}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{35}{(2s+5)^2}e^{-6s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{7}{5}-\\dfrac{7}{5}e^{-\\frac{5}{2}(t-6)}-\\dfrac{7}{2}(t-6)e^{-\\frac{5}{2}(t-6)} \\right] \\eta(t-6)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n%=============================================================\r\n\r\n\\section*{OAC346}\r\n\\begin{task}\r\n    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou\r\n    \\begin{equation*}\r\n        F(s)=\\dfrac{12}{(5s+4)^2}e^{-7s}\r\n    \\end{equation*}\r\n\\end{task} \r\n\r\n\\begin{solution}\r\n    \\begin{equation*}\r\n        y(t)=\\left[ \\dfrac{3}{4}-\\dfrac{3}{4}e^{-\\frac{4}{5}(t-7)}-\\dfrac{3}{5}(t-7)e^{-\\frac{4}{5}(t-7)} \\right] \\eta(t-7)\r\n    \\end{equation*}\r\n\\end{solution}\r\n\r\n\r\n\r\n\\end{document}\r\n', 485, NULL, NULL, 'aaaas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Available_task_sets`
--
ALTER TABLE `Available_task_sets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aisId` (`aisId`);

--
-- Indexes for table `Student_task_sets`
--
ALTER TABLE `Student_task_sets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_set_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_set_id` (`task_set_id`),
  ADD KEY `task_image_id` (`task_image_id`);

--
-- Indexes for table `Tasks_sets`
--
ALTER TABLE `Tasks_sets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Available_task_sets`
--
ALTER TABLE `Available_task_sets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Student_task_sets`
--
ALTER TABLE `Student_task_sets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tasks`
--
ALTER TABLE `Tasks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tasks_sets`
--
ALTER TABLE `Tasks_sets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Available_task_sets`
--
ALTER TABLE `Available_task_sets`
  ADD CONSTRAINT `Available_task_sets_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `Tasks_sets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Student_task_sets`
--
ALTER TABLE `Student_task_sets`
  ADD CONSTRAINT `Student_task_sets_ibfk_1` FOREIGN KEY (`task_set_id`) REFERENCES `Tasks_sets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Student_task_sets_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `Students` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD CONSTRAINT `Tasks_ibfk_1` FOREIGN KEY (`task_set_id`) REFERENCES `Tasks_sets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Tasks_ibfk_2` FOREIGN KEY (`task_image_id`) REFERENCES `Images` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
