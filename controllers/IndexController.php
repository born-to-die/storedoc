<?php

namespace Controllers;

use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Класс для проверки аутентификации
 * 
 * @category Controllers
 */
class IndexController 
{
    /**
     * Метод для проверки того, что всё работает
     * 
     * @param Container $app Slim Container
     * @param Request $request Запрос
     * @param Response $response Ответ
     * 
     * @return Response
     */
    static public function index(Container $app, Request $request, Response $response) {

        $data = [
            'status' => 'succes',
            'data' => [],
            'message' => 'Всё работает, вы авторизованы',
        ];
        $response = $response->withJson($data, 201);
    
        return $response;

    }

}
