<?php
namespace Api\Controllers\UserController;

use Api\Database\Database;
use Api\Database\Getters\UserModel;

class UserController
{
    // Get all Users
    public function getRanking(array|null $params)
    {
        $query = `SELECT 
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
                            INNER JOIN user u ON u.id = pr.user_id
                        WHERE 
                            m.id = 2
                    ) AS ranked_data
                    GROUP BY 
                    ranked_data.movement_name;`;


        // $db = new Database();
        // $stmt = $db->executeStatement($query);

        // $result = $stmt->get_result(); // Get the result set from mysqli
        // $users = array();

        // while ($row = $result->fetch_assoc()) {

        //     $user = UserModel::fromJson(json_encode($row));
        //     array_push($items, $user);
        // }

        http_response_code(200);
        echo json_encode($params);
    }
}