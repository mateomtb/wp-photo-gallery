<?php
/**
 * The Template for displaying all single posts
 *
 *
 * @package  WordPress
 * @subpackage  Timber
 */

$context = array();
$domain_bits = explode('.', $_SERVER['HTTP_HOST']);
$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $domain_bits[1]);
$context['dynamic_sidebar'] = Timber::get_widgets('dynamic_sidebar');
Timber::render(array('sidebar.twig'), $context);

//include polls in sidebar
if (function_exists('vote_poll') && !in_pollarchive()): ?>  
  <li>  
    <ul>  
      <li><?php get_poll();?></li>  
    </ul>  
    <?php display_polls_archive_link(); ?>  
  </li>  
<?php endif; ?>
