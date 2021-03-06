<?php

/**
 *	Functions.php
 *
 *	A number of functions necessary for the theme
 */

add_theme_support( 'post-thumbnails' );

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');

function first_paragraph($content){
	return preg_replace('/<p([^>]+)?>/', '<p$1 class="lead">', $content, 1);
}
add_filter('the_content', 'first_paragraph');

add_filter('the_content', 'ug_content_formatting');
function ug_content_formatting($content){
	$content = str_replace('<p>&nbsp;</p>', '', $content);
	$content = str_replace('style="color: #ff0066;"', 'class="ug-color"', $content);
	$content = str_replace('<h2 style="text-align: center;"><span class="ug-color">', '<h2><span>', $content);
	$content = str_replace('<span style="color: #505053;">', '<span>', $content);
	$content = str_replace('style="text-align: center;"', '', $content);
	$content = str_replace('<h2><span><strong>', '<h2>', $content);
	$content = str_replace('</strong></span></h2>', '</h2>', $content);
	$content = str_replace('style="text-decoration: underline;"', 'style="font-style: italic;"', $content);

	if (is_single() && get_the_time('U') < strtotime("October 15th, 2013") ) {

		$dom = new DOMDocument();
		$content = mb_convert_encoding($content, 'utf-8', mb_detect_encoding($content));
		$content = mb_convert_encoding($content, 'html-entities', 'utf-8');
		@$dom->loadHTML( $content );

		$images = $dom->getElementsByTagName('img');

		foreach ($images as $image) {
			// the existing classes already on the images
			$existing_classes = $image->getAttribute('class');

			// the existing classes plus the new class
			$new_classes = $existing_classes . ' ug-old-img';

			$image->setAttribute('class', $new_classes);
		}

		$content = $dom->saveHTML();

	}

	return $content;
}

function displayBackupImage($urlOnly = false) {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = ($matches[1][0]) ? $matches[1][0] : get_template_directory_uri().'/images/article-urbangirl.png';

	if (!$urlOnly) {
		echo '<img src="'.$first_img.'" alt="">';
	} else {
		return $first_img;
	}
}

/**
 *  Load different template for sub category
 */
function sub_category_template() {

	// Get the category id from global query variables
	$cat = get_query_var('cat');

	if(!empty($cat)) {

		// Get the detailed category object
		$category = get_category($cat);

		// Check if it is sub-category and having a parent, also check if the template file exists
		if( ($category->parent != '0') && (file_exists(TEMPLATEPATH . '/sub-category.php')) ) {

			// Include the template for sub-catgeory
			include(TEMPLATEPATH . '/sub-category.php');
			exit;
		}
		return;
	}
	return;

}
add_action('template_redirect', 'sub_category_template');

function is_subcategory (){
	$cat = get_query_var('cat');
	$category = get_category($cat);
	return ( $category->parent == '0' ) ? false : true;
}

function category_has_children() {
global $wpdb;
$term = get_queried_object();
$category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
	if ($category_children_check) {
		return true;
	} else {
	   return false;
	}
}

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['my_ug'] = 'Mes préférences';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

function queryToArray($qry) {
	$result = array();
	//string must contain at least one = and cannot be in first position
	if(strpos($qry,'=')) {

	 if(strpos($qry,'?')!==false) {
	   $q = parse_url($qry);
	   $qry = $q['query'];
	  }
	}else {
		return false;
	}

	foreach (explode('&', $qry) as $couple) {
		list ($key, $val) = explode('=', $couple);
		$result[$key] = $val;
	}

	return empty($result) ? false : $result;
}

