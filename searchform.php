<?php
/**
 * The template for displaying the searchform
 *
 * @package QHFZBIO
 */
?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _e( 'Search for:', 'QHFZBIO' ); ?></span>
		<input type="search" class="s" placeholder="<?php echo esc_attr_e( 'Search', 'QHFZBIO' ); ?>" value="<?php echo get_search_query(); ?>" name="s" size="10"/>
	</label>
	<button type="submit" class="searchsubmit" aria-label="<?php echo _e( 'Search', 'QHFZBIO' ); ?>"><i class="icon-search2"></i><i class="icon-search2"></i></button>
</form>
