<?php
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

$breadcrumb = jptt_get_breadcrumb_items();

if ( empty( $breadcrumb ) ) {
	return;
}
$count = count( $breadcrumb );
?>
<ul class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?php
	foreach ( $breadcrumb as $label => $permalink ) {
		$count--;
		$class = !$count ? 'class="active"' : '';
		?>
		<li <?php echo $class; ?> itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php
				if ( !empty( $permalink ) ) {
					printf( '<a itemprop="item" href="%s"><span itemprop="name">%s</span></a>', $permalink, $label );
				} else {
					printf( '<span itemprop="item"><span itemprop="name">%s</span></span>', $label );
				}
				?>
		</li>
		<?php
	}
	?>
</ul>
