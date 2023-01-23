ALTER TABLE files.files CHANGE extension content_type varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Расширение файла';
ALTER TABLE files.files ADD extension varchar(100) NOT NULL COMMENT 'Формат файла';
ALTER TABLE files.files CHANGE extension extension varchar(100) NOT NULL COMMENT 'Формат файла' AFTER source_name;
