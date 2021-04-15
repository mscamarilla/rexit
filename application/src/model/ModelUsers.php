<?php


namespace Model;

use Core\Model;


/**
 * Class ModelUsers
 * @package Model
 */
class ModelUsers extends Model
{
    /**
     * @param int $page
     * @param int $limit
     * @param array $filters
     * @return array
     * @throws \Exception
     */
    public function getUsers(int $page, int $limit, array $filters): array
    {
        $offset = $page * $limit - $limit;

        $users = array();

        $sql = "SELECT *";

        if (!empty($filters['age']) || !empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= ", TIMESTAMPDIFF(YEAR,birthDate,CURDATE()) as age";
        }

        $sql .= " FROM users WHERE id > 0"; //id > 0 is necessary in order to be able to add AND`s below

        if (!empty($filters['category'])) {
            $sql .= " AND category = '" . $filters['category'] . "'";
        }

        if (!empty($filters['gender'])) {
            $sql .= " AND gender = '" . $filters['gender'] . "'";
        }

        if (!empty($filters['birthDate'])) {
            $sql .= " AND birthDate = '" . $filters['birthDate'] . "'";
        }

        if (!empty($filters['age']) || !empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= " HAVING id > 0";//id > 0 is necessary in order to be able to add AND`s below
        }

        if (!empty($filters['age'])) {
            $sql .= " AND age = '" . $filters['age'] . "'";
        }

        if (!empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= " AND age > '" . $filters['agesFrom'] . "' AND age < '" . $filters['agesTo'] . "'";
        }

        if (!empty($page)) {
            $sql .= " LIMIT " . $limit . " OFFSET " . $offset;
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {

            foreach ($query->rows as $row) {
                $users[] = $row;
            }
        }

        return $users;
    }

    /**
     * @param array $filters
     * @return int
     * @throws \Exception
     */
    public function GetTotalUsers(array $filters): int
    {
        $total = 0;

        $sql = "SELECT id, COUNT(*) as total";

        if (!empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= " FROM (SELECT *";
        }

        if (!empty($filters['age']) || !empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= ", TIMESTAMPDIFF(YEAR,birthDate,CURDATE()) as age";
        }

        $sql .= " FROM users WHERE id > 0"; //id > 0 is necessary in order to be able to add AND`s below

        if (!empty($filters['category'])) {
            $sql .= " AND category = '" . $filters['category'] . "'";
        }
        if (!empty($filters['gender'])) {
            $sql .= " AND gender = '" . $filters['gender'] . "'";
        }
        if (!empty($filters['birthDate'])) {
            $sql .= " AND birthDate = '" . $filters['birthDate'] . "'";
        }

        if (!empty($filters['age']) || !empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= " HAVING id > 0"; //id > 0 is necessary in order to be able to add AND`s below
        }

        if (!empty($filters['age'])) {
            $sql .= " AND age = '" . $filters['age'] . "'";
        }

        if (!empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= " AND age > '" . $filters['agesFrom'] . "' AND age < '" . $filters['agesTo'] . "'";
        }

        if (!empty($filters['agesFrom']) || !empty($filters['agesTo'])) {
            $sql .= ") as sub";
        }

        $query = $this->db->query($sql);


        if ($query->num_rows) {
            $total = $query->row['total'];
        }

        return $total;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCategories(): array
    {
        $categories = array();
        $sql = "SELECT * FROM users GROUP BY category;";
        $query = $this->db->query($sql);

        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $categories[] = $row['category'];
            }
        }

        return $categories;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getGenders(): array
    {
        $genders = array();
        $sql = "SELECT * FROM users GROUP BY gender;";
        $query = $this->db->query($sql);

        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $genders[] = $row['gender'];
            }
        }

        return $genders;
    }

}
