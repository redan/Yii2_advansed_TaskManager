<?php namespace frontend\tests;

use common\models\tables\Tasks;

class FirsTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $taskParams array
     */
    protected $taskParams = [
        'task' => [
            'creator_id' => 2,
            'name' => 'Task123',
            'deadline' => '2019-02-07',
            'description' => 'description for task123',
            'status_id' => 2,
        ]
    ];
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCheckClanAR() {
        $clan = new Tasks();
        $clan->load($this->taskParams);

        // по-умолчанию фикстура содержит корректные данные
        $this->assertTrue($clan->validate());
        // проверю собственные геттеры
        $fullClanTag = '[' . $clan->tag . ']';
        $this->assertTrue($clan->fullClanTag === $fullClanTag);
        // проверю, что ломается там, где должно
        $clan->clan_id = null;
        $this->assertFalse($clan->validate());
    }
}