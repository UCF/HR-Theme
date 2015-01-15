<?php


/**
 * Create a javascript slideshow of each top level element in the
 * shortcode.  All attributes are optional, but may default to less than ideal
 * values.  Available attributes:
 * 
 * height     => css height of the outputted slideshow, ex. height="100px"
 * width      => css width of the outputted slideshow, ex. width="100%"
 * transition => length of transition in milliseconds, ex. transition="1000"
 * cycle      => length of each cycle in milliseconds, ex cycle="5000"
 * animation  => The animation type, one of: 'slide' or 'fade'
 *
 * Example:
 * [slideshow height="500px" transition="500" cycle="2000"]
 * <img src="http://some.image.com" .../>
 * <div class="robots">Robots are coming!</div>
 * <p>I'm a slide!</p>
 * [/slideshow]
 **/
function sc_slideshow($attr, $content=null){
	$content = cleanup(str_replace('<br />', '', $content));
	$content = DOMDocument::loadHTML($content);
	$html    = $content->childNodes->item(1);
	$body    = $html->childNodes->item(0);
	$content = $body->childNodes;
	
	# Find top level elements and add appropriate class
	$items = array();
	foreach($content as $item){
		if ($item->nodeName != '#text'){
			$classes   = explode(' ', $item->getAttribute('class'));
			$classes[] = 'slide';
			$item->setAttribute('class', implode(' ', $classes));
			$items[] = $item->ownerDocument->saveXML($item);
		}
	}
	
	$animation = ($attr['animation']) ? $attr['animation'] : 'slide';
	$height    = ($attr['height']) ? $attr['height'] : '100px';
	$width     = ($attr['width']) ? $attr['width'] : '100%';
	$tran_len  = ($attr['transition']) ? $attr['transition'] : 1000;
	$cycle_len = ($attr['cycle']) ? $attr['cycle'] : 5000;
	
	ob_start();
	?>
	<div 
		class="slideshow <?=$animation?>"
		data-tranlen="<?=$tran_len?>"
		data-cyclelen="<?=$cycle_len?>"
		style="height: <?=$height?>; width: <?=$width?>;"
	>
		<?php foreach($items as $item):?>
		<?=$item?>
		<?php endforeach;?>
	</div>
	<?php
	$html = ob_get_clean();
	
	return $html;
}
add_shortcode('slideshow', 'sc_slideshow');


