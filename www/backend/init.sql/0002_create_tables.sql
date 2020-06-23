create table users
(
    id         int auto_increment
        primary key,
    username   varchar(128)                        not null,
    password   varchar(128)                        not null,
    email      varchar(128)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    token      char(16)                            null,
    updated_at timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint users_email_uindex
        unique (email)
);

CREATE TABLE `images` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `file_name` varchar(128) NOT NULL,
                          `created_at` timestamp  NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `status` enum('1','0') NOT NULL DEFAULT '1',
                          `user_id` int,
                          `title` varchar(128),
                          `description` varchar(2048),
                          `file_hash` char(32),
                          index (user_id),
                          index (file_hash),
                          FOREIGN KEY (user_id)
                              REFERENCES users(id)
                              ON DELETE NO ACTION ,
                          PRIMARY KEY (`id`)
);


