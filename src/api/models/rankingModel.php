<?php
namespace Api\Models\RankingModel;

use Api\Models\BaseModel\BaseModel;
class RankingModel extends BaseModel
{
    private $rank;
    private $userId;
    private $score;

    public function __construct($rank = null, $userId = null, $score = null)
    {
        parent::__construct($rank);
        $this->rank = $rank;
        $this->userId = $userId;
        $this->score = $score;
    }

    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("" . json_last_error_msg());
        }
        return new RankingModel($data["rank"] ?? null, $data["userId"] ?? null, $data["score"] ?? null);
    }
}