<?php $options = get_option(THEME_OPTIONS_NAME);?>
<div class="row">
	<div id="below-the-fold" class="row-border-bottom-top">
		<div class="span5">
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Top')):?>
				<h2 class="hr-news-header">This Just In</h2>
				<?php
					$args = array(
						'numberposts' => 2,
					);
					$posts = get_posts($args);
					foreach ($posts as $post) {
						print '<h3><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h3>';
						print '<p>'.$post->post_content.'</p>';
					}
				?>
			<?php endif;?>
		</div>
		<div class="span4">
			<?php if($options['enable_events']):?>
				<?php display_events('h2')?>
			<?php else:?>&nbsp;
				<?php debug("Events feed is disabled.")?>
			<?php endif;?>
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Center')):?><?php endif;?>
		</div>
		<div class="span3">
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Right')):?>
				<div class="footer-contact-wrap">
					<p class="footer-contact">
						Our Contact:<br/>
						<?php if($options['organization_name']) { print '<strong>'.$options['organization_name'].'</strong><br/>'; } ?>
						<?php if($options['organization_addr_str']) { print $options['organization_addr_str'].'<br/>'; } ?>
						<?php if($options['organization_addr_str_2']) { print $options['organization_addr_str_2'].'<br/>'; } ?>
						<?php if($options['organization_addr_csz']) { print $options['organization_addr_csz'].'<br/>'; } ?>
						<?php if($options['organization_phone']) { 
							print '<span class="footer-contact-phone"><strong>Phone: </strong>'.$options['organization_phone'].'</span><br/>'; } ?>
						<?php if($options['organization_fax']) { 
							print '<span class="footer-contact-fax"><strong>Fax: </strong>'.$options['organization_fax'].'</span><br/>'; } ?>
					</p>
				</div>
				<p class="footer-email">Questions? Email us: <a href="mailto:askhr@ucf.edu">AskHR@ucf.edu</a></p>
			<?php endif;?>
		</div>
	</div>
</div>