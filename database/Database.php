<?php 

namespace Database;

use Config\Config;
use PDO;

/**
 * Класс описания ДБ и методов работы с ней
 */
class Database 
{
    /** @var resource $db Дескриптор подключения */
    static private $db;

    /**
     * Метод для инициализации подключения
     * 
     * @return void
     */
    static public function init()
    {
        self::$db = new PDO(
            'mysql:'
            . 'dbname=' . Config::CONFIG_DB_NAME . ';'
            . 'host=' . Config::CONFIG_DB_HOST , 
            Config::CONFIG_DB_USER,
            Config::CONFIG_DB_PASS
        );
    }

    /**
     * Метод для INSERT-запросов в базу
     * 
     * @param string $query Строка с запросом
     * @param array $values Ассоциативный массив со значениями для запроса
     * 
     * @return void
     */
    static public function insert(string $query, array $values = []) 
    {
        self::$db->prepare($query)->execute($values);
    }

    /**
     * Метод для UPDATE-запросов в базу
     * 
     * @param string $query Строка с запросом
     * @param array $values Ассоциативный массив со значениями для запроса
     * 
     * @return void
     */
    static public function update(string $query, array $values = []) 
    {
        self::$db->prepare($query)->execute($values);
    }

    /**
     * Метод для SELECT запросов с одним результатом
     * 
     * @param string $query Строка с запросом
     * 
     * @return array Массив с ключами и данными
     */
    static public function selectOne(string $query) 
    {
        return self::$db->query($query)->fetch();
    }
}