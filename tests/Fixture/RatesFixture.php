<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RatesFixture
 *
 */
class RatesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user1_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user2_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comment' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'rate' => ['type' => 'decimal', 'length' => 2, 'precision' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'state' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => 'activado', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_evaluates' => ['type' => 'index', 'columns' => ['user1_id'], 'length' => []],
            'fk_is_evaluated' => ['type' => 'index', 'columns' => ['user2_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_is_evaluated' => ['type' => 'foreign', 'columns' => ['user2_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_evaluates' => ['type' => 'foreign', 'columns' => ['user1_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user1_id' => 1,
            'user2_id' => 1,
            'comment' => 'Lorem ipsum dolor sit amet',
            'rate' => 1.5,
            'date' => '2016-03-30',
            'state' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
