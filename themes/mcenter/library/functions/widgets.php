<?php

if ( function_exists('register_sidebar') )
            register_sidebar(array(
        'name' => 'Bottom-Left',
        'before_widget' => '<div class="item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sub">',
        'after_title' => '</h3>',
    ));
            register_sidebar(array(
        'name' => 'Bottom-Middle',
        'before_widget' => '<div class="item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sub">',
        'after_title' => '</h3>',
    ));
            register_sidebar(array(
        'name' => 'Bottom-Right',
        'before_widget' => '<div class="item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sub">',
        'after_title' => '</h3>',
    ));
    	    register_sidebar(array(
        'name' => 'Sidebar',
        'before_widget' => '<div class="item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sub">',
        'after_title' => '</h3>',
    ));
    $news = get_option('T_news');
    if($news) {
                register_sidebar(array(
            'name' => 'Homepage Middle Column',
            'before_widget' => '<div class="item">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="sub">',
            'after_title' => '</h3>'
        ));
    }
?>
