<?php
/*
Extends DFP To Print plugin functionality for the Saxotech publishing system.


*/

class SaxoMeta
{
    // Methods for handling the metadata we need from Saxo's EWS.
    public function __construct()
    {
    }
}

class SaxoArticle extends DFMToPrintArticle
{
    public function map_category($main_cat_id=0)
    {
        // Depending on the WP post's category, we assign a Saxo article category.
        // If we're passed a child category we go up the chain until we get
        // the parent category. We look up the parent category's name against
        // Saxo category names, if there's no match we default to Saxo's News
        // category.

        // *** Build a way to edit and variableize this lookup table.
        $saxo_cat_lookup = array(
            'Advance' => 13094166,
            'Business' => 915630113,
            'DFM_Wire' => 202449495,
            'Entertainment' => 384737310,
            'Features' => 223024429,
            'Lottery' => 367648250,
            'News' => 442202241,
            'Obituaries' => 267297962,
            'Opinion' => 201175805,
            'Special' => 51890536,
            'Sports' => 332831682,
            'Test' => 522425866
        );
        
        $saxo_cat_name = '';
        $cat_name = get_the_category_by_ID($main_cat_id);
        //$parent_cats = get_category_parents();
        // *** if there are cat parents get the most-senior parent and put it in $cat_name, if not then continue
        switch (strtolower($cat_name)):
            case 'business':
                $saxo_cat_name = 'Business';
            case 'entertainment':
            case 'arts':
                $saxo_cat_name = 'Entertainment';
            case 'living':
            case 'style':
            case 'lifestyle':
            case 'home':
            case 'fitness':
                $saxo_cat_name = 'Features';
            case 'obituaries':
                $saxo_cat_name = 'Obituaries';
            case 'opinion':
                $saxo_cat_name = 'Opinion';
            case 'sports':
            case 'outdoors':
                $saxo_cat_name = 'Sports';
            default:
                $saxo_cat_name = 'News';
        endswitch;

        return $saxo_cat_lookup[$saxo_cat_name];
    }

    public function get_article($newarticle = false, $post_id=0)
    {
        // Returns an xml representation of the desired article
        // Takes two parameters:
        // $newarticle, boolean, if this is an article we're adding to EWS.
        // $post_id, integer, for manual lookups of post collection field.
        $post = $this->post;
        if ( $post_id > 0 ):
            $post = get_post($post_id);
        endif;

        if ( !class_exists('Timber') ):
            include($this->path_prefix . '../timber/timber.php');
        endif;
        $context = Timber::get_context();
        $extra_context = array(
            'product_id' => 1, // *** HC for now
            //'publication_id' => 816146, // *** HC for now
            'author_print_id' => 944621807, // *** HC for now
            'category_id' => 442202241,
            'statuscode' => 1,
            'post_content_filtered' => str_replace('<p>', '<p class="TX Body">', $post->post_content),
            'post' => new TimberPost($post->ID)
        );
        if ( $newarticle === false ):
            $context['statuscode'] = 2;
            $context['updatedtime'] = date('c');
            $context['newarticle'] = $newarticle;
        endif;
        ob_start();
        
        Timber::render(array($this->article_template), array_merge($context, $extra_context));
        $xml = ob_get_clean();
        $this->log_file_write($xml);
        return $xml;
    }
}

class SaxoUser extends DFMToPrintUser
{
    // Mapping specific to Saxo's EWS User object ( https://docs.newscyclesolutions.com/display/MWC/Editorial+Web+Service+3.0#EditorialWebService3.0-ListingUsers,Products,Categories,AccessLevels&TextFormats )
}

