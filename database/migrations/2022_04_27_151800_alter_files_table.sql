ALTER TABLE files.files MODIFY COLUMN create_date timestamp DEFAULT current_timestamp() NOT NULL COMMENT 'Дата создания';
ALTER TABLE files.files MODIFY COLUMN extension varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Формат файла';
ALTER TABLE files.files MODIFY COLUMN is_deleted tinyint(1) DEFAULT NULL NULL COMMENT 'Удалён ли файл (логически)';
ALTER TABLE files.files MODIFY COLUMN is_removed tinyint(1) DEFAULT NULL NULL COMMENT 'Удалён ли файл физически';
ALTER TABLE files.files DEFAULT CHARSET=utf8;
