START TRANSACTION;
CREATE TABLE IF NOT EXISTS `api_users` (
    `id` int(11) NOT NULL,
    `username` varchar(256) COLLATE utf8mb4_bin NOT NULL,
    `password` varchar(256) COLLATE utf8mb4_bin NOT NULL,
    `token` varchar(512) COLLATE utf8mb4_bin DEFAULT NULL,
    `last_login` timestamp NULL DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `students` (
    `id` int(11) NOT NULL,
    `api_user_id` int(11) NOT NULL,
    `Name` varchar(256) COLLATE utf8mb4_bin NOT NULL,
    `StudentGroup` varchar(256) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

ALTER TABLE `api_users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `students` ADD PRIMARY KEY (`id`), ADD KEY `api_user_id` (`api_user_id`);

ALTER TABLE `api_users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `students` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `students` ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`api_user_id`) REFERENCES `api_users` (`id`);

INSERT INTO `api_users` (`id`, `username`, `password`, `token`, `last_login`) VALUES
(1, 'username', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(2, 'un1', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(3, 'un2', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(6, 'un8', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(7, 'un3', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(8, 'un9', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(9, 'un4', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(10, 'un10', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(11, 'un5', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(12, 'un11', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(13, 'un6', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(14, 'un12', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL),
(15, 'un7', '$2y$10$JxKlFw5cQi7F4hdqIhYGY.113e4nzGw61tZ/kfPsxLEAzNUN9l0HW', NULL, NULL);

INSERT INTO `students` (`id`, `api_user_id`, `Name`, `StudentGroup`) VALUES
(1, 1, 'Franco May', NULL),
(2, 2, 'Samantha Martinez', NULL),
(3, 3, 'Areebah Walls', NULL),
(4, 6, 'Leona Phelps', NULL),
(5, 7, 'Esme Blake', NULL),
(6, 8, 'Teri Garza', NULL),
(7, 9, 'Nataniel Lester', NULL),
(8, 10, 'Tye Sweet', NULL),
(9, 11, 'Darlene Farmer', NULL),
(10, 12, 'Zac Wilkerson', NULL),
(11, 13, 'Jonny Sargent', NULL),
(12, 14, 'Toby Best', NULL),
(13, 15, 'Meg Davison', NULL);

COMMIT;
