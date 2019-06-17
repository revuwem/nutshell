-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 17 2019 г., 09:33
-- Версия сервера: 5.6.41
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `nutshellchat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chat_groups`
--

CREATE TABLE `chat_groups` (
  `chat_group_id` int(11) NOT NULL COMMENT 'уникальный код группы',
  `chat_name` text NOT NULL COMMENT 'название группы',
  `chat_group_creator` int(11) NOT NULL COMMENT 'создатель',
  `timestamp_created` timestamp NOT NULL COMMENT 'дата создания',
  `photo` varchar(500) NOT NULL DEFAULT 'pics/societe.png' COMMENT 'ссылка на фото в папке на сервере'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `chat_groups`
--

INSERT INTO `chat_groups` (`chat_group_id`, `chat_name`, `chat_group_creator`, `timestamp_created`, `photo`) VALUES
(1, 'СПП', 3, '2019-06-13 18:59:20', 'pics/societe.png'),
(2, 'СПП', 3, '2019-06-13 18:59:53', 'pics/societe.png'),
(3, 'СПП', 3, '2019-06-13 19:00:29', 'pics/societe.png'),
(4, 'группа №1', 3, '2019-06-13 19:02:32', 'pics/societe.png'),
(5, 'Разработка', 6, '2019-06-17 06:23:42', 'pics/societe.png');

--
-- Триггеры `chat_groups`
--
DELIMITER $$
CREATE TRIGGER `after_insert_chat_groups` AFTER INSERT ON `chat_groups` FOR EACH ROW INSERT INTO chat_groups_participants VALUES (null, 1, NEW.chat_group_creator, NEW.chat_group_id, CURRENT_TIMESTAMP())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `chat_groups_messages`
--

CREATE TABLE `chat_groups_messages` (
  `message_id` int(11) NOT NULL COMMENT 'уникальный код сообщения',
  `timestamp` timestamp NOT NULL COMMENT 'время отправления',
  `from_user_id` int(11) NOT NULL COMMENT 'пользователь - отправитель',
  `to_chat_group_id` int(11) NOT NULL COMMENT 'группа - получатель',
  `chat_message` text NOT NULL COMMENT 'текст сообщения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `chat_groups_participants`
--

CREATE TABLE `chat_groups_participants` (
  `relation_id` int(11) NOT NULL COMMENT 'уникальный код отношения',
  `relation_type` int(11) NOT NULL COMMENT 'код типа отношения',
  `user_id` int(11) NOT NULL COMMENT 'код пользователя',
  `chat_group_id` int(11) NOT NULL COMMENT 'код группы',
  `timestamp_added` timestamp NOT NULL COMMENT 'время добавления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `chat_groups_participants`
--

INSERT INTO `chat_groups_participants` (`relation_id`, `relation_type`, `user_id`, `chat_group_id`, `timestamp_added`) VALUES
(1, 1, 6, 5, '2019-06-17 06:23:42'),
(2, 2, 4, 5, '2019-06-17 06:24:18');

-- --------------------------------------------------------

--
-- Структура таблицы `chat_message`
--

CREATE TABLE `chat_message` (
  `message_id` int(11) NOT NULL COMMENT 'уникальный код сообщения',
  `chat_id` int(11) NOT NULL COMMENT 'код диалога',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время отправления',
  `from_user_id` int(11) NOT NULL COMMENT 'отправитель',
  `to_user_id` int(11) NOT NULL COMMENT 'получатель',
  `chat_message` text NOT NULL COMMENT 'текст сообщения',
  `status` int(1) NOT NULL COMMENT 'статус'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `chat_message`
--

INSERT INTO `chat_message` (`message_id`, `chat_id`, `timestamp`, `from_user_id`, `to_user_id`, `chat_message`, `status`) VALUES
(1, 1, '2019-06-13 20:07:29', 2, 3, 'Привет!', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL COMMENT 'уникальный код авторизации',
  `user_id` int(11) NOT NULL COMMENT 'код пользователя',
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'последняя активность',
  `is_type` enum('no','yes') NOT NULL COMMENT 'пишет(да\\нет)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 2, '2019-06-13 18:33:53', 'no'),
(2, 3, '2019-06-13 20:05:01', 'no'),
(3, 2, '2019-06-14 16:03:18', 'no'),
(4, 3, '2019-06-13 20:07:53', 'no'),
(5, 4, '2019-06-17 06:20:11', 'no'),
(6, 5, '2019-06-17 06:22:08', 'no'),
(7, 6, '2019-06-17 06:33:30', 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `relation_types`
--

CREATE TABLE `relation_types` (
  `relation_type_id` int(11) NOT NULL COMMENT 'уникальный код типа отношения',
  `relation_type` text NOT NULL COMMENT 'наименование типа отношения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `relation_types`
--

INSERT INTO `relation_types` (`relation_type_id`, `relation_type`) VALUES
(1, 'Создатель'),
(2, 'Участник');

-- --------------------------------------------------------

--
-- Структура таблицы `task_list`
--

CREATE TABLE `task_list` (
  `task_id` int(11) NOT NULL COMMENT 'уникальный код задачи',
  `group_id` int(11) NOT NULL COMMENT 'код группы',
  `title` varchar(500) NOT NULL COMMENT 'заголовок',
  `description` varchar(500) NOT NULL COMMENT 'описание',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` date NOT NULL COMMENT 'выполнить до',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'код статуса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='общая таблица для хранения всех задач';

-- --------------------------------------------------------

--
-- Структура таблицы `task_status`
--

CREATE TABLE `task_status` (
  `status_id` int(11) NOT NULL COMMENT 'уникальный код статуса задачи',
  `status_description` varchar(50) NOT NULL COMMENT 'наименование статуса задачи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='справочник статусов задач';

--
-- Дамп данных таблицы `task_status`
--

INSERT INTO `task_status` (`status_id`, `status_description`) VALUES
(1, 'назначено'),
(2, 'выполняется'),
(3, 'выполнено');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'уникальный код пользователя',
  `username` varchar(50) NOT NULL COMMENT 'имя учетной записи',
  `password` varchar(255) NOT NULL COMMENT 'пароль',
  `perconname` varchar(500) DEFAULT NULL COMMENT 'имя пользователя учетной записи',
  `position` varchar(100) DEFAULT NULL COMMENT 'должность',
  `worknumber` varchar(50) DEFAULT 'не указан' COMMENT 'рабочий телефон',
  `mobilenumber` varchar(50) DEFAULT 'не указан' COMMENT 'мобильный телефон',
  `photo` varchar(500) NOT NULL DEFAULT 'pics/user.jpg' COMMENT 'ссылка на фото в папке на сервере',
  `email` varchar(100) NOT NULL COMMENT 'электронная почта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `perconname`, `position`, `worknumber`, `mobilenumber`, `photo`, `email`) VALUES
(2, 'ivanov', '$2y$10$IujBWWwBrhFMxEBNZDlyD.Z7Vh7JbDGPWl8nj9O3USDKQFsxO.3O2', 'Иванов Иван Иванович', 'менеджер', 'не указан', 'не указан', 'pics/user.jpg', 'e@mail.com'),
(3, 'petrov', '$2y$10$kJkjiUlHasxKeOVwnOxcHevyU/jqiqiruXe0U.Ojobo8JhDTDMy.a', 'Петров Петр Петрович', 'специалист продаж', 'не указан', 'не указан', 'pics/user.jpg', 'petrov@mail.com'),
(4, '@petrov', '$2y$10$T7rMENZP2OE1vABxHPmjh.0FeeGlLz0f9eceQtT7kKHgTiBGp3frG', 'Петров Степан Васильевич', 'тестировщик ПО', '55-65-23', '+7(923)123-32-23', 'pics/d838f8e7dc0c301479c9931f9e4a6941.jpg', 'petrov@gmail.com'),
(5, 'stepanova', '$2y$10$ZL0HM.mOrazfKFc6IJ8K1OM9gO5RXmgkG00cH5sRu6UH8ux7tguti', 'Степанова Василиса Андреевна', 'бухгалтер', 'не указан', 'не указан', 'pics/user.jpg', 'stepanova@gmail.com'),
(6, 'marrkova', '$2y$10$DRKKjPMxHO6v7ScQUsofSuSyr9Pd7NWBlmqIQTyW4.cqagF5LgEG6', 'Маркова Ирина Дмитриевна', 'python-разработчик', 'не указан', 'не указан', 'pics/user.jpg', 'markova@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `users_chats`
--

CREATE TABLE `users_chats` (
  `chat_id` int(11) NOT NULL COMMENT 'уникальный код диалога',
  `user_1` int(11) NOT NULL COMMENT 'участник 1',
  `user_2` int(11) NOT NULL COMMENT 'участник 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_chats`
--

INSERT INTO `users_chats` (`chat_id`, `user_1`, `user_2`) VALUES
(1, 2, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD PRIMARY KEY (`chat_group_id`),
  ADD KEY `chat_group_creator` (`chat_group_creator`);

--
-- Индексы таблицы `chat_groups_messages`
--
ALTER TABLE `chat_groups_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_chat_group_id` (`to_chat_group_id`);

--
-- Индексы таблицы `chat_groups_participants`
--
ALTER TABLE `chat_groups_participants`
  ADD PRIMARY KEY (`relation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_group_id` (`chat_group_id`),
  ADD KEY `relation_type` (`relation_type`);

--
-- Индексы таблицы `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`),
  ADD KEY `chat_id` (`message_id`);

--
-- Индексы таблицы `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `relation_types`
--
ALTER TABLE `relation_types`
  ADD PRIMARY KEY (`relation_type_id`);

--
-- Индексы таблицы `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `status` (`status`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `users_chats`
--
ALTER TABLE `users_chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `users_chats_ibfk_1` (`user_1`),
  ADD KEY `user_2` (`user_2`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chat_groups`
--
ALTER TABLE `chat_groups`
  MODIFY `chat_group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код группы', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `chat_groups_messages`
--
ALTER TABLE `chat_groups_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код сообщения';

--
-- AUTO_INCREMENT для таблицы `chat_groups_participants`
--
ALTER TABLE `chat_groups_participants`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код отношения', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код сообщения', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код авторизации', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `relation_types`
--
ALTER TABLE `relation_types`
  MODIFY `relation_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код типа отношения', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код задачи';

--
-- AUTO_INCREMENT для таблицы `task_status`
--
ALTER TABLE `task_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код статуса задачи', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код пользователя', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users_chats`
--
ALTER TABLE `users_chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный код диалога', AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD CONSTRAINT `chat_groups_ibfk_1` FOREIGN KEY (`chat_group_creator`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `chat_groups_messages`
--
ALTER TABLE `chat_groups_messages`
  ADD CONSTRAINT `chat_groups_messages_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_groups_messages_ibfk_2` FOREIGN KEY (`to_chat_group_id`) REFERENCES `chat_groups` (`chat_group_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `chat_groups_participants`
--
ALTER TABLE `chat_groups_participants`
  ADD CONSTRAINT `chat_groups_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_groups_participants_ibfk_2` FOREIGN KEY (`chat_group_id`) REFERENCES `chat_groups` (`chat_group_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_groups_participants_ibfk_3` FOREIGN KEY (`relation_type`) REFERENCES `relation_types` (`relation_type_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `chat_message_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_message_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `login_details`
--
ALTER TABLE `login_details`
  ADD CONSTRAINT `login_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_list`
--
ALTER TABLE `task_list`
  ADD CONSTRAINT `task_list_ibfk_1` FOREIGN KEY (`status`) REFERENCES `task_status` (`status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `task_list_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `chat_groups` (`chat_group_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_chats`
--
ALTER TABLE `users_chats`
  ADD CONSTRAINT `users_chats_ibfk_1` FOREIGN KEY (`user_1`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chats_ibfk_2` FOREIGN KEY (`user_2`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
