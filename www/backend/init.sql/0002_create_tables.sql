CREATE TABLE `example`.`tasks`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `username`   varchar(128) NOT NULL,
    `body`       text         NOT NULL,
    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);


CREATE TABLE example.`users`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `name`       varchar(128) NOT NULL,
    `email`      varchar(128) NOT NULL,
    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);