<?php
use PHPUnit\Framework\TestCase;

class RankingDataTest extends TestCase
{
    /**
     * 
     * @return void
     */
    public function testRankingDataStructure()
    {
        $sampleData = [
            'movement_name' => 'Back Squat',
            'ranking' => '[{"nome": "Joao", "posicao": 1, "recorde_pessoal": 130.0}]'
        ];

        $this->assertArrayHasKey('movement_name', $sampleData);
        $this->assertArrayHasKey('ranking', $sampleData);

        $ranking = json_decode($sampleData['ranking'], true);
        $this->assertIsArray($ranking);

        if (count($ranking) > 0) {
            $firstItem = $ranking[0];
            $this->assertArrayHasKey('nome', $firstItem);
            $this->assertArrayHasKey('posicao', $firstItem);
            $this->assertArrayHasKey('recorde_pessoal', $firstItem);

            $this->assertIsString($firstItem['nome']);
            $this->assertIsInt($firstItem['posicao']);
            $this->assertIsFloat($firstItem['recorde_pessoal']);
        }
    }

    /**
     * @return void
     */
    public function testRankingPositionsOrder()
    {
        $sampleData = [
            'movement_name' => 'Back Squat',
            'ranking' => '[{"nome": "Joao", "posicao": 1, "recorde_pessoal": 130.0}, {"nome": "Jose", "posicao": 1, "recorde_pessoal": 130.0}, {"nome": "Paulo", "posicao": 2, "recorde_pessoal": 125.0}]'
        ];

        $ranking = json_decode($sampleData['ranking'], true);

        $previousPosition = 0;
        $previousRecord = PHP_FLOAT_MAX;

        foreach ($ranking as $item) {
            $this->assertLessThanOrEqual($previousRecord, $item['recorde_pessoal']);
            $this->assertGreaterThanOrEqual($previousPosition, $item['posicao']);

            // Se o recorde for igual, a posição pode ser a mesma
            if ($item['recorde_pessoal'] < $previousRecord) {
                $this->assertGreaterThan($previousPosition, $item['posicao']);
            }

            $previousPosition = $item['posicao'];
            $previousRecord = $item['recorde_pessoal'];
        }
    }
}