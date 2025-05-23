<?php
namespace Api\Controllers\UserController;

use Api\Database\Database;

class UserController
{
    // Get all items
    public function getAllItems()
    {
        $query = "SELECT * FROM user ORDER BY id ASC";
        $db = new Database();
        $stmt = $db->executeStatement($query);

        $result = $stmt->get_result(); // Get the result set from mysqli
        $items = array();

        while ($row = $result->fetch_assoc()) {
            $item = array(
                "id" => $row['id'], // Make sure this matches your column name
                "name" => $row['name'],
                "description" => html_entity_decode($row['description'])
            );
            array_push($items, $item);
        }

        http_response_code(200);
        echo json_encode($items);
    }
}