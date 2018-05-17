# Lists plugin for Craft CMS 3.x

Allow users to add elements to a list: Product Favourites, Wishlists, Bookmarks, etc.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1.  Open your terminal and go to your Craft project:

        cd /path/to/project

2.  Then tell Composer to load the plugin:

        composer require kuriousagency/lists

3.  In the Control Panel, go to Settings → Plugins and click the “Install” button for Lists.

## Lists Overview

This is a plugin that allows you to create lists of elements. Lists can contain a mixture of element types.

## Using Lists

Lists come with 2 predefined list types: Favourites & Wishlists.

Favourites is a single list that contains products.

## Example Form

```twig
<form method="post" accept-charset="utf-8">
	{{ csrfInput() }}
	<input type="hidden" name="listType" value="favourites">
	<input type="hidden" name="elementId" value="{{ product.id }}">
	<input type="hidden" name="userId" value="{{ currentUser.id }}">

	{% if currentUser and product.id in craft.lists.favourites.ids() %}

		<input type="hidden" name="action" value="lists/items/remove-item">
		<button type="submit">remove</button>

	{% elseif currentUser %}

		<input type="hidden" name="action" value="lists/items/add-item">
		<button type="submit">add</button>

	{% endif %}

</form>
```

## Variables

get an element criteria model of favourites:

```twig
craft.lists.getFavourites(userId)
```

if no user id is passed in then the current user will be used.

get an array of wishlists:

```twig
craft.lists.getWishlists(userId)
```

get lists:

```twig
craft.lists.getLists(type, userId)
```

type is a string of whatever you want the list type to be?

check to see if a product is in the favourites list:

```
craft.lists.isFavourite(productId, userId)
```

check to see if an element is in a list:

```
craft.lists.isInList(type, elementId, userId)
```

if no user id is passed in then the current user will be used.

## Lists Roadmap

Some things to do, and ideas for potential features:

*   Might have a cp interface to see the lists?

Brought to you by [Kurious Agency](https://kurious.agency)