/**
 * BreadCrumbs
 * Author : Daniel Roch
 */
  // Get parent categories with schema.org data
  function seomix_content_get_category_parents($id, $link = false,$separator = '/',$nicename = false,$visited = array()) {
  $final = '';
  $parent = &get_category($id);
  if (is_wp_error($parent))
	return $parent;
  if ($nicename)
	$name = $parent->name;
  else
	$name = $parent->cat_name;
  if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
	$visited[] = $parent->parent;
	$final .= seomix_content_get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
  }
  if ($link)
	$final .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link( $parent->term_id ) . '" title="Voir tous les articles de '.$parent->cat_name.'" rel="v:url" property="v:title">'.$name.'</a></span>' . $separator;
  else
	$final .= $name.$separator;
  if ($id != 4029) {
  	return $final;
  } else {
  	return '';
  }
}

  // Breadcrumb
  function seomix_content_breadcrumb() {
  // Global vars
  global $wp_query;
  $paged = get_query_var('paged');
  $sep = ' &raquo; ';
  $data = '<span typeof="v:Breadcrumb">';
  $dataend = '</span>';
  $final = '<div xmlns:v="http://rdf.data-vocabulary.org/#">Vous &ecirc;tes ici : ';
  $startdefault = $data.'<a title="'. get_bloginfo('name') .'" href="'.home_url().'" rel="v:url" property="v:title">'. get_bloginfo('name') .'</a>'.$dataend;
  $starthome = 'Accueil de '. get_bloginfo('name');

  // Breadcrumb start
  if ( is_front_page() && is_home() ){
	// Default homepage
	if ( $paged >= 1 )
	  $final .= $startdefault;
	else
	  $final .= $starthome;
  } elseif ( is_front_page() ){
	//Static homepage
	$final .= $starthome;
  } elseif ( is_home() ){
	//Blog page
	if ( $paged >= 1 ) {
	  $url = get_page_link(get_option('page_for_posts'));
	  $final .= $startdefault.$sep.$data.'<a href="'.$url.'" rel="v:url" property="v:title" title="Les articles">Les articles</a>'.$dataend;}
	else
	  $final .= $startdefault.$sep.'Les articles';
  } else {
	//everyting else
	$final .= $startdefault.$sep;}

  // Prevent other code to interfer with static front page et blog page
  if ( is_front_page() && is_home() ){// Default homepage
  } elseif ( is_front_page()){//Static homepage
  } elseif ( is_home()){//Blog page
  }
  //Attachment
  elseif ( is_attachment()){
	global $post;
	$parent = get_post($post->post_parent);
	$id = $parent->ID;
	$category = get_the_category($id);
	$category_id = get_cat_ID( $category[0]->cat_name );
	$permalink = get_permalink( $id );
	$title = $parent->post_title;
	$final .= seomix_content_get_category_parents($category_id,TRUE,$sep).$data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend.$sep.the_title('','',FALSE);}
  // Post type
  elseif ( is_single() && !is_singular('post')){
	 global $post;
	 $nom = get_post_type($post);
	 $archive = get_post_type_archive_link($nom);
	 $mypost = $post->post_title;
	 $final .= $data.'<a href="'.$archive.'" rel="v:url" property="v:title" title="'.$nom.'">'.$nom.'</a>'.$dataend.$sep.$mypost;}
  //post
  elseif ( is_single()){
	// Post categories
	$category = get_the_category();
	$category_id = get_cat_ID( $category[0]->cat_name );
	if ($category_id != 0)
	  $final .= seomix_content_get_category_parents($category_id,TRUE,$sep);
	elseif ($category_id == 0) {
	  $post_type = get_post_type();
	  $tata = get_post_type_object( $post_type );
	  $titrearchive = $tata->labels->menu_name;
	  $urlarchive = get_post_type_archive_link( $post_type );
	  $final .= $data.'<a class="breadl" href="'.$urlarchive.'" title="'.$titrearchive.'" rel="v:url" property="v:title">'.$titrearchive.'</a>'.$dataend;}
	// With Comments pages
	$cpage = get_query_var( 'cpage' );
	if (is_single() && $cpage > 0) {
	  global $post;
	  $permalink = get_permalink( $post->ID );
	  $title = $post->post_title;
	  $final .= $data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend;
	  $final .= $sep."Commentaires page $cpage";}
	// Without Comments pages
	else
	  $final .= the_title('','',FALSE);}
  // Categories
  elseif ( is_category() ) {
	// Vars
	$categoryid       = $GLOBALS['cat'];
	$category         = get_category($categoryid);
	$categoryparent   = get_category($category->parent);
	//Render
	if ($category->parent != 0)
	  $final .= seomix_content_get_category_parents($categoryparent, true, $sep, true);
	if ( $paged <= 1 )
	  $final .= single_cat_title("", false);
	else
	  $final .= $data.'<a href="' . get_category_link( $category ) . '" title="Voir tous les articles de '.single_cat_title("", false).'" rel="v:url" property="v:title">'.single_cat_title("", false).'</a>'.$dataend;}
  // Page
  elseif ( is_page() && !is_home() ) {
	$post = $wp_query->get_queried_object();
	// Simple page
	if ( $post->post_parent == 0 )
	  $final .= $post->post_title;
	// Page with ancestors
	elseif ( $post->post_parent != 0 ) {
	  $title = the_title('','',FALSE);
	  $ancestors = array_reverse(get_post_ancestors($post->ID));
	  array_push($ancestors, $post->ID);
	  $count = count ($ancestors);$i=0;
	  foreach ( $ancestors as $ancestor ){
		if( $ancestor != end($ancestors) ){
		  $name = strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) );
		  $final .= $data.'<a title="'.$name.'" href="'. get_permalink($ancestor) .'" rel="v:url" property="v:title">'.$name.'</a>'.$dataend;
		  $i++;
		  if ($i < $ancestors)
			$final .= $sep;
		}
		else
		  $final .= strip_tags(apply_filters('single_post_title',get_the_title($ancestor)));
		}}}
  // authors
  elseif ( is_author() ) {
	if(get_query_var('author_name'))
		$curauth = get_user_by('slug', get_query_var('author_name'));
	else
		$curauth = get_userdata(get_query_var('author'));
	$final .= "Articles de l'auteur ".$curauth->nickname;}
  // tags
  elseif ( is_tag() ){
	$final .= "Articles sur le th&egrave;me ".single_tag_title("",FALSE);}
  // Search
  elseif ( is_search() ) {
	$final .= "R&eacute;sultats de votre recherche sur \"".get_search_query()."\"";}
  // Dates
  elseif ( is_date() ) {
	if ( is_day() ) {
	  $year = get_year_link('');
	  $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
	  $month = get_month_link( get_query_var('year'), get_query_var('monthnum') );
	  $final .= $sep.$data.'<a title="'.single_month_title(' ',false).'" href="'.$month.'" rel="v:url" property="v:title">'.single_month_title(' ',false).'</a>'.$dataend;
	  $final .= $sep."Archives pour ".get_the_date();}
	elseif ( is_month() ) {
	  $year = get_year_link('');
	  $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
	  $final .= $sep."Archives pour ".single_month_title(' ',false);}
	elseif ( is_year() )
	  $final .= "Archives pour ".get_query_var('year');}
  // 404 page
  elseif ( is_404())
	$final .= "404 Page non trouv&eacute;e";
  // Other Archives
  elseif ( is_archive() ){
	$posttype = get_post_type();
	$posttypeobject = get_post_type_object( $posttype );
	$taxonomie = get_taxonomy( get_query_var( 'taxonomy' ) );
	$titrearchive = $posttypeobject->labels->menu_name;
	if (!empty($taxonomie))
	  $final .= $taxonomie->labels->name;
	else
	  $final .= $titrearchive;}
  // Pagination
  if ( $paged >= 1 )
	$final .= $sep.'Page '.$paged;
  // The End
  $final .= '</div>';
  echo $final;
}

