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

use Craft;
use craft\web\Controller;

/**
 * @author    Kurious Agency
 * @package   Lists
 * @since     0.0.1
 */
class ListsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [
		'create-list',
		'delete-list',
	];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionCreateList()
    {
        
    }

    /**
     * @return mixed
     */
    public function actionDeleteList()
    {
        
    }
}
