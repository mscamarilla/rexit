<?php


namespace Model;


use Core\Model;

/**
 * Class ModelIndex
 * @package Model
 */
class ModelIndex extends Model
{
    /**
     * Check if tables are exist
     * @return bool
     * @throws \Exception
     */
    public function checkTables(): bool
    {
        $sql = "SHOW TABLES LIKE 'users'";
        $query = $this->db->query($sql);

        if ($query->num_rows) {
            return true;
        } else {
            $this->createTables();
            return false;
        }

    }

    /**
     * Create tables
     * @throws \Exception
     */
    public function createTables()
    {
        $sql = "CREATE TABLE `users` (`id` int(11) NOT NULL AUTO_INCREMENT, `category` varchar(255),`firstname` varchar(255),`lastname` varchar(255),`email` varchar(255), `gender` varchar(255), `birthDate` date, PRIMARY KEY (`id`));";
        $this->db->query($sql);

    }

    /**
     * Import from file to DB
     * @param string $filePath
     * @throws \Exception
     */
    public function import( string $filePath)
    {
        $this->db->query("LOAD DATA LOCAL INFILE '" . $filePath . "' INTO TABLE users FIELDS TERMINATED by ',' LINES TERMINATED BY '\n' IGNORE 1 LINES (category,firstname,lastname,email,gender,birthDate);");
        $this->db->query("CREATE INDEX birthDate ON users(birthDate)");
    }
}
