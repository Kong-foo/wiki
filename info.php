<?php
$password = 1234;
$db_address = "<enter address of database>";
$db_username = "<username>";
$db_password = "<password>";
$db_dbname = "<database name>";
$db_tablename = "wiki";
$db_logintablename = "wiki_login";
$adminMessage = "";

$locked_pages = array("categories", "faq", "news", "random", "logout", "newpage", "Welcome", "login", "register");


?>		

/*
SQL database should have a table that looks like this for the logins:

CREATE TABLE `wiki_login` (
  `username` text COLLATE latin1_general_ci NOT NULL,
  `password` text COLLATE latin1_general_ci NOT NULL,
  `joined` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


INSERT INTO `wiki_login` (`username`, `password`, `joined`) VALUES
('admin', '12366', '0000-00-00'),
('test2', 'password', '0000-00-00'),





And another table for the wiki entries:

CREATE TABLE `wiki` (
  `date` datetime NOT NULL,
  `title` text COLLATE latin1_general_ci NOT NULL,
  `creator` tinytext COLLATE latin1_general_ci NOT NULL,
  `category` text COLLATE latin1_general_ci NOT NULL,
  `post` longtext COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `wiki`
--

INSERT INTO `wiki` (`date`, `title`, `creator`, `category`, `post`) VALUES
('2020-07-19 00:00:00', 'Welcome', 'Admin', 'welcome admin basic wiki intro', 'Welcome to the wiki! Have fun and do not forget to read the [a href=\"?rules\"]rules[/a] and [a href=\"?faq\"]faq[/a].'),


*/
