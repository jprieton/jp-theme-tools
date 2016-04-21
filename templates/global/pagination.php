<?php
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$class = (string) apply_filters('bs_pagination', 'bs-pagination');
?>
<nav itemscope itemtype="http://schema.org/SiteNavigationElement" class="<?php echo $class ?>">
		<?php
		$args = array(
				'type' => 'list',
		);
		$paginate = paginate_links( $args );
		$search = array(
				"<ul class='page-numbers'>",
				"<li><span class='page-numbers current'>"
		);
		$replace = array(
				"<ul class='page-numbers pagination'>",
				"<li class='active'><span class='page-numbers current'>"
		);
		echo str_replace( $search, $replace, $paginate )
		?>
</nav>
