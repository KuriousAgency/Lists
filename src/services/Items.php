<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\services;

use kuriousagency\lists\Plugin;
use kuriousagency\lists\models\Item;
use kuriousagency\lists\records\Item as ItemRecord;

use Craft;
use craft\base\Component;
use craft\db\Query;
use yii\base\InvalidArgumentException;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class Items extends Component
{
    // Public Methods
    // =========================================================================

	public function getItemById(int $id)
	{
		$record = ItemRecord::findOne($id);

		return $record ? new Item($record) : null;
	}

	public function getItemByElementId(int $elementId, int $listId, int $userId)
	{
		$record = ItemRecord::find()->where([
			'listId' => $listId,
			'elementId' => $elementId,
			'userId' => $userId,
		])->one();

		if(!$record){
			return null;
		}

		return new Item($record);
	}

	public function getItemsByList(int $id, $ids=false): array
	{
		$records = ItemRecord::find()->where([
			'listId' => $id,
		])->all();

		$items = [];

		foreach($records as $record)
		{
			$model = new Item($record);
			$items[] = $ids ? $model->id : $model;
		}

		return $items;
	}

	public function getItemsAttributeByList(int $id, $attr): array
	{
		$records = ItemRecord::find()->where([
			'listId' => $id,
		])->all();

		$items = [];

		foreach($records as $record)
		{
			$model = new Item($record);
			$items[] = $model->{$attr};
		}

		return $items;
	}

	public function saveItem(Item $model): bool
	{
		$plugin = Plugin::getInstance();

		if($isNew = !$model->id){
			$record = new ItemRecord();
		}else{
			$record = ItemRecord::findOne($model->id);
			if(!$record){
				throw new InvalidArgumentException('No item exists with the ID “{id}”', ['id' => $model->id]);
			}
		}

		if(!$model->validate()){
			Craft::info('Item could not save due to validation error.', __METHOD__);
			return false;
		}

		$record->elementId = $model->elementId;
		$record->listId = $model->listId;
		$record->userId = $model->userId;
		$record->siteId = Craft::$app->sites->currentSite->id;

		$record->save(false);

		if($isNew){
			$model->id = $record->id;
		}

		return true;
	}

	public function deleteItemById(int $id): bool
	{
		$record = ItemRecord::findOne($id);

		if(!$record){
			return false;
		}

		return (bool)$record->delete();
	}

	public function deleteItemsByList(int $id): bool
	{

	}

	public function deleteItemsByUser(int $id): bool
	{
	
	}
}
