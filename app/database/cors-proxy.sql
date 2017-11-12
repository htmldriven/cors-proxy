SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `request_log` (
  `id` int(10) unsigned NOT NULL,
  `method` enum('GET','POST','PUT','DELETE','OPTIONS','HEAD','TRACE','CONNECT','PATCH') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GET' COMMENT 'HTTP request method.',
  `scheme` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'HTTP request scheme.',
  `host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'HTTP request host domain/ip.',
  `path` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'HTTP request URL path relative to host. Path should always start with ''/'' character.',
  `query` text COLLATE utf8_unicode_ci COMMENT 'Query string part of the URL.',
  `user_agent` text COLLATE utf8_unicode_ci COMMENT 'Client string identifier.',
  `request_headers` text COLLATE utf8_unicode_ci COMMENT 'All HTTP request headers in JSON format.',
  `request_body` mediumtext COLLATE utf8_unicode_ci COMMENT 'Request payload data.',
  `response_headers` text COLLATE utf8_unicode_ci COMMENT 'All HTTP response headers in JSON format.',
  `response_body` mediumtext COLLATE utf8_unicode_ci COMMENT 'Response payload data.',
  `date_created` datetime NOT NULL COMMENT 'Date in UTC.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `request_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `path` (`path`(255)) USING BTREE;


ALTER TABLE `request_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
