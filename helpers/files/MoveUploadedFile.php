<?php 

namespace Helpers\Files;

use Slim\Http\UploadedFile;

/**
 * Класс с методом для перемещения загруженных файлов
 * 
 * @category Helpers
 */
class MoveUploadedFile {

    /**
     * Перемещает загруженный файл в каталог загрузки и назначает ему уникальное имя, 
     * чтобы избежать перезаписи существующего загруженного файла.
     *
     * @param string $directory каталог, в который перемещается файл
     * @param UploadedFile $uploadedFile загруженный файл для перемещения
     * 
     * @return string имя перемещенного файла
     * 
     * @see https://slimframework.ru/v3/cookbook/uploading-files
     */
    static public function moveUploadedFile(string $directory, UploadedFile $uploadedFile)
    {

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s', $basename);
        $filename = date('Y_m_d_His') . '_' . $filename;

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}