add_filter( 'avatar_defaults', 'newgravatar' );
function newgravatar ($avatar_defaults) {
	$myavatar = get_bloginfo('template_directory') . '/images/default-avatar.jpg';
	$avatar_defaults[$myavatar] = "Own";
	return $avatar_defaults;
}

function gplus_count() {
	$count = false;
	if ($count !== false) return $count;
	$count = 'pas de fans';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"http://urbangirl.fr","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$json = json_decode($curl_results, true);

    $count = intval( $json[0]['result']['metadata']['globalCounts']['count'] );

    set_transient('gplus_count', $count, 60*60*48); // 72 hour cache
    return $count+29;

}

function fb_count() {
	$json = json_decode(file_get_contents('http://graph.facebook.com/UrbanGirlFr'));

	$count = get_transient('fb_count');

	if ($count !== false) return $count;

	$count = 0;

	set_transient('fb_count', $json->likes, 60*60*24); // 24 hour cache

	return $json->likes;
}

function twitter_count($screenName = 'urbangirlco') {
    require_once('TwitterAPIExchange.php');
    // this variables can be obtained in http://dev.twitter.com/apps
    // to create the app, follow former tutorial on http://www.codeforest.net/get-twitter-follower-count
    $settings = array(
        'oauth_access_token' => "41140106-6OyqA7DZDhc5uwonYw5TmbPKEFq3enjqFMAh8OzW7",
        'oauth_access_token_secret' => "Yg7qLoi5WkD5uuvJ3fucxCCoGfd5OBcfMFcsegE1H0",
        'consumer_key' => "WNZyKqjUhHPNH60r2savgQ",
        'consumer_secret' => "JJpKOwl1DuBSHJdoDtbnxM8MkM8lqbYw5geOusY54KY"
    );

    $numberOfFollowers = false;

    // cache version does not exist or expired
    if (false === $numberOfFollowers) {
        // forming data for request
        $apiUrl = "https://api.twitter.com/1.1/users/show.json";
        $requestMethod = 'GET';
        $getField = '?screen_name=' . $screenName;

        $twitter = new TwitterAPIExchange($settings);
        $response = $twitter->setGetfield($getField)
             ->buildOauth($apiUrl, $requestMethod)
             ->performRequest();

        $followers = json_decode($response);
        $numberOfFollowers = $followers->followers_count;

        // cache for a day
        set_transient('twitter_count', $json->likes, 60*60*24); // 24 hour cache
    }

    return $numberOfFollowers;
}

