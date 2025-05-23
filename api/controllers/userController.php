<?php
namespace Api\Controllers\UserController;

use Api\Database\Database;
use Api\Database\Getters\UserModel;

class UserController
{
    // Get all Users
    public function getRanking($params)
    {
        $param = "";
        if (isset($params["movement_id"]) && is_numeric($params["movement_id"])) {
            if (!is_numeric($params["movement_id"])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid movement id']);
                return;
            }
            $param = " WHERE m.id = ? ";
        }
        if (isset($params["movement_name"])) {
            if (is_numeric($params["movement_name"])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid movement name']);
                return;
            }

            $param = " WHERE m.name = '?' ";
        }


        $query = "
                SELECT 
                        ranked_data.movement_name,
                        JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'posicao', ranked_data.posicao,
                                'recorde_pessoal', ranked_data.value,
                                'nome', ranked_data.user_name
                            )
                        ) AS ranking
                    FROM (
                        SELECT 
                            m.name AS movement_name,
                            pr.value,
                            u.name AS user_name,
                            DENSE_RANK() OVER (PARTITION BY m.id ORDER BY pr.value DESC) AS posicao
                        FROM 
                            personal_record pr
                            INNER JOIN movement m ON pr.movement_id = m.id
                            INNER JOIN user u ON u.id = pr.user_id" . $param . "
                       
                    ) AS ranked_data
                    GROUP BY 
                        ranked_data.movement_name;";


        $db = new Database();
        $stmt = $db->executeStatement($query);

        $result = $stmt->get_result(); // Get the result set from mysqli

        $row = $result->fetch_assoc();
        $row = array_map('htmlspecialchars_decode', $row);
        $json = json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            http_response_code(500);
            echo json_encode(['message' => 'Error encoding JSON']);
            return;
        }
        http_response_code(200);
        echo $json;
    }
}