function sc_search_form() {
	ob_start();
	?>
	<div class="search">
		<?get_search_form()?>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('search_form', 'sc_search_form');


function sc_person_picture_list($atts) {
	$atts['type']	= ($atts['type']) ? $atts['type'] : null;
	$row_size 		= ($atts['row_size']) ? (intval($atts['row_size'])) : 5;
	$categories		= ($atts['categories']) ? $atts['categories'] : null;
	$org_groups		= ($atts['org_groups']) ? $atts['org_groups'] : null;
	$limit			= ($atts['limit']) ? (intval($atts['limit'])) : -1;
	$join			= ($atts['join']) ? $atts['join'] : 'or';
	$people 		= sc_object_list(
						array(
							'type' => 'person', 
							'limit' => $limit,
							'join' => $join,
							'categories' => $categories, 
							'org_groups' => $org_groups
						), 
						array(
							'objects_only' => True,
						));
	
	ob_start();
	
	?><div class="person-picture-list"><?
	$count = 0;
	foreach($people as $person) {
		
		$image_url = get_featured_image_url($person->ID);
		
		$link = ($person->post_content != '') ? True : False;
		if( ($count % $row_size) == 0) {
			if($count > 0) {
				?></div><?
			}
			?><div class="row"><?
		}
		
		?>
		<div class="span2 person-picture-wrap">
			<? if($link) {?><a href="<?=get_permalink($person->ID)?>"><? } ?>
				<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
				<div class="name"><?=Person::get_name($person)?></div>
				<div class="title"><?=get_post_meta($person->ID, 'person_jobtitle', True)?></div>
				<? if($link) {?></a><?}?>
		</div>
		<?
		$count++;
	}
	?>	</div>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('person-picture-list', 'sc_person_picture_list');


/**
 * Output site contact info in a styled box.
 **/
function sc_contact_info() { 
	$options = get_option(THEME_OPTIONS_NAME);
	ob_start(); ?>
	<div class="contact-wrap">
		<p class="contact-info">
			<span class="contact-header">Our Contact:</span>
			<?php if($options['organization_name']) { print '<strong>'.$options['organization_name'].'</strong><br/>'; } ?>
			<?php if($options['organization_addr_str']) { print $options['organization_addr_str'].'<br/>'; } ?>
			<?php if($options['organization_addr_str_2']) { print $options['organization_addr_str_2'].'<br/>'; } ?>
			<?php if($options['organization_addr_csz']) { print $options['organization_addr_csz'].'<br/>'; } ?>
			<?php if($options['organization_phone']) { 
				print '<span class="contact-phone"><strong>Phone: </strong>'.$options['organization_phone'].'</span><br/>'; } ?>
			<?php if($options['organization_fax']) { 
				print '<span class="contact-fax"><strong>Fax: </strong>'.$options['organization_fax'].'</span><br/>'; } ?>
		</p>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('site-contact-info', 'sc_contact_info');


/**
 * Output site contact email in a consistent stylized format.
 **/
function sc_contact_email() {
	$options = get_option(THEME_OPTIONS_NAME);
	ob_start();
	
	if($options['site_contact']) { 
		print '<p class="contact-email">Questions? Email us: <a href="mailto:'.$options['site_contact'].'">'.$options['site_contact'].'</a></p>'; 
	}
	else { print 'No site contact email provided.'; }
	
	return ob_get_clean(); 
}
add_shortcode('site-contact-email', 'sc_contact_email');


/**
 * Output a Content Block by its post title.
 **/
function sc_content_block($atts) {
	$post_name = $atts['name'] ? $atts['name'] : '';
	if ($post_name !== '') {
		$post = get_page_by_title($post_name, 'OBJECT', 'contentblock');
	}
	ob_start();
	
	print apply_filters('the_content', $post->post_content);
	
	return ob_get_clean(); 
}
add_shortcode('content-block', 'sc_content_block');


/**
 * Post search
 *
 * @return string
 * @author Chris Conover
 **/
function sc_post_type_search($params=array(), $content='') {
	$defaults = array(
		'post_type_name'         => 'post',
		'taxonomy'               => 'category',
		'taxonomy_term'			 => '',
		'meta_key'				 => '',
		'meta_value'			 => '',
		'show_empty_sections'    => false,
		'non_alpha_section_name' => 'Other',
		'column_width'           => 'span4',
		'column_count'           => '3',
		'order_by'               => 'title',
		'order'                  => 'ASC',
		'show_sorting'           => true,
		'default_sorting'        => 'term',
		'use_search'             => true, # if false, get posts using this function's filtering options, but disable search ability
		'show_uncategorized'	 => false,
		'uncategorized_term_name'=> ''
	);

	$params = ($params === '') ? $defaults : array_merge($defaults, $params);

	$params['show_empty_sections'] = filter_var($params['show_empty_sections'], FILTER_VALIDATE_BOOLEAN);
	$params['column_count']        = is_numeric($params['column_count']) ? (int)$params['column_count'] : $defaults['column_count'];
	$params['show_sorting']        = filter_var($params['show_sorting'], FILTER_VALIDATE_BOOLEAN);
	$params['use_search']          = filter_var($params['use_search'], FILTER_VALIDATE_BOOLEAN);
	
	if(!in_array($params['default_sorting'], array('term', 'alpha'))) {
		$params['default_sorting'] = $default['default_sorting'];
	}
	
	// Resolve the post type class
	if(is_null($post_type_class = get_custom_post_type($params['post_type_name']))) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;

	// Set default search text if the user didn't
	if(!isset($params['default_search_text'])) {
		$params['default_search_text'] = 'Find a '.$post_type->singular_name;
	}
	
	// Set default search field label if the user didn't
	if(!isset($params['default_search_label'])) {
		$params['default_search_label'] = 'Find a '.$post_type->singular_name;
	}

	// Register if the search data with the JS PostTypeSearchDataManager
	// Format is array(post->ID=>terms) where terms include the post title
	// as well as all associated tag names
	if ($params['use_search']) {
		$search_data = array();
		foreach(get_posts(array('numberposts' => -1, 'post_type' => $params['post_type_name'])) as $post) {
			$search_data[$post->ID] = array($post->post_title);
			foreach(wp_get_object_terms($post->ID, 'post_tag') as $term) {
				$search_data[$post->ID][] = $term->name;
			}
		}
		?>
		<script type="text/javascript">
			if(typeof PostTypeSearchDataManager != 'undefined') {
				PostTypeSearchDataManager.register(new PostTypeSearchData(
					<?=json_encode($params['column_count'])?>,
					<?=json_encode($params['column_width'])?>,
					<?=json_encode($search_data)?>
				));
			}
		</script>
		<?
	}

	// Set up a post query
	$by_term = array();
	
	$args = array(
		'numberposts' => -1,
		'post_type'   => $params['post_type_name'],
		'tax_query'   => array(
			array(
				'taxonomy' => $params['taxonomy'],
				'field'    => 'id',
				'terms'    => '',
			)
		),
		'orderby'     => $params['order_by'],
		'order'       => $params['order'],
	);
	
	// Handle meta key and value query
	if ($params['meta_key'] && $params['meta_value']) {
		$args['meta_key'] = $params['meta_key'];
		$args['meta_value'] = $params['meta_value'];
	}
	
	// Split up this post type's posts by term
	if ($params['taxonomy_term'] !== '') {
		// if a specific taxonomy term is specified, get just its children
		$termchildren = get_term_children(get_term_by('slug', $params['taxonomy_term'], $params['taxonomy'])->term_id, $params['taxonomy']);
		
		$termchildren_byname = array();
		$termchildren_sorted = array();
		
		// Create new array that contains term ID and Name data per term
		foreach ($termchildren as $termid) {
			$term = get_term_by('id', $termid, $params['taxonomy']);
			$termchildren_byname[$term->slug] .= $termid;
		}
		
		// Sort the $sorted_termchildren results by Name
		ksort($termchildren_byname);			
		
		// Replace $termchildren with the newly sorted results
		foreach ($termchildren_byname as $termname => $termid) {
			$termchildren_sorted[] .= $termid;
		}
		$termchildren = $termchildren_sorted;
		
		
		foreach ($termchildren as $term) {
			$args['tax_query'][0]['terms'] = $term;
			$posts = get_posts($args);
			
			if(count($posts) == 0 && $params['show_empty_sections']) {
				$by_term[get_term_by('id', $term, $params['taxonomy'])->name] = array();
			} else {
				$by_term[get_term_by('id', $term, $params['taxonomy'])->name] = $posts;
			}
		}
	}
	// If no taxonomy_term is specified, grab all taxonomy terms
	// for the given taxonomy
	else {
		foreach(get_terms($params['taxonomy']) as $term) { // get_terms defaults to an orderby=name, order=asc value
			$args['tax_query'][0]['terms'] = $term->term_id;
			$posts = get_posts($args);
	
			if(count($posts) == 0 && $params['show_empty_sections']) {
				$by_term[$term->name] = array();
			} else {
				$by_term[$term->name] = $posts;
			}
		}

		// Add uncategorized items if parameter is set.
		if ($params['show_uncategorized']) {
			$terms = get_terms($params['taxonomy'], array('fields' => 'ids', 'hide_empty' => false));
			$args['tax_query'][0]['terms'] = $terms;
			$args['tax_query'][0]['operator'] = 'NOT IN';
			$uncat_posts = get_posts($args);
			if (count($uncat_posts == 0) && $params['show_empty_sections']) {
				$by_term[$params['uncategorized_term_name']] = array();
			} else {
				$by_term[$params['uncategorized_term_name']] = $uncat_posts;
			}
		}
	}

	// Split up this post type's posts by the first alpha character
	// (Do not fetch alphabetical results when use_search is set to false)
	$by_alpha = array();
	if ($params['use_search']) {
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		$args['tax_query'] = '';
		$by_alpha_posts = get_posts($args);
		foreach($by_alpha_posts as $post) {
			if(preg_match('/([a-zA-Z])/', $post->post_title, $matches) == 1) {
				$by_alpha[strtoupper($matches[1])][] = $post;
			} else {
				$by_alpha[$params['non_alpha_section_name']][] = $post;
			}
		}
		ksort($by_alpha);

		if($params['show_empty_sections']) {
			foreach(range('a', 'z') as $letter) {
				if(!isset($by_alpha[strtoupper($letter)])) {
					$by_alpha[strtoupper($letter)] = array();
				}
			}
		}
	}

	$sections = array(
		'post-type-search-term'  => $by_term,
		'post-type-search-alpha' => $by_alpha,
	);

	ob_start();
	?>
	<div class="post-type-search">
		<? if ($params['use_search']) { ?>
		<div class="post-type-search-header">
			<form class="post-type-search-form" action="." method="get">
				<label><?=$params['default_search_label']?></label>
				<input type="text" class="span3" placeholder="<?=$params['default_search_text']?>" />
			</form>
		</div>
		<div class="post-type-search-results "></div>
		<? } ?>
		<? if($params['show_sorting']) { ?>
		<span class="search-toggle-text">Sort By: </span>
		<div class="btn-group post-type-search-sorting">
			<button class="btn<?if($params['default_sorting'] == 'term') echo ' active';?>"><i class="icon-list-alt"></i> <span class="search-toggle-text">Category</span></button>
			<button class="btn<?if($params['default_sorting'] == 'alpha') echo ' active';?>"><i class="icon-font"></i> <span class="search-toggle-text">Alphabetical</span></button>
		</div>
		<? } ?>
	<?

	foreach($sections as $id => $section) {
		$hide = false;
		switch($id) {
			case 'post-type-search-alpha':
				if($params['default_sorting'] == 'term') {
					$hide = True;
				}
				break;
			case 'post-type-search-term':
				if($params['default_sorting'] == 'alpha') {
					$hide = True;
				}
				break;
		}
		// When use_search is false, hide empty sections
		if (!$params['use_search'] && empty($section)) {
			$hide = True;
		}
		?>
		<div class="<?=$id?>"<? if($hide) echo ' style="display:none;"'; ?>>
			<div class="row">
			<? $count = 0; ?>
			<? foreach($section as $section_title => $section_posts) { ?>
				<? if ($section_posts) { ?>
					<? 	if ($count % $params['column_count'] == 0 && $count !== 0) {
						print '</div><div class="row">';
					} ?>
					<div class="<?=$params['column_width']?>">
						<h3><?=esc_html($section_title)?></h3>
						<ul>
						<? foreach(array_slice($section_posts, $start, $end) as $post) { ?>
							<li data-post-id="<?=$post->ID?>" <?=($post_type->get_document_application($post)) ? 'class="'.$post_type->get_document_application($post).'"' : ''?>><?=$post_type->toHTML($post)?><span class="search-post-pgsection"><?=$section_title?></span></li>
						<? } ?>
						</ul>
					</div>
				<? $count++; 
				} // endif ?>
			<? } // endforeach ?>
			</div>
		</div>
	<? } ?>
	</div> <?
	return ob_get_clean();
}
add_shortcode('post-type-search', 'sc_post_type_search');
?>