// add_action( 'phpmailer_init', 'wpse8170_phpmailer_init' );
// function wpse8170_phpmailer_init( PHPMailer $phpmailer ) {
//     $phpmailer->Host = 'in.mailjet.com';
//     $phpmailer->Port = 587; // could be different
//     $phpmailer->Username = '4ce666d6783b920017e71c65c98cfb8e'; // if required
//     $phpmailer->Password = 'd6ef928ccb1c5ee2748d463fc29dc081'; // if required
//     $phpmailer->SMTPAuth = true; // if required
//     $phpmailer->SMTPSecure = 'ssl'; // enable if required, 'tls' is another possible value

//     $phpmailer->IsSMTP();
// }

add_filter('post_link', 'ug_post_link');
function ug_post_link($permalink) {
    global $post;

    $sitesArray = array(
    	'actualites' => 'http://urbangirl-actualites.fr',
    	'mode' => 'http://urbangirl-mode.fr',
    	'beaute' => 'http://urbangirl-beaute.fr',
    	'mariage' => 'http://urbangirl-mariage.fr',
    	'maman' => 'http://urbangirl-maman.fr',
    	'couple' => 'http://urbangirl-couple.fr',
    	'gastronomie' => 'http://urbangirl-gastronomie.fr',
    	'deco' => 'http://urbangirl-decoration.fr',
    	'bonnes-adresses' => 'http://urbangirl-sorties.fr',
    	'non-classe' => 'http://96.30.54.222/~urbangi/non-classe',
    );

    $chooseCat = array();
    foreach (get_the_category($post->ID) as $c) {
        array_push($chooseCat, $c->term_id);
    }

    if (sizeof($chooseCat) > 0) {
	    $chooseCatId = min($chooseCat);

	    $theSlug = (get_category($chooseCatId)->category_parent > 0) ? get_category(get_category($chooseCatId)->parent)->slug : get_category($chooseCatId)->slug;

	    $permalink = str_replace(get_bloginfo('url').'/'.$theSlug, $sitesArray[$theSlug], $permalink);
    }

    return $permalink;
}

