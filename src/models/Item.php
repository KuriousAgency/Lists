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

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class Item extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
	public $id;

	public $userId;

	public $listId;
	
	public $elementId;

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

	public function getElement()
	{
		return Craft::$app->elements->getElementById($this->elementId);
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }
}
