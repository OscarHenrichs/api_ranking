<?php
namespace Api\Database\Getters;

use Api\Tools\SanitizeParameters\SanitizeParameters;

use Api\Database\Database;
use mysqli_stmt;
class UserModel extends Database
{
    private $id;
    public $name;

    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

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

    /**
     * @param string $json
     * @return UserModel|null
     */
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("" . json_last_error_msg());
        }
        if (!isset($data["id"]) && !isset($data["name"])) {
            return null;
        }
        return new UserModel($data["id"] ?? null, $data["name"] ?? null);
    }

}