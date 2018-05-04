<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\migrations;

use kuriousagency\lists\Plugin;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            //$this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%lists_items}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%lists_items}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'elementId' => $this->integer()->notNull(),
					'listId' => $this->integer()->notNull(),
					'userId' => $this->integer()->notNull(),
                ]
            );
        }

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%lists_itemlists}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%lists_itemlists}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
					'siteId' => $this->integer()->notNull(),
					'userId' => $this->integer()->notNull(),
					'type' => $this->string(),
					'title' => $this->string(),
					'description' => $this->string(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(
            $this->db->getIndexName(
                '{{%lists_items}}',
                'some_field',
                true
            ),
            '{{%lists_items}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }

        $this->createIndex(
            $this->db->getIndexName(
                '{{%lists_itemlists}}',
                'some_field',
                true
            ),
            '{{%lists_itemlists}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_items}}', 'siteId'),
            '{{%lists_items}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
		
		$this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_items}}', 'elementId'),
            '{{%lists_items}}',
            'elementId',
            '{{%elements}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
		
		$this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_items}}', 'listId'),
            '{{%lists_items}}',
            'listId',
            '{{%lists_itemlists}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
		
		$this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_items}}', 'userId'),
            '{{%lists_items}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
		

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_itemlists}}', 'siteId'),
            '{{%lists_itemlists}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
		
		$this->addForeignKey(
            $this->db->getForeignKeyName('{{%lists_itemlists}}', 'userId'),
            '{{%lists_itemlists}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
		);
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%lists_items}}');

        $this->dropTableIfExists('{{%lists_itemlists}}');
    }
}
