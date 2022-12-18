-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: instachat
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @old_character_set_client = @@character_set_client */;
/*!40101 SET @old_character_set_results = @@character_set_results */;
/*!40101 SET @old_collation_connection = @@collation_connection */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @old_time_zone = @@time_zone */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @old_unique_checks = @@unique_checks, UNIQUE_CHECKS = 0 */;
/*!40014 SET @old_foreign_key_checks = @@foreign_key_checks, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @old_sql_mode = @@sql_mode, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @old_sql_notes = @@sql_notes, SQL_NOTES = 0 */;

--
-- Table structure for table `blocked`
--

DROP TABLE IF EXISTS blocked;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE blocked
(
	blocker_id   bigint UNSIGNED NOT NULL,
	blocked_id   bigint UNSIGNED          DEFAULT NULL,
	blocked_word varchar(100)             DEFAULT NULL,
	blocked_date timestamp       NOT NULL DEFAULT (NOW()),
	KEY fk_blocker_user (blocker_id),
	KEY idx_blocked_blocked (blocked_id),
	CONSTRAINT fk_blocked_user FOREIGN KEY (blocked_id) REFERENCES users (id),
	CONSTRAINT fk_blocker_user FOREIGN KEY (blocker_id) REFERENCES users (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS comments;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE comments
(
	id            bigint UNSIGNED                  NOT NULL AUTO_INCREMENT,
	content       varchar(120) COLLATE utf8mb4_bin NOT NULL,
	reply_id      bigint UNSIGNED                           DEFAULT NULL,
	post_id       bigint UNSIGNED                  NOT NULL,
	creation_date timestamp                        NOT NULL DEFAULT (NOW()),
	author_id     bigint UNSIGNED                  NOT NULL,
	deleted       tinyint(1)                       NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	KEY fk_comments_users (author_id),
	KEY idx_comments_post_id (post_id),
	KEY idx_comments_reply_id (reply_id),
	CONSTRAINT fk_comments_comments FOREIGN KEY (reply_id) REFERENCES comments (id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_comments_posts FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_comments_users FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 52
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS friends;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE friends
(
	requester_id  bigint UNSIGNED NOT NULL,
	requested_id  bigint UNSIGNED NOT NULL,
	accepted      tinyint(1) COMMENT 'null = not viewed, false = rejected, true = accepted',
	send_date     timestamp       NOT NULL DEFAULT (NOW()),
	response_date timestamp       NULL     DEFAULT (NOW()),
	PRIMARY KEY (requester_id),
	KEY idx_friends_requested (requested_id),
	CONSTRAINT fk_friends_users FOREIGN KEY (requester_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_friends_users_0 FOREIGN KEY (requested_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS posts;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE posts
(
	id            bigint UNSIGNED   NOT NULL AUTO_INCREMENT,
	content       varchar(400)      NOT NULL,
	author_id     bigint UNSIGNED   NOT NULL,
	creation_date timestamp         NOT NULL DEFAULT (NOW()),
	photo         mediumblob,
	emotion       smallint UNSIGNED NOT NULL,
	deleted       tinyint(1)        NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	KEY idx_posts_author_id (author_id),
	CONSTRAINT fk_posts_users FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1491
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reaction_users`
--

DROP TABLE IF EXISTS reaction_users;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE reaction_users
(
	reaction_id bigint UNSIGNED NOT NULL,
	user_id     bigint UNSIGNED NOT NULL,
	KEY idx_reaction_users_user_id (user_id),
	KEY idx_reaction_users_reaction_id (reaction_id),
	CONSTRAINT fk_reaction_users_reactions FOREIGN KEY (reaction_id) REFERENCES reactions (id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_reaction_users_users FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reactions`
--

DROP TABLE IF EXISTS reactions;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE reactions
(
	id      bigint UNSIGNED NOT NULL AUTO_INCREMENT,
	post_id bigint UNSIGNED NOT NULL,
	emoji   text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
	PRIMARY KEY (id),
	KEY idx_reactions_post_id (post_id),
	CONSTRAINT fk_reactions_posts FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 27
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS users;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE users
(
	id           bigint UNSIGNED  NOT NULL AUTO_INCREMENT,
	username     varchar(20)      NOT NULL,
	password     varchar(64)      NOT NULL,
	avatar       mediumblob,
	created_date timestamp        NOT NULL DEFAULT (NOW()),
	birth_date   date             NOT NULL,
	display_name varchar(30)               DEFAULT NULL,
	color        tinyint UNSIGNED NOT NULL DEFAULT (0),
	background   tinyint UNSIGNED NOT NULL DEFAULT '1',
	sexe         varchar(20)      NOT NULL,
	email        varchar(320)     NOT NULL,
	bio          varchar(200)              DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS votes;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE votes
(
	comment_id bigint UNSIGNED NOT NULL,
	type       tinyint         NOT NULL,
	user_id    bigint UNSIGNED NOT NULL,
	KEY fk_votes_comments (comment_id),
	KEY fk_votes_users (user_id),
	CONSTRAINT fk_votes_comments FOREIGN KEY (comment_id) REFERENCES comments (id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_votes_users FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE = @old_time_zone */;

/*!40101 SET SQL_MODE = @old_sql_mode */;
/*!40014 SET FOREIGN_KEY_CHECKS = @old_foreign_key_checks */;
/*!40014 SET UNIQUE_CHECKS = @old_unique_checks */;
/*!40101 SET CHARACTER_SET_CLIENT = @old_character_set_client */;
/*!40101 SET CHARACTER_SET_RESULTS = @old_character_set_results */;
/*!40101 SET COLLATION_CONNECTION = @old_collation_connection */;
/*!40111 SET SQL_NOTES = @old_sql_notes */;

-- Dump completed on 2022-12-18 21:57:59
