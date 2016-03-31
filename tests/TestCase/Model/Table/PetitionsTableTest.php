<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PetitionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PetitionsTable Test Case
 */
class PetitionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PetitionsTable
     */
    public $Petitions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.petitions',
        'app.users',
        'app.items',
        'app.offers',
        'app.tags',
        'app.items_tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Petitions') ? [] : ['className' => 'App\Model\Table\PetitionsTable'];
        $this->Petitions = TableRegistry::get('Petitions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Petitions);

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
