<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\records;

use kuriousagency\lists\Plugin;

use Craft;
use craft\db\ActiveRecord;
use yii\db\ActiveQueryInterface;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ItemsList extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lists_itemlists}}';
	}
	
	/**
     * Returns the list's user
     *
     * @return ActiveQueryInterface The relational query object.
     */
    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['id' => 'listId']);
    }
}
