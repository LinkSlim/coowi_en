<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudiesTable Test Case
 */
class StudiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudiesTable
     */
    public $Studies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Studies') ? [] : ['className' => 'App\Model\Table\StudiesTable'];
        $this->Studies = TableRegistry::get('Studies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Studies);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
