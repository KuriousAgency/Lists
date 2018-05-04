<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\variables;

use kuriousagency\lists\Plugin;
use kuriousagency\lists\models\ItemsList;
use kuriousagency\lists\services\ItemLists;
use kuriousagency\lists\services\Items;

use Craft;
use craft\commerce\elements\Product;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ListsVariable
{
    // Public Methods
    // =========================================================================

	public function getFavourites($userId=null)
	{
		if(!$userId){
			//$user = Craft::$app->getUser()->getIdentity();
			//$userId = $user->id;
			$userId = Craft::$app->getUser()->id;
		}
		
		$list = Plugin::$app->lists->getListsByType('favourites', $userId);

		if(!count($list)){
			$model = new ItemsList();
			$model->title = 'Favourites';
			$model->type = 'favourites';
			$model->userId = $userId;
			if(Plugin::$app->lists->saveList($model)){
				//$elementIds = $model->getItemsWithAttribute('elementId');
				return $model->items;
			}
		}else{
			//$elementIds = $list[0]->getItemsWithAttribute('elementId');
			return $list[0]->items;
		}
	}

	public function getWishlists($userId)
	{
		return Plugin::$app->lists->getListsByType('wishlists', $userId);
	}

	public function getLists($type, $userId)
	{
		return Plugin::$app->lists->getListsByType($type, $userId);
	}

	public function isFavourite($elementId, $userId=null)
	{
		return $this->isInList('favourites', $elementId, $userId);
	}

	public function isInList($listType, $elementId, $userId=null)
	{
		if(!$userId){
			$userId = Craft::$app->getUser()->id;
		}

		$list = Plugin::$app->lists->getListsByType($listType, $userId);

		if(count($list)){
			return Plugin::$app->items->getItemByElementId($elementId, $list[0]->id, $userId) ? true : false;
		}

		return false;
	}

}
