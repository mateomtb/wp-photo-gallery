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
$xml = trim($article->get_article());
//$xml = file_get_contents('/home/joe/bt-wp/plugins/dfm-wp-toprint/saxo/story.xml');
//die($xml);
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
if ( isset($request->response['header']['Location']) ):
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
 
