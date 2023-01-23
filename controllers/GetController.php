<?php

namespace Controllers;

use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Config\Config;
use Database\Database;

/**
 * Класс-контроллер для получения ссылок на файл
 * 
 * @category Controllers
 */
class GetController 
{
    /**
     * Метод для получения ссылок на файл
     * 
     * @param Container $app Slim Container
     * @param Request $request Запрос
     * @param Response $response Ответ
     * 
     * @return Response
     */
    static public function index(Container $app, Request $request, Response $response) 
    {

        if (isset($request->getQueryParams()['name'])) {

            $name = $request->getQueryParams()['name'];

            $file = './' . Config::CONFIG_FILE_UPLOAD_PATH . '/' . $name;

            $file_info = $data = Database::selectOne("SELECT 
                    id, content_type, source_name, extension  
                FROM files f 
                WHERE f.name = '$name'");

            if ($file_info) {

                $file_id        = $file_info['id'];
                $name           = $file_info['source_name'];
                $content_type   = $file_info['content_type'];

                $open_file = fopen($file, 'rb');
                $stream = new \Slim\Http\Stream($open_file);

                $query = "UPDATE files 
                    SET read_date = NOW()
                    WHERE id = :id;";

                $values = ['id' => $file_id];
                    
                Database::update($query, $values);

                $response = $response
                ->withBody($stream)
                ->withHeader('Content-type', $content_type)
                ->withAddedHeader('Content-Disposition', 'attachment; filename=' . $name);
                
            } else {

                $response = $response->withJson([
                    'status' => 'success',
                    'message' => 'Неверный токен для авторизации!'
                ], 204);

            }

        } else {

            $response = $response->withJson([
                'status' => 'error',
                'message' => 'Не передан параметр \'name\' для получения файла!'
            ], 400);
            
        }         

        return $response;
    }
}
