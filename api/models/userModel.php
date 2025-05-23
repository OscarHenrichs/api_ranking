<?php
namespace Api\Database\Getters;

use Api\Tools\ValidateParameters\ValidateParameters;

use Api\Database\Database;
use mysqli_stmt;
class UserModel extends Database
{
    /**
     * @param array $params
     * @param limit $limit
     * @param offset $offset
     * @return bool|mysqli_stmt
     */
    public function getUsers($params = [], $limit = null, $offset = null)
    {
        ValidateParameters::sanitizeParams($params);
        return $this->executeStatement("SELECT * FROM users ORDER BY user_id ASC LIMIT ?");
    }

    /**
     * Ranking of Users
     * @param mixed $limit
     * @return bool|mysqli_stmt
     */
    public function getUsersRanking($params = [], $limit = null, $offset = null)
    {
        ValidateParameters::sanitizeParams($params);
        return $this->executeStatement("SELECT * FROM users ORDER BY user_id ASC LIMIT ?");
    }

    /**
     * @param array $params
     * @return bool|mysqli_stmt
     */
    public function postUsers($params = [])
    {
        ValidateParameters::sanitizeParams($params);
        return $this->executeStatement("SELECT * FROM users ORDER BY user_id ASC LIMIT ?");
    }


    /**
     * @param array $params
     * @return bool|mysqli_stmt
     */
    public function UpdateUsers($params = [])
    {

        ValidateParameters::sanitizeParams($params);

        if (isset($params['user_id'])) {
            $userId = (int) $params['user_id'];
        } else {
            return false;
        }
        return $this->executeStatement("SELECT * FROM users ORDER BY user_id ASC LIMIT ?");
    }

    /**
     * @param integer $params
     * @return bool|\mysqli_stmt
     */
    public function DeleteUser($userId = 0)
    {
        if ($userId > 0) {
            $userId = (int) $userId;
        }
        ValidateParameters::validateParams($userId);
        return $this->executeStatement("DELETE FROM users WHERE user_id = ?");
    }


}