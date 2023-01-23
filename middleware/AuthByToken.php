<?php 

namespace Middleware;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Config\Config;

/**
 * Middleware-класс для проверки аутентификации
 * 
 * @category middleware
 */
class AuthByToken
{
    /**
     * Проверяет токен
     * @param Request $request
     * @param Response $response
     * @param Next $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next) 
    {       
        
        if (isset($request->getQueryParams()['token'])) {
    
            $token_request = $request->getQueryParams()['token'];
    
            if (in_array($token, Config::TOKENS)) {
                $response = $next($request, $response);
            }
            else {
                $response = $response->withJson([
                    'status' => 'error',
                    'message' => 'Неверный токен для авторизации!'
                ], 401);
            }
    
        }
        else {
            $response = $response->withJson([
                'status' => 'error',
                'message' => 'Отсутствует токен для авторизации!'
            ], 401);
        }
    
        return $response;
    }

}

