<?php disallow_direct_load('sidebar.php');?>

<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar')):?>

<?php $taxonomy_term = get_post_meta($post->ID, 'page_taxonomy_term', TRUE) ? get_post_meta($post->ID, 'page_taxonomy_term', TRUE) : $post->post_name; ?>
	
	<?=do_shortcode('[post-type-search post_type_name="resourcelink" taxonomy="pg_sections" taxonomy_term="'.$taxonomy_term.'" column_width="span3" column_count="1" use_search="false"]')?>
	
	&nbsp;
	<a class="faq-link" href="<?=get_site_url()?>/current-employees/benefits-faqs/">Benefits and Retirement FAQs</a>
			
	&nbsp;
	<?=do_shortcode('[site-contact-email]')?>
			
	&nbsp;
	<?=do_shortcode('[site-contact-info]')?>

<?php endif;?>