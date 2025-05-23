<?php
namespace Api\Controllers\UserController;
class UserController extends Model
{

    // Get all items
    public function getAllItems()
    {
        $query = "SELECT * FROM users ORDER BY user_id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $items = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $item = array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description)
            );
            array_push($items, $item);
        }

        http_response_code(200);
        echo json_encode($items);
    }


}