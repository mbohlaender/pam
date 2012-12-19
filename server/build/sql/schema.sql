
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- note
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `note`;

CREATE TABLE `note`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `title` VARCHAR(128) NOT NULL,
    `content` VARCHAR(1024) NOT NULL,
    `created_at` VARCHAR(1024) NOT NULL,
    `valid_to` VARCHAR(1024) NOT NULL,
    `category` VARCHAR(1024) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `note_FI_1` (`user_id`),
    CONSTRAINT `note_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
