<?php
/*
Extends DFP To Print plugin functionality for the Saxotech publishing system.


*/


class SaxoArticle extends DFMToPrintArticle
{

}

class SaxoUser extends DFMToPrintUser
{
    // Mapping specific to Saxo's EWS User object ( https://docs.newscyclesolutions.com/display/MWC/Editorial+Web+Service+3.0#EditorialWebService3.0-ListingUsers,Products,Categories,AccessLevels&TextFormats )
}

function send_to_saxo($post_id)
{
    $article = new SaxoArticle($post_id);
    $xml = $article->get_article();
    $target_urls = array(
    'user' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/users/%%%USERID%%%',
    'article' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/stories?timestamp=' . time(),
    'textformats' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/textformats/720743380?timestamp=' . time()
    );

$request = new DFMRequest();
$xml = $article->get_article();
$curl_options = array(
    CURLOPT_URL => $request->set_url($target_urls['article']),
    //CURLOPT_POSTFIELDS => http_build_query($params),
    //CURLOPT_POSTFIELDS => file_get_contents('saxo/story.xml'),
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_VERBOSE => 1,
    CURLOPT_HEADER => 1,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => array('Content-Type: application/xml; charset=UTF-8')
);
if ( $request->curl_options($curl_options) == true ):
    $result = $request->curl_execute();
    $request->curl_results($result);
    if ( isset($request->response) ):
        $request->curl_destroy();
    endif;
endif;

// Saxo-specific
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
    $story_id = intval(array_pop(explode('/', $request->response['header']['Location'])));
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
    //add_action( 'publish_post', 'send_to_saxo' );
    // Wrappers for the other actions we'll need to hook into.
    add_action('before_delete_post', 'remove_from_saxo');
    add_action('post_updated', 'send_to_saxo');
endif;

// *******************
//
// COMMAND-LINE USE
//
// *******************
// If we're running this file from the command line, we want to run this script.
if ( isset($_SERVER['argv'][0]) ):
    if ( isset($_SERVER['argv'][1]) ):
        // Not testing, will d/l file from Sports Direct
        // To run it this way:
        // $ php the_thermometer.php whatever-just-put-something-here
        send_to_saxo(intval($_SERVER['argv'][1]));
    else:
        // Testing, will use local files.
        send_to_saxo(1);
    endif;
endif;
 
