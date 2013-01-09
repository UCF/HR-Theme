<?php get_header(); ?>	
<?php
// Determine if Relevanssi is installed. If it is,
// use the standard loop so Relevanssi can modify it,
// otherwise we want to use a custom query 

if (is_plugin_active('relevanssi/relevanssi.php') == true) { ?>

	<?php the_post(); ?>
	<div class="row page-content" id="search-results">
		<div class="span12" id="page-top">
			<h1>Search Results for "<?=htmlentities($_GET['s'])?>"</h1>
		</div>
		<div class="span12">
			<article>
				<?php if(have_posts()):?>
					<ul class="result-list">
					<?php while(have_posts()): the_post();?>
						<li class="item">
							<h3>
								<a 
								<?php if ($post->post_type == 'resourcelink') { ?>
									class="<?=ResourceLink::get_document_application($post)?>" href="<?=ResourceLink::get_url($post)?>">
								<?php 
								} else {
								?>
									href="<?=the_permalink()?>">
								<?php } ?>
									<?=the_title()?>
								</a>
							</h3>
							<?php
								$ancestors = get_post_ancestors($post->ID);
								if ($ancestors) { ?>
									<p class="result-breadcrumbs"><small>under
									<?php
									krsort($ancestors);
									foreach ($ancestors as $ancestor) {
										print '<a href="'.get_permalink($ancestor).'">'.get_post($ancestor)->post_title.'</a>';
										if ($ancestor !== end($ancestors)) {
											print ' &raquo; ';
										}
									}
									?>
									</small></p>
							<?php
								}
							?>
							<div class="snippet">
								<?php if ($post->post_content !== '') { the_excerpt(); } ?>
							</div>
						</li>
					<?php endwhile;?>
					</ul>
				<?php else:?>		
					<p>No results found for "<?=htmlentities($_GET['s'])?>".</p>
				<?php endif;?>
			</article>
		</div>
	</div>

<?php } else { ?>

<?php 
	$args = array(
		'post_type'    => array('resourcelink','post','page'),
		's'			   => htmlentities($_GET['s']),
		'numberposts'  => '-1',
	);
	$posts = get_posts($args);
?>
	<div class="row page-content" id="search-results">
		<div class="span12" id="page-top">
			<h1>Search Results for &ldquo;<?=htmlentities($_GET['s'])?>&rdquo;</h1>
		</div>
		<div class="span12">
			<article>
				<?php if($posts):?>
					<ul class="result-list">
					<?php 
					foreach ($posts as $post) {
						// Determine if the post is a resource link that links
						// to a page/page anchor (is a duplicate of an already-
						// retrieved post.)
						$not_duplicate = false;
						
						if ($post->post_type !== 'resourcelink') {
							$not_duplicate = true;
						}
						else {
							if ($post->post_type == 'resourcelink' && get_post_meta($post->ID, 'resourcelink_is_doc', TRUE) == 'on') {
								$not_duplicate = true;
							}
						}
						
						if ($not_duplicate == true) {
						?>
						<li class="item">
							<h3>
								<a 
								<?php if ($post->post_type == 'resourcelink') { ?>
									class="<?=ResourceLink::get_document_application($post)?>" href="<?=ResourceLink::get_url($post)?>">
								<?php 
								} else {
								?>
									href="<?=the_permalink()?>">
								<?php } ?>
									<?=the_title()?>
								</a>
							</h3>
							<?php
								$ancestors = get_post_ancestors($post->ID);
								if ($ancestors) { ?>
									<p class="result-breadcrumbs"><small>under
									<?php
									krsort($ancestors);
									foreach ($ancestors as $ancestor) {
										print '<a href="'.get_permalink($ancestor).'">'.get_post($ancestor)->post_title.'</a>';
										if ($ancestor !== end($ancestors)) {
											print ' &raquo; ';
										}
									}
									?>
									</small></p>
							<?php
								}
							?>
							<div class="snippet">
								<?php if ($post->post_content !== '') { 
										// Strip out shortcode and html content
										$filtered_content = strip_tags(strip_shortcodes(($post->post_content)));
										// Cut the post content length down to excerpt length and print it
										$excerpt_length = 500;
										$excerpt = substr($filtered_content, 0, $excerpt_length);
										if ($excerpt) {
											print $excerpt.'...';
										}
									} 
								?>
							</div>
						</li>
						<?php } ?>
					<?php } ?>
					</ul>
				<?php else:?>		
					<p>No results found for "<?=htmlentities($_GET['s'])?>".</p>
				<?php endif;?>
			</article>
		</div>
	</div>
	
<?php } ?>
<?php get_footer();?>