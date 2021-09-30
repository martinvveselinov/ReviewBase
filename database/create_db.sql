-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13 юли 2020 в 18:12
-- Версия на сървъра: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puffinsecurity`
--

-- --------------------------------------------------------

--
-- Структура на таблица `add_device`
--

CREATE TABLE `add_device` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `devices`
--

CREATE TABLE `devices` (
  `user_id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `browser` varchar(64) COLLATE utf8_bin NOT NULL,
  `os` varchar(64) COLLATE utf8_bin NOT NULL,
  `device_no` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `devices`
--

INSERT INTO `devices` (`user_id`, `username`, `browser`, `os`, `device_no`) VALUES
(62018, 'mvalerievv', 'Chrome', 'Windows 10', 1),
(81535, 'bidekov', 'Chrome', 'Windows 10', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `grading`
--

CREATE TABLE `grading` (
  `id` int(11) NOT NULL,
  `evaluator` text COLLATE utf8_bin DEFAULT NULL,
  `evaluated` text COLLATE utf8_bin DEFAULT NULL,
  `ref` decimal(10,2) DEFAULT NULL,
  `pres` decimal(10,2) DEFAULT NULL,
  `inv` decimal(10,2) DEFAULT NULL,
  `avg` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `version` bigint(20) NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `theme` bigint(20) NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `file` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `ip`
--

CREATE TABLE `ip` (
  `username` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `change_no` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `loginattempts`
--

CREATE TABLE `loginattempts` (
  `username` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `attempt_no` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `log_stats`
--

CREATE TABLE `log_stats` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `ip` text COLLATE utf8_bin NOT NULL,
  `logged_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `OS` text COLLATE utf8_bin NOT NULL,
  `Browser` text COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `log_stats`
--

INSERT INTO `log_stats` (`username`, `ip`, `logged_on`, `OS`, `Browser`, `id`) VALUES
('mvaleirevv', '::1', '2020-07-12 16:47:00', 'Windows 10', 'Chrome', 368),
('mvalerievv', '::1', '2020-07-12 16:47:26', 'Windows 10', 'Chrome', 369),
('mvalerievv', '::1', '2020-07-12 16:47:42', 'Windows 10', 'Chrome', 370),
('mvalerievv', '::1', '2020-07-12 16:47:45', 'Windows 10', 'Chrome', 371),
('mvalerievv', '::1', '2020-07-12 16:58:34', 'Windows 10', 'Chrome', 372),
('mvalerievv', '::1', '2020-07-13 15:33:32', 'Windows 10', 'Chrome', 373),
('mvalerievv', '::1', '2020-07-13 15:39:56', 'Windows 10', 'Chrome', 374),
('mvalerievv', '::1', '2020-07-13 15:55:42', 'Windows 10', 'Chrome', 375),
('bidekov', '::1', '2020-07-13 15:56:11', 'Windows 10', 'Chrome', 376),
('mvalerievv', '::1', '2020-07-13 15:58:32', 'Windows 10', 'Chrome', 377),
('bidekov', '::1', '2020-07-13 16:11:49', 'Windows 10', 'Chrome', 378);

-- --------------------------------------------------------

--
-- Структура на таблица `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `presentations`
--

CREATE TABLE `presentations` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` bigint(20) NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `theme` bigint(20) NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `file` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `referats`
--

CREATE TABLE `referats` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` bigint(20) NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `theme` bigint(20) NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `file` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `themes`
--

CREATE TABLE `themes` (
  `theme_no` int(3) NOT NULL,
  `theme_name` text COLLATE utf8_bin NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `themes`
--

INSERT INTO `themes` (`theme_no`, `theme_name`, `user_id`) VALUES
(1, 'Google - Web Performance Best Practices', NULL),
(2, 'HTML5 - част 1 семантични тагове, тагове за форми. Примери.', NULL),
(3, 'Latex - сравнение с HTML', NULL),
(4, 'CSS: стилове, класове, селектори', NULL),
(5, 'CSS: layouts, box model', NULL),
(6, 'CSS: layouts, flexbox', 81535),
(7, 'Анимации с CSS с използване на трансформации', NULL),
(8, 'Еммет синтаксис', NULL),
(9, 'DOM дърво, обхождане и манипулация', NULL),
(10, 'Работа със сесии и cookies (от страна насървъра и клиента). Local Storage API', NULL),
(11, 'HTML мета-тагове и SEO', NULL),
(12, 'Протокол HTTP версия 2.0+', NULL),
(13, 'CSS Preprocessor/LESS и SASS', NULL),
(14, 'External Data Representation (XDR)', NULL),
(15, 'Svelte web tool', NULL),
(16, 'Fetch API and XHR', NULL),
(17, 'Използване на git за - добри практики', NULL),
(18, 'Network Etiquette - общуване в уеб', NULL),
(19, 'Инструменти за стрес-тестове на уеб приложения', NULL),
(20, 'Тестване на уеб приложения със Selenium web driver. Примери.', NULL),
(21, 'Платформи за колаборативна работа по софтуерни и уеб проекти (zoom, teams, jitsi, etc) и отдалечено екстремно програмиране', NULL),
(22, 'CSS modules and Interoperable CSS,', NULL),
(23, 'Framework7 - разработка на уеб приложения за Android и iOS', NULL),
(24, 'Mobx - управление на състоянието', NULL),
(25, 'URL rewriting', NULL),
(26, 'Clipping и Masking в CSS', NULL),
(27, 'Оценка на javascript приложенията', NULL),
(28, 'CSS регресивно тестване (CasperJS), Библиотеки phantomjs и PhantomCSS. Resemble.js: Анализ и сравнение на изображения посреством JavaScript и HTML. SlimerJS', NULL),
(29, 'Styled JSX', NULL),
(30, 'Responsive images', NULL),
(31, 'CSS Shapes', NULL),
(32, 'Multi-touch Web Development', NULL),
(33, 'HTML Imports', NULL),
(34, 'Тестване с Jestjs', NULL),
(35, 'Високопроизводителни анимации за уеб', NULL),
(36, 'Компресиране на текст в уеб', NULL),
(37, 'Компресиране на изображения в уеб', NULL),
(38, 'Производителност при зареждане на скриптове в уеб', NULL),
(39, 'Shadow DOM 101', NULL),
(40, 'Shadow DOM 201, CSS and Styling. Advanced Concepts & DOM APIs', NULL),
(41, 'PostCSS - преобразуване на CSS с JavaScript', NULL),
(42, 'HTML template', NULL),
(43, 'Обектно ориентиран CSS (OOCSS)', NULL),
(44, 'HTTPS и HTTP - сигурност в PHP', NULL),
(45, 'Прецизно аудио в Уеб', NULL),
(46, 'Скалируема и модулна архитектура за CSS', NULL),
(47, 'Изграждане на 3D в Уеб', NULL),
(48, 'WebSocket с PHP', NULL),
(49, 'Приложения с PHP и MySql на AWS', NULL),
(50, 'Прихващане на аудио и видео в HTML5', NULL),
(51, 'Drag and Drop', NULL),
(52, 'Библиотека jQuery', NULL),
(53, 'MongoDB за уеб приложения. MEAN стек.', NULL),
(54, 'Добри и лоши практики при изграждане и софтуерната архитектура на уеб сайтове', NULL),
(55, 'Nginx. Архитектура, инсталиране, конфигуриране, виртуални хостове.', NULL),
(56, 'Apache. Архитектура, инсталиране, конфигуриране, виртуални хостове.', NULL),
(57, 'Приложение на видовете UML диаграми за Уеб', NULL),
(58, 'Apolo graphql', NULL),
(59, 'Web workers', NULL),
(60, 'Angular.js', NULL),
(61, 'Mustache и Handlebars темплейти', NULL),
(62, 'Bootstrap', NULL),
(63, 'Gatsby JS - генератори на статични сайтове', NULL),
(64, 'Генератор на статични сайтове - Jekyll', NULL),
(65, 'Phoenix', NULL),
(66, 'ReactJS', NULL),
(67, 'Bulma css framework. Шаблони, примери.', NULL),
(68, 'ECMAScript 2016/6/ ES 7+', NULL),
(69, 'PHP 7+', NULL),
(70, 'JavaScript Lint', NULL),
(71, 'Foundation framework', NULL),
(72, 'Уеб компоненти. Примери/демо.', NULL),
(73, 'Hypertext Transfer Protocol (HTTP/1.1): Authentication. Примери.', NULL),
(74, 'PHP Package Development Standards. Coding styles.', NULL),
(75, 'Laravel Web Framework', NULL),
(76, 'Споделяне на ресурси от различни източници (CORS). Примери.', NULL),
(77, 'WebVTT (Web Video Text Tracks)', NULL),
(78, 'Аудио филтри за уеб. Примери.', NULL),
(79, 'JSON Web Token (JWT), JSON Web Signature (JWS), JSON Web Encryption (JWE), JSON Web Algorithms (JWA)', NULL),
(80, 'HammerJS - поддръжка на жестове в уеб приложенията', NULL),
(81, 'Разгръщане на уеб приложения с Apache/Php под Docker под Windows', NULL),
(82, 'Progressive Web Apps(PWA)', NULL),
(83, 'WebAssembly-основи, примери', NULL),
(84, 'Технология Blazor', NULL),
(85, 'imba', NULL),
(86, 'Micro Frontends-extending the microservice idea to frontend development', NULL),
(87, 'GraphQL - принципи. Интеграция с Php. Примери.', NULL),
(88, 'WebExtensions - разширения за firefox', NULL),
(89, 'Писане на хипертекс (html) посредством Kotlin DSL', NULL),
(90, 'Elasticsearch с php', NULL),
(91, 'Web Performance Timing APIs', NULL),
(92, 'Тестване на уеб приложения със Cypress', NULL),
(93, 'Полезни разширения за разработката на уеб с Visual Code Editor', NULL),
(94, 'Работа с кампании (UTM)', NULL),
(95, 'NativeScript', NULL),
(96, 'Coffeescript', NULL),
(97, 'Виртуална реалност в уеб - WebVR. Примери.', NULL),
(98, 'Motion UI - създаване на CSS анимации', NULL),
(99, 'Разработване на достъпни уеб приложения - ARIA spec.', NULL),
(100, 'Опълномощаване с OAuth2 (authorization)', NULL),
(101, 'Уязвимости в уеб приложения - инжекции (OWASP-A1). Примери.', NULL),
(102, 'Уязвимости в уеб приложения - дефектна аутентикация (OWASP-A2). Примери.', NULL),
(103, 'Уязвимости в уеб приложения - излагане на чуствителни данни (OWASP-A3). Примери.', NULL),
(104, 'Уязвимости в уеб приложения - външни XML данни (OWASP-A4). Примери.', NULL),
(105, 'Уязвимости в уеб приложения - дефектен контрол на достъпа (OWASP-A5). Примери.', NULL),
(106, 'Уязвимости в уеб приложения - дефектна конфигурация на сигурността (OWASP-A6). Примери.', NULL),
(107, 'Уязвимости в уеб приложения - XSS - изпълнение на външни скриптове (OWASP-A7). Примери.', NULL),
(108, 'Уязвимости в уеб приложения - несигурна десериализация (OWASP-A8). Примери.', NULL),
(109, 'Уязвимости в уеб приложения - използване на компоненти с известни уязвимости (OWASP-A9). Примери.', NULL),
(110, 'Уязвимости в уеб приложения - недостатъчно наблюдение и водене на журнални файлове (OWASP-A10). Примери.', NULL),
(111, 'Микроформати - видове. Примери.', NULL),
(112, 'Софтуерни шаблони за създаване (в php)', NULL),
(113, 'Софтуерни шаблони; структурни (в php)', NULL),
(114, 'Софтуерни шаблони за поведение (в php)', NULL),
(115, 'Софтуерни шаблони - други (в php)', NULL),
(116, 'Създаване на диаграми с chartjs. Примери, добри практики. Видове диаграми.', NULL),
(117, 'Accelerated Mobile Pages (AMP)', NULL),
(118, 'Стартиране на Lamp приложение посредством Kubernetes', NULL),
(119, 'Тестване на уеб приложения със Selenoid', NULL),
(120, 'Постоянна интеграция на уеб приложения с Concourse CI', NULL),
(121, 'TypeScript', NULL),
(122, 'Servant', NULL),
(123, 'Разработване на мулти-тенант приложения с Php', NULL),
(124, 'Configure SSL on XAMPP', NULL),
(125, 'WebRTC - принципи на работа. WebRTC с Php', NULL),
(126, 'Използване на SVG в уеб', NULL),
(127, 'Автоматизирано тестване в Php. PhpUnit.', NULL),
(128, 'HTML 5 Geolocation API', NULL),
(129, 'Препоръки за сигурност за студенти в уеб. Генериране и използване на цифров подпис.', NULL),
(130, '[NA] Git homework (test topic by MP)', NULL),
(131, 'Криптографско API в Web', NULL),
(132, 'Интернационализация с JavaScript. Globalize.', NULL),
(133, 'Сигурност в уеб приложенията', NULL),
(134, 'The App Shell model архитектура for Progressive Web App (PWA)', NULL),
(135, 'Запис на потребителско видео през уеб', NULL),
(136, 'Уеб технологиите в разработването на мобилни приложения с React Native', NULL),
(137, 'motion UI', NULL),
(138, 'Инсталиране и настройка на Apache сървър под линукс. Активиране на https.', NULL),
(139, 'Frontend интернационализация на уеб приложения', NULL),
(140, '[NA]', NULL);

-- --------------------------------------------------------

--
-- Структура на таблица `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `ban` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `admin`, `ban`) VALUES
(62018, 'mvalerievv', '$2y$10$XGb5nRy8znSrpeA73IAYkONOVs3QUcrrgfIvM5ESbYw06ywr2OE62', 'motry@abv.bg', 1, 0),
(81535, 'bidekov', '$2y$10$LPYM5kafLRBvSiH.K7AE.ea4nkVqSF4WYfL7mMdQ/cz7oXK0mJGM2', 'rameca@abv.bg', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_device`
--
ALTER TABLE `add_device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `grading`
--
ALTER TABLE `grading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_stats`
--
ALTER TABLE `log_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `presentations`
--
ALTER TABLE `presentations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referats`
--
ALTER TABLE `referats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`theme_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_device`
--
ALTER TABLE `add_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grading`
--
ALTER TABLE `grading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `log_stats`
--
ALTER TABLE `log_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `presentations`
--
ALTER TABLE `presentations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `referats`
--
ALTER TABLE `referats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `theme_no` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234567891;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
