<?php $options = get_option(THEME_OPTIONS_NAME);?>
<?php if ($options['enable_google'] or $options['enable_google'] === null):?>
<?php
	$domain  = $options['search_domain'];
	$limit   = (int)$options['search_per_page'];
	$start   = (is_numeric($_GET['start'])) ? (int)$_GET['start'] : 0;
	$results = get_search_results($_GET['s'], $start, $limit, $domain);
?>
<?php get_header(); ?>
	<div class="row page-content" id="search-results">
		<div class="span12" id="page-top">
			<h1>Search Results for "<?=htmlentities($_GET['s'])?>"</h1>
		</div>
		<div class="span12">
			<article>
				<?php if(count($results['items'])):?>
				<ul class="result-list">
					<?php foreach($results['items'] as $result):?>
					<li class="item">
						<h3>
							<a class="<?=mimetype_to_application(($result['mime']) ? $result['mime'] : 'text/html')?>" href="<?=$result['url']?>">
								<?php if($result['title']):?>
								<?=$result['title']?>
								<?php else:?>
								<?=substr($result['url'], 0, 45)?>...
								<?php endif;?>
							</a>
						</h3>
						<a href="<?=$result['url']?>" class="ignore-external url sans"><?=$result['url']?></a>
						<div class="snippet">
							<?=str_replace('<br>', '', $result['snippet'])?>
						</div>
					</li>
				<?php endforeach;?>
				</ul>
			
				<?php if($start + $limit < $results['number']):?>
				<a class="button more" href="./?s=<?=$_GET['s']?>&amp;start=<?=$start + $limit?>">More Results</a>
				<?php endif;?>
				
				<?php else:?>
					
				<p>No results found for "<?=htmlentities($_GET['s'])?>".</p>
				
				<?php endif;?>
			</article>
		</div>
	</div>
<?php get_footer();?>

<?php else:?>
<?php get_header(); the_post();?>	
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
								<a <?php if ($post->post_type == 'resourcelink') { print 'class="'.ResourceLink::get_document_application($post).'"'; } ?> href="<?php the_permalink();?>">
									<?php the_title();?>
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
<?php get_footer();?>
<?php endif;?>