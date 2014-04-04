--
-- Table structure for table `fb_app_viral_settings`
--

CREATE TABLE IF NOT EXISTS `fb_app_viral_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(60) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `fb_app_viral_users`
--

CREATE TABLE IF NOT EXISTS `fb_app_viral_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_id` bigint(20) DEFAULT NULL,
  `fb_name` varchar(60) DEFAULT NULL,
  `fb_email` varchar(120) DEFAULT NULL,
  `fb_token` varchar(200) DEFAULT NULL,
  `fb_token_expires` int(11) DEFAULT NULL,
  `fb_birthday` varchar(120) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `fb_app_viral_settings`
--

INSERT INTO `fb_app_viral_settings` (`id`, `meta_key`, `meta_value`) VALUES
(13, 'locked_content', '<h1 style="text-align:center">{picture} Welcome {name} !</h1>\n\n<p style="text-align:center">You can <a href="./admin/" target="_blank">click here</a> to check the backend of this application.<br />\n<br />\n<br />\n<iframe frameborder="0" height="440" src="http://www.youtube.com/embed/2ST6cnXgQhM" width="680"></iframe></p>'),
(14, 'autopost_status', ''),
(15, 'autopost_email', ''),
(16, 'autopost_status_message', ''),
(17, 'autopost_status_link', ''),
(18, 'autopost_status_picture', ''),
(19, 'autopost_email_subject', ''),
(20, 'autopost_email_message', '');