add_filter('category_link', 'ug_category_link');
function ug_category_link($link) {

    $sitesArray = array(
    	get_bloginfo('url').'/actualites' => 'http://urbangirl-actualites.fr',
    	get_bloginfo('url').'/mode' => 'http://urbangirl-mode.fr',
    	get_bloginfo('url').'/beaute' => 'http://urbangirl-beaute.fr',
    	get_bloginfo('url').'/mariage' => 'http://urbangirl-mariage.fr',
    	get_bloginfo('url').'/maman' => 'http://urbangirl-maman.fr',
    	get_bloginfo('url').'/couple' => 'http://urbangirl-couple.fr',
    	get_bloginfo('url').'/gastronomie' => 'http://urbangirl-gastronomie.fr',
    	get_bloginfo('url').'/deco' => 'http://urbangirl-decoration.fr',
    	get_bloginfo('url').'/bonnes-adresses' => 'http://urbangirl-sorties.fr',
    	get_bloginfo('url').'/non-classe' => 'http://96.30.54.222/~urbangi/non-classe',
    );

    foreach ($sitesArray as $k => $v) {
    	$link = str_replace($k, $v, $link);
    }

    return $link;
}

add_filter('preview_post_link', 'ug_preview_link');
function ug_preview_link($link) {

    $sitesArray = array(
        'http://urbangirl-actualites.fr' => get_bloginfo('url').'/actualites',
        'http://urbangirl-mode.fr' => get_bloginfo('url').'/mode',
        'http://urbangirl-beaute.fr' => get_bloginfo('url').'/beaute',
        'http://urbangirl-mariage.fr' => get_bloginfo('url').'/mariage',
        'http://urbangirl-maman.fr' => get_bloginfo('url').'/maman',
        'http://urbangirl-couple.fr' => get_bloginfo('url').'/couple',
        'http://urbangirl-gastronomie.fr' => get_bloginfo('url').'/gastronomie',
        'http://urbangirl-decoration.fr' => get_bloginfo('url').'/deco',
        'http://urbangirl-sorties.fr' => get_bloginfo('url').'/bonnes-adresses'
    );

    foreach ($sitesArray as $k => $v) {
        $link = str_replace($k, $v, $link);
    }

    return $link;
}

