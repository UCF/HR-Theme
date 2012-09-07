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
						<strong>UCF Human Resources</strong><br/>
						3280 Progress Drive<br/>
						Suite 100<br/>
						Orlando, FL 32826<br/>
						<strong>Phone: </strong>(407) 823-2771<br/>
						<strong>Fax: </strong>(407) 823-1095<br/>
					</p>
				</div>
				<p class="footer-email">Questions? Email us: <a href="mailto:askhr@ucf.edu">AskHR@ucf.edu</a></p>
				Right column will go here...
			<?php endif;?>
		</div>
	</div>
</div>