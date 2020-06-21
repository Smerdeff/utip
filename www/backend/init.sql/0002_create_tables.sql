CREATE TABLE `users`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `name`       varchar(128) NOT NULL,
    `password`   varchar(128) NOT NULL,
    `email`      varchar(128) NOT NULL,
    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `images` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `file_name` varchar(128) NOT NULL,
                          `created_at` timestamp  NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `status` enum('1','0') NOT NULL DEFAULT '1',
                          `user_id` int,
                          `title` varchar(128),
                          `description` varchar(2048),
                          index (user_id),
                          FOREIGN KEY (user_id)
                              REFERENCES users(id)
                              ON DELETE NO ACTION ,
                          PRIMARY KEY (`id`)
);

