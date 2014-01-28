<?php
    // Rudimentary domain chunk. 
    // Works for domains in the style of "www.domain.com" -- as in, 
    // it takes the chunk after the first '.' in the string.
    $domain_bits = explode('.', $_SERVER['HTTP_HOST']);
	$context['domain'] = $domain_bits[1];
	$context['mode'] = 'article';
	$context['section'] = '';
    $context['sidebar'] = Timber::get_sidebar('sidebar.php');