function wpb_widgets_init() {
	register_sidebar( array(
		'name' => __( 'La sidebar du haut', 'wpb' ),
		'id' => 'sidebar-1',
		'description' => __( 'Vous pouvez ajouter des widgets qui vont apparaitre au dessous de la pub de la sidebar -- krimo.', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget Pub', 'wpb' ),
		'id' => 'sidebar-pub',
		'description' => __( 'Widget pour remplacer la pub Journal Du Luxe.', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget mode', 'wpb' ),
		'id' => 'sidebar-mode',
		'description' => __( 'Widget mode', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget beaute', 'wpb' ),
		'id' => 'sidebar-beaute',
		'description' => __( 'Widget beaute', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget gastronomie', 'wpb' ),
		'id' => 'sidebar-gastronomie',
		'description' => __( 'Widget gastronomie', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget beaute', 'wpb' ),
		'id' => 'sidebar-beaute',
		'description' => __( 'Widget beaute', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget deco', 'wpb' ),
		'id' => 'sidebar-deco',
		'description' => __( 'Widget deco', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget maman', 'wpb' ),
		'id' => 'sidebar-maman',
		'description' => __( 'Widget maman', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget mariage', 'wpb' ),
		'id' => 'sidebar-mariage',
		'description' => __( 'Widget mariage', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget couple', 'wpb' ),
		'id' => 'sidebar-couple',
		'description' => __( 'Widget couple', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget actualites', 'wpb' ),
		'id' => 'sidebar-actualites',
		'description' => __( 'Widget actualites', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Widget bonnes-adresses', 'wpb' ),
		'id' => 'sidebar-bonnes-adresses',
		'description' => __( 'Widget bonnes-adresses', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'La sidebar du bas', 'wpb' ),
		'id' => 'sidebar-2',
		'description' => __( 'Pareil, pour le dessous -- krimo.', 'wpb' ),
		'before_widget' => '<hr />',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'wpb_widgets_init' );

function ug_set_post_views($postID) {
    $count_key = 'ug_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

add_action('init', 'ug_send_article');
function ug_send_article() {
    if (isset($_POST['ug-share-email-list'])) {
        $emailArray = explode(',', $_POST['ug-share-email-list']);

        foreach ($emailArray as $email) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        }

        $cleanEmails = implode(',', $emailArray);

        $subject = $_POST['ug-share-name'].' vous recommande un article sur UrbanGirl';

        $message = $_POST['ug-share-name'].' ('.$_POST['ug-share-email'].') '.'vous recommande de lire l\'article suivant : '.$_POST['ug-share-permalink'].PHP_EOL.'Nous vous souhaitons une agréable lecture !';

        wp_mail(
            $cleanEmails,
            $subject,
            $message,
            'From: UrbanGirl <contact@urbangirl.fr>' . PHP_EOL
        );
    }
}

add_action('init', 'ug_send_contact_email');
function ug_send_contact_email() {
    if (isset($_POST['ug-contact-name'])) {

        if (!empty($_POST['ug-spam'])) {
            echo '
                <div data-alert class="alert-box error">
                    Une erreur est survenue, merci de ré-essayer.
                    <a href="#" class="close">&times;</a>
                </div>
            ';
            exit(0);
        }

        $subject = filter_var($_POST['ug-contact-subject'], FILTER_SANITIZE_STRING);
        $headers = 'From: '.filter_var($_POST['ug-contact-name'], FILTER_SANITIZE_STRING).' <'.filter_var($_POST['ug-contact-email'], FILTER_SANITIZE_EMAIL).'>' . PHP_EOL;
        $message = filter_var($_POST['ug-contact-message'], FILTER_SANITIZE_STRING) . PHP_EOL;

        if (isset($_POST['ug-contact-url'])) {
            $message .= 'Site internet : '.filter_var($_POST['ug-contact-url'], FILTER_SANITIZE_URL);
        }

        $sentEmail = wp_mail('contact@urbangirl.fr', $subject, $message, $headers);

        if ($sentEmail) {
            echo '
                <div data-alert class="ug-alert-box alert-box success">
                    Votre message a bien été envoyé.
                    <a href="#" class="close">&times;</a>
                </div>
            ';
        } else {
            echo '
                <div data-alert class="ug-alert-box alert-box error">
                    Une erreur est survenue, merci de ré-essayer.
                    <a href="#" class="close">&times;</a>
                </div>
            ';
        }
        exit(0);
    }
}

function is_old_post($days = 121) {
    $days = (int) $days;
    $offset = $days*60*60*24;
    if ( get_post_time() < date('U') - $offset ) {
        return true;
    } else {
        return false;
    }
}

add_filter( 'allow_dev_auto_core_updates', '__return_false' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( '1',
		array(
			'labels' => array(
				'name' => __( 'Articles sponso' ),
				'singular_name' => __( 'Article sponso' )
			),
		'public' => true,
		'has_archive' => true
		)
	);
}

?>
