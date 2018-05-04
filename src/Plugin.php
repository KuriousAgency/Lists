<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists;

use kuriousagency\lists\services\Items as ItemsService;
use kuriousagency\lists\services\ItemLists as ItemListsService;
use kuriousagency\lists\variables\ListsVariable;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Elements;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Lists
 *
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 *
 * @property  ItemsService $items
 * @property  ItemListsService $lists
 */
class Plugin extends BasePlugin
{

    // Public Properties
	// =========================================================================
	
	public static $app;

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
		parent::init();
		self::$app = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('lists', ListsVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'lists',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
