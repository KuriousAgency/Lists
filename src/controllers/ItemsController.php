<?php
/**
 * Lists plugin for Craft CMS 3.x
 *
 * Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\lists\controllers;

use kuriousagency\lists\Plugin;
use kuriousagency\lists\models\Item;

use Craft;
use craft\web\Controller;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ItemsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [
		'add-item',
		'remove-item',
	];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionAddItem()
    {
		$this->requirePostRequest();
		$session = Craft::$app->getSession();

		$item = new Item();
		$item->userId = Craft::$app->getRequest()->getBodyParam('userId', Craft::$app->getUser()->id);
		$item->elementId = Craft::$app->getRequest()->getBodyParam('elementId');

		$listType = Craft::$app->getRequest()->getBodyParam('listType');
		$listId = Craft::$app->getRequest()->getBodyParam('listId');
		if($listId){
			$list = Plugin::$app->lists->getListById($listId);
		}else{
			$list = Plugin::$app->lists->getListsByType($listType, $item->userId)[0];
		}
		
		if($list){
			if($list->userId == $item->userId){
				$item->listId = $list->id;
				Plugin::$app->items->saveItem($item);

				return $this->redirectToPostedUrl($item);
			}
		}

		$session->setError(Craft::t('lists', 'Unable to add item.'));

		Craft::$app->getUrlManager()->setRouteParams([
            'item' => $item
        ]);

        return null;
    }

    /**
     * @return mixed
     */
    public function actionRemoveItem()
    {
        $this->requirePostRequest();

		$userId = Craft::$app->getRequest()->getBodyParam('userId', Craft::$app->getUser()->id);
		$elementId = Craft::$app->getRequest()->getBodyParam('elementId');
		$id = Craft::$app->getRequest()->getBodyParam('id');

		$listType = Craft::$app->getRequest()->getBodyParam('listType');
		$listId = Craft::$app->getRequest()->getBodyParam('listId');
		if($listId){
			$list = Plugin::$app->lists->getListById($listId);
		}else{
			$list = Plugin::$app->lists->getListsByType($listType, $userId)[0];
		}

		if(!$id){
			$id = Plugin::$app->items->getItemByElementId($elementId, $list->id, $userId)->id;
		}

		if($list->userId == $userId && Plugin::$app->items->deleteItemById($id)){
			return $this->redirectToPostedUrl();
		}

		$session = Craft::$app->getSession();
		$session->setError(Craft::t('lists', 'Unable to remove item.'));

		Craft::$app->getUrlManager()->setRouteParams([
        ]);

        return null;
    }
}
