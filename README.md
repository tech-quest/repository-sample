# blog

## Repositoryとは？
- EntityとDaoの間に存在するObject
- Repository(書き込み処理)
- 主な役割は下記
  * DBとのやり取りをしやすくする
  * APIとのやり取りをしやすくする
  * CSVファイルとのやり取りをしやすくする
- DBに保存しやすい形にする(value objectをむくなど)
- Entityを永続化する存在(完了未完了を0と1で表しているのは、Domainは知らなくて良い。そのつじつまを合わせるのがRepositoryの仕事)
## SQL文

CREATE DATABASE blog;

CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

CREATE TABLE `comments` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `commenter_name` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 