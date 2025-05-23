<?php
namespace Api\Models\BaseModel;


class BaseModel
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }


    /**
     * @param string $json
     * @return baseModel|null
     */
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("" . json_last_error_msg());
        }
        if (!isset($data["id"])) {
            return null;
        }
        return new baseModel($data["id"] ?? null);
    }

}