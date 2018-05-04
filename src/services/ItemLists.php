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
use kuriousagency\lists\records\ItemsList as ListRecord;
use kuriousagency\lists\models\ItemsList as ListModel;
use Craft;
use craft\db\Query;
use craft\base\Component;
use yii\base\InvalidArgumentException;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ItemLists extends Component
{
    // Public Methods
    // =========================================================================

	public function getListById(int $id)
	{
		$record = ListRecord::findOne($id);

		return $record ? new ListModel($record) : null;
	}

	public function getListsByType($type, int $id): array
	{
		$records = ListRecord::find()->where([
			'type' => $type,
			'userId' => $id,
		])->all();

		$lists = [];

		foreach($records as $record)
		{
			$lists[] = new ListModel($record);
		}

		return $lists;
	}

	public function getListsByUser(int $id): array
	{
		$records = ListRecord::find()->where([
			'userId' => $id,
		])->all();

		$lists = [];

		foreach($records as $record)
		{
			$lists[] = new ListModel($record);
		}

		return $lists;
	}


	public function saveList(ListModel $model): bool
	{
		$plugin = Plugin::getInstance();

		if($isNew = !$model->id){
			$record = new ListRecord();
		}else{
			$record = ListRecord::findOne($model->id);
			if(!$record){
				throw new InvalidArgumentException('No list exists with the ID “{id}”', ['id' => $model->id]);
			}
		}

		if(!$model->validate()){
			Craft::info('List could not save due to validation error.', __METHOD__);
			return false;
		}

		$record->title = $model->title;
		$record->description = $model->description;
		$record->type = $model->type;
		$record->userId = $model->userId;
		$record->siteId = Craft::$app->sites->currentSite->id;

		$record->save(false);

		if($isNew){
			$model->id = $record->id;
		}

		return true;
	}

	public function deleteListById(int $id): bool
	{
		$record = ListRecord::findOne($id);

		if(!$record){
			return false;
		}

		return (bool)$record->delete();
	}

}
