-- files.files definition

CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `extension` varchar(100) NOT NULL COMMENT 'Расширение файла',
  `name` varchar(255) NOT NULL COMMENT 'Имя (хеш) файла',
  `source_name` varchar(255) NOT NULL COMMENT 'Исходное имя файла',
  `size` int(10) unsigned NOT NULL COMMENT 'Размер файла в байтах',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Дата создания',
  `read_date` timestamp NULL DEFAULT NULL COMMENT 'Дата последнего обращения',
  `update_date` timestamp NULL DEFAULT NULL COMMENT 'Дата последнего изменения',
  `is_deleted` tinyint(4) DEFAULT NULL COMMENT 'Удалён ли файл (логически)',
  `is_removed` tinyint(4) DEFAULT NULL COMMENT 'Удалён ли файл физически',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Загруженные файлы';