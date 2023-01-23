<?php 

namespace Helpers\Databases;

use Database\Database;

/**
 * Класс для добавления загруженного файла в таблицу
 * 
 * @category Helpers
 */
class InsertToFilesHelper {

    /**
     * Метод для вставки данных загруженного файла в таблицу
     * 
     * @param string $content_type Тип
     * @param string $extension_file Расширение
     * @param string $new_file_name Уник. имя
     * @param string $source_file_name Исх. имя
     * @param int $size_file Размер файла
     * 
     * @return void
     */
    static public function insert(
        string $content_type,
        string $extension_file,
        string $new_file_name,
        string $source_file_name,                
        int $size_file
    )
    {

        $values = [
            'content_type' => $content_type,
            'name' => $new_file_name,
            'source_name' => $source_file_name,
            'extension' => $extension_file,
            'size_file' => $size_file,
        ];

        $query = "INSERT INTO files.files 
            (content_type,name,source_name,extension,`size`)
            VALUES (:content_type,:name,:source_name,:extension,:size_file);
        ";
            
        Database::insert($query, $values);
    }
}
