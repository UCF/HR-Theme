<?php $options = get_option(THEME_OPTIONS_NAME);?>
			<div id="footer">
				<?=wp_nav_menu(array(
					'theme_location' => 'footer-menu', 
					'container' => 'false', 
					'menu_class' => 'menu horizontal', 
					'menu_id' => 'footer-menu', 
					'fallback_cb' => false,
					'depth' => 1,
					'walker' => new Bootstrap_Walker_Nav_Menu()
					));
				?>
				<div class="row" id="footer-widget-wrap">
					<div class="footer-widget-1 span6">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column One')):?>
							<a class="ignore-external" href="http://www.ucf.edu"><img id="footer-logo" src="<?=THEME_IMG_URL?>/logo.png" alt="" title="" /></a>
							
							<div class="footer-contact">
								<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Two')):?>
								<?php if($options['organization_name']) { print '<strong>'.$options['organization_name'].'</strong><br/>'; } ?>
								<?php if($options['organization_addr_str']) { print $options['organization_addr_str'].'<br/>'; } ?>
								<?php if($options['organization_addr_str_2']) { print $options['organization_addr_str_2'].'<br/>'; } ?>
								<?php if($options['organization_addr_csz']) { print $options['organization_addr_csz'].'<br/>'; } ?>
								<?php if($options['organization_phone']) { 
									print $options['organization_phone'].'<br/>'; } ?>
								<?php endif;?>
							</div>
							
						<?php endif;?>
					</div>
					<div class="footer-widget-2 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Three')):?>
						&nbsp;
						<?php endif;?>
					</div>
					<div class="footer-widget-3 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Four')):?>
							<?php if($options['site_contact'] or $options['organization_name']):?>
								<div class="maintained">
									Site maintained by the <br />
									<?php if($options['site_contact'] and $options['organization_name']):?>
									<a href="mailto:<?=$options['site_contact']?>"><?=$options['organization_name']?></a>
									<?php elseif($options['site_contact']):?>
									<a href="mailto:<?=$options['site_contact']?>"><?=$options['site_contact']?></a>
									<?php elseif($options['organization_name']):?>
									<?=$options['organization_name']?>
									<?php endif;?>
								</div>
								<?php endif;?>
								<br/>
								&copy; University of Central Florida
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</body>
	<?="\n".footer_()."\n"?>
</html>