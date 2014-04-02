<?php
/*
Extends DFP To Print plugin functionality for the Saxotech publishing system.


*/


class SaxoArticle extends DFMToPrintArticle
{

}

class SaxoUser extends DFMToPrintUser
{

}

function send_to_saxo($post_id)
{
    $article = new DFMSaxoArticle($post_id);
    $xml = $article->get_article();
    // *** initiate curl
    // *** if this is an article update, get the saxo article id (custom field)
    // *** send document to saxo
    // *** if this is a new article, get the saxo article id and store it in a custom field
    // *** Get the response from saxo, let the user know if it failed or succeeded.
    // *** If it failed, print as many relevant details of the failure as possible.
}
add_action( 'save_post', 'send_to_saxo' );
