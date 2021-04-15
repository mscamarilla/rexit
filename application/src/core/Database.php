<?php


namespace Core;


/**
 * Class Database
 * @package Core
 */
class Database implements DatabaseInterface
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @var \MySQLi
     */
    public $db;

    /**
     * @return Database
     * @throws \Exception
     */
    public static function getInstance():Database
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Database constructor.
     * @throws \Exception
     */
    private function __construct()
    {
        $this->db = $this->makeConnection();
    }

    /**
     * Clone
     */
    private function __clone()
    {
    }

    /**
     * Wakeup
     */
    private function __wakeup()
    {
    }

    /**
     * Set Connection
     * @return object
     * @throws \Exception
     */
    public function makeConnection():object
    {
        $config = parse_ini_file('/application/config.ini', true);

        $connect = new \MySQLi(
            $config['db']['db_host'],
            $config['db']['db_user'],
            $config['db']['db_password'],
            $config['db']['db_name'],
            3306);
        $db = $connect;
        mysqli_options($db, MYSQLI_OPT_LOCAL_INFILE, true);


        if ($db->connect_error) {
            throw new \Exception('MySQL DB connect failed!');

        } else {
            $db->set_charset("utf8");
            $db->query("SET SQL_MODE = ''");
        }

        return $db;

    }

}
