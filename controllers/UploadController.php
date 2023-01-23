<?php

namespace Controllers;

use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Config\Config;
use Helpers\Files\MoveUploadedFile;
use Helpers\Databases\InsertToFilesHelper;

/**
 * Контроллер для загрузки
 * 
 * @category Controllers
 */
class UploadController 
{
    /**
     * Метод для загрузки
     * 
     * @param Container $app Slim-containter
     * @param Request $request Запрос
     * @param Response $response Ответ
     * 
     * @return Response
     */
    static public function upload(Container $app, Request $request, Response $response)
    {
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");

        $directory = $app->get('upload_directory');

        $files = $request->getUploadedFiles();

        $filename = '';
        $filename_source = '';
        $size = null;        

        if (isset($files['file'])) {

            $uploaded_file = $files['file'];

            if ($uploaded_file->getError() === UPLOAD_ERR_OK) {

                $content_type = $uploaded_file->getClientMediaType();
                $extension = pathinfo($uploaded_file->getClientFilename(), PATHINFO_EXTENSION);            
                $filename = MoveUploadedFile::moveUploadedFile($directory, $uploaded_file);
                $filename_source = $uploaded_file->getClientFilename();
                $size = round($uploaded_file->getSize() / 1024);                        

                InsertToFilesHelper::insert(
                    $content_type,
                    $extension,
                    $filename, 
                    $filename_source,                 
                    $size
                );
            }

            $data = [
                'status' => 'succes',
                'data' => [                
                    'upload_directory' => $directory,
                    'filename' => $filename,
                    'filename_source' => $filename_source,
                    'path' => Config::CONFIG_FILE_UPLOAD_PATH . '/' . $filename,
                    'size' => $size,
                    'content_type' => $content_type,
                    'extension' => $extension,
                    'path_to_download' => Config::CONFIG_HOST_NAME . Config::CONFIG_FILE_UPLOAD_PATH . '/' . $filename ,
                ],
                'message' => 'Всё успешно загружено',
            ];

            $response = $response->withJson($data, 201);

        } else {

            $response = $response->withJson([
                'status' => 'success',
                'message' => 'Не передан параметр \'file\' для загрузки файла!'
            ], 400);

        }

        return $response;
    }
}
