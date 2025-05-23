<?php
namespace Api\Database\Getters;

use Api\Tools\SanitizeParameters\SanitizeParameters;

use Api\Database\Database;
use mysqli_stmt;
class UserModel extends Database
{
    /**
     * @param array $params
     * @param int|null $limit
     * @param int|null $offset
     * @return bool|mysqli_stmt
     */
    public function getUsers($params = [], $limit = null, $offset = null)
    {
        SanitizeParameters::sanitizeParameters($params);
        return $this->executeStatement("SELECT * FROM user ORDER BY user_id ASC LIMIT ?");
    }

    /**
     * Ranking of Users
     * @param mixed $limit
     * @return bool|mysqli_stmt
     */
    public function getUsersRanking($params = [], $limit = null, $offset = null)
    {
        SanitizeParameters::sanitizeParameters($params);
        return $this->executeStatement("SELECT * FROM user ORDER BY user_id ASC LIMIT ?");
    }



}