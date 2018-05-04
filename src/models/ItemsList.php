<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\models;

use kuriousagency\lists\Plugin;

use Craft;
use craft\base\Model;
use craft\db\Query;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ItemsList extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
	public $id;

	public $userId;
	
	public $title;

	public $description;

	public $type;

    /**
     * @var DateTime|null
     */
    public $dateCreated;

    /**
     * @var DateTime|null
     */
	public $dateUpdated;
	
	public $uid;
	public $siteId;

    // Public Methods
	// =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
	}
	
	public function getItems($type=null) //type = element class (full path)
	{
		$elementIds = Plugin::$app->items->getItemsAttributeByList($this->id, 'elementId');

		if($this->type == 'favourites' || $this->type == 'wishlist'){
			$type = 'craft\commerce\elements\Product';
		}
		
		if(!$type){
			
			$elements = [];
			foreach($elementIds as $id)
			{
				$elements[] = Craft::$app->elements->getElementById($id);
			}

			return $elements;
		}

		$query = $type::find();
        Craft::configure($query, ['id' => $elementIds]);
        return $query;
	}

	public function getItemIds()
	{
		return Plugin::$app->items->getItemsByList($this->id, true);
	}

	public function getItemsWithAttribute($attr)
	{
		return Plugin::$app->items->getItemsAttributeByList($this->id, $attr);
	}
}
