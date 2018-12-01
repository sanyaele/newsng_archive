<?php
/*
Plugin Name: List Category Posts - Template "Default"
Plugin URI: http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/
Description: Template file for List Category Post Plugin for Wordpress which is used by plugin by argument template=value.php
Version: 0.9
Author: Radek Uldrych & Fernando Briano 
Author URI: http://picandocodigo.net http://radoviny.net
*/

/* Copyright 2009  Radek Uldrych  (email : verex@centrum.cz), Fernando Briano (http://picandocodigo.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or 
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * The format for templates changed since version 0.17.
 * Since this code is included inside CatListDisplayer, $this refers to
 * the instance of CatListDisplayer that called this file.
 */

/* This is the string which will gather all the information.*/
$lcp_display_output = '';

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
$lcp_display_output .= '<ul class="lcp_catlist">';

// Get category id, link, and name
$lpc_category_id = $this->catlist->get_category_id();
$lpc_cat_link = get_category_link($lpc_category_id);
$lpc_cat_name = get_cat_name($lpc_category_id);


// Show Category header
echo '<h2 class="widget-title" style="padding-left:15px;">'.$lpc_cat_name.'</h2>';
/**
 * POSTS LOOP
 *
 * The code here will be executed for every post in the category.
 * As you can see, the different options are being called from functions on the
 * $this variable which is a CatListDisplayer.
 *
 * The CatListDisplayer has a function for each field we want to show.
 * So you'll see get_excerpt, get_thumbnail, etc.
 * You can now pass an html tag as a parameter. This tag will sorround the info
 * you want to display. You can also assign a specific CSS class to each field.
 */
// WP_Query arguments
$args = array (
	'post_type'              => 'post',
	'cat'         			 => $lpc_category_id,
	'meta_key'				 => 'Buzz',
	'orderby'                => 'meta_value_num',
	'order'                  => 'DESC',
	'date_query'     => array(
                            	array(
                            		'after' => 'yesterday'
                            	)
                        )
);

$args2 = array (
	'post_type'              => 'post',
	'cat'         			 => $lpc_category_id,
	'meta_key'				 => 'Buzz',
	'orderby'                => 'meta_value_num',
	'order'                  => 'DESC',
	'date_query'     => array(
                            	array(
                            		'after' => '-2 days'
                            	)
                        )
);
// The Query
$query = new WP_Query( $args );

// The Loop
$i = 0;
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		// do something
		
		if ($i == 0){
			?>
            <div style="padding:7px;">		
                <h4 style="color:#06C;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                <?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					the_post_thumbnail('medium');
				} 
				?>
                <div style="color:#F00; font-size: small;"><strong>Buzz:</strong> <?php echo get_post_meta($query->post->ID, 'Buzz', true);?></div>
                <div style="font-size:9px; font-weight:bold;"><?php the_time('M j, Y')." PostId:".$post->ID; ?></div>
        
                        <div style="font-size:16px;"><?php the_excerpt(); ?></div>
                
        </div>
            <?php
			
		} elseif ($i < 5){
			?>
            <div style="padding:7px;">		
                <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                <div style="color:#F00; font-size: small;"><strong>Buzz:</strong> <?php echo get_post_meta($query->post->ID, 'Buzz', true);?></div>
                <div style="font-size:9px; font-weight:bold;"><?php the_time('M j, Y'); ?></div>
        
                        <div>
						<?php
						if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							the_post_thumbnail(array(100, 100));
						} 
						
						the_excerpt(); ?></div>
                
        </div>
            <?php
			
		} else {
		
		?>
		
		<div style="padding-left:7px;padding-right:7px;">		
                <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <span style="color:#C00; font-size: small;"><strong>Buzz:</strong> <?php echo get_post_meta($query->post->ID, 'Buzz', true);?></span></h5>
                
        </div>
	<?php
		}
		$i++;
    }
	
	// Show read more
	//echo "<div></div>";
} else {
	// no posts found, load yesterday's posts
	
	// The Query
	$query2 = new WP_Query( $args2 );
	
	// The Loop
	$i = 0;
	if ( $query2->have_posts() ) {
		while ( $query2->have_posts() ) {
			$query2->the_post();
			?>
            <div style="padding:7px;">		
                <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                <div style="color:#F00; font-size: small;"><strong>Buzz:</strong> <?php echo get_post_meta($query2->post->ID, 'Buzz', true);?></div>
                <div style="font-size:9px; font-weight:bold;"><?php the_time('M j, Y'); ?></div>
        
                        <div>
                        <?php
                        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                            the_post_thumbnail(array(100, 100));
                        } 
                        
                        the_excerpt(); ?></div>
                    
            </div>
            <?php
		}
		
	}
}

// Restore original Post Data
wp_reset_postdata();

// Close the wrapper I opened at the beginning:
$lcp_display_output .= '</ul>';

// If there's a "more link", show it:
$lcp_display_output .= $this->catlist->get_morelink();

//Pagination
$lcp_display_output .= $this->get_pagination();

$this->lcp_output = $lcp_display_output;