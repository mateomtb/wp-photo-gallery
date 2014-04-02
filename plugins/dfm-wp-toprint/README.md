# DFM WP-Collection
A wordpress plugin to build hand-edited in-post link lists of in-blog content, and then publish the list in a post.

There are two types of collections: Packages and Related. Packages are for smaller, hand-edited lists of blog posts. Related are for publishing lists of posts that share the same tag.

# Use
In the template:
```<?php 
if ( class_exists('DFMCollection'):
    $collection = new DFMCollection($post);

    // Returns an array with the collection name in the first slot:
    $collection_name = $collection->get_collection();

    // Returns a collection of posts:
    $posts = $collection->get_collection_items();
endif;

//...loop through the posts here, do what you will.
```

In the WP-Admin:
* Packages are put together by tagging post objects with "package-name_of_collection"
* Any type of collection can be published on a post by selecting the collection from the Collection form field on the post edit page.

# Requirements
The Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ ) is required.

# Example Setup
1. Install The Easy Custom Fields plugin.
1. Install the DFM WP-Collections plugin.
1. Edit your theme's single.php file and add the DFMCollection-specific php. You'll have to write your own markup.
1. Create a package -- tag two or three posts "package-my_first"
1. Open another post, go to the Collections->Packages and choose "package-my_first" from the drop-down there.
1. Preview the post and see how your package displays.
