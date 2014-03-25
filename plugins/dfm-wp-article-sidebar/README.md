# DFM WP In-Article Teaser
A wordpress plugin to 


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

# Requirements
The Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ ) is required.

# Example Setup
1. Install The Easy Custom Fields plugin.
1. Install the DFM WP-Collections plugin.
