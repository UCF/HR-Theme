<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page-top">
			<?=get_breadcrumbs($post->ID)?>
			
			<? if(!is_front_page())	{ ?>
				<h1><?php the_title();?></h1>
			<? } ?>
			
			<?php if (get_post_meta($post->ID, 'page_subheader', TRUE)) {
				print get_post_meta($post->ID, 'page_subheader', TRUE);
			}
			?>
		</div>
		<div id="sidebar" class="span3">
			<?=get_sidebar();?>
		</div>
		<div class="span9">
			<article>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>