function send_to_saxo($post_id)
{
    if ( intval($post_id) == 0 ) die("0 post_id on send_to_saxo() in class.saxo.php");
    $request = new DFMRequest();
    $newarticle_flag = TRUE;
    $url_type = 'article';
    $print_cms_id = get_post_meta($post_id, 'print_cms_id', TRUE);
    if ( intval($print_cms_id) > 0 ):
        $newarticle_flag = FALSE;
        $url_type = 'article_update';
        $request->set_print_cms_id($print_cms_id);
    endif;
    $article = new SaxoArticle($post_id);
    $target_urls = array(
    'user' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/users/%%%USERID%%%',
    'article' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/stories?timestamp=' . time(),
    'article_update' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/stories/%%%STORYID%%%?timestamp=' . time(),
    'textformats' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/textformats/720743380?timestamp=' . time()
    );

    $xml = $article->get_article($newarticle_flag);

    $curl_options = array(
    CURLOPT_URL => $request->set_url($target_urls[$url_type]),
    //CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_VERBOSE => 1,
    CURLOPT_HEADER => 1,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => array('Content-Type: application/xml; charset=UTF-8')
    );

    
    if ( $newarticle_flag === TRUE ):
        // Article creation
        if ( $request->curl_options($curl_options) == true ):
            $result = $request->curl_execute();
            $article->log_file_write($result, 'request');
            $request->curl_results($result);
            if ( isset($request->response) ):
                $request->curl_destroy();
            endif;
        endif;
    else:
        // Article update
        $curl_options[CURLOPT_CUSTOMREQUEST] = 'PUT';
    endif;


    write_log($result->response);
// If we've created a new article, we want to associate its saxo-id
// with the article in WP.
// This response will look something like:
//array(3) {
//  ["body"]=>
//  bool(false)
//  ["header"]=>
//  array(8) {
//    ["responsecode"]=>
//    string(43) "HTTP/1.1 100 Continue
//HTTP/1.1 201 Created
//"
//    ["Date"]=>
//    string(29) "Tue, 15 Apr 2014 19:39:07 GMT"
//    ["Accept-Ranges"]=>
//    string(5) "bytes"
//    ["Location"]=>
//    string(65) "https://mn1reporter.saxotech.com/ews/products/1/stories/509568932"
//    ["Server"]=>
//    string(24) "Restlet-Framework/2.0.14"
//    ["Vary"]=>
//    string(56) "Accept-Charset, Accept-Encoding, Accept-Language, Accept"
//    ["Content-Type"]=>
//    string(29) "application/xml;charset=UTF-8"
//    ["Content-Length"]=>
//    string(1) "0"
//  }
//  ["error"]=>
//  string(0) ""
//}

if ( isset($request->response['header']['Location']) ):
    // Get the story id, which will always be the last integer in the URL.
    $story_id = array_pop(explode('/', $request->response['header']['Location']));
    $article->update_post(array('print_cms_id' => $story_id));
    // *** add check to see if value already exists in custom field.
endif;
    // *** initiate curl
    // *** if this is an article update, get the saxo article id (custom field)
    // *** send document to saxo
    // *** if this is a new article, get the saxo article id and store it in a custom field
    // *** Get the response from saxo, let the user know if it failed or succeeded.
    // *** If it failed, print as many relevant details of the failure as possible.
}

function remove_from_saxo()
{
}

// If we're testing these scripts out on the terminal, add_action won't exist.
if ( function_exists('add_action') ):
    add_action( 'publish_post', 'send_to_saxo' );
    // Wrappers for the other actions we'll need to hook into.
    add_action('before_delete_post', 'remove_from_saxo');
    //add_action('post_updated', 'send_to_saxo');
endif;

// *******************
//
// COMMAND-LINE USE
//
// *******************
// If we're running this file from the command line, we want to run this script.
if ( isset($_SERVER['argv'][0]) ):
    if ( isset($_SERVER['argv'][1]) ):
        // To run it this way:
        // $ php 
        send_to_saxo(intval($_SERVER['argv'][1]));
    else:
        // Testing, will use local files.
        send_to_saxo(1);
    endif;
endif;
 
