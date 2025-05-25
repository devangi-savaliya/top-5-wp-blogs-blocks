<?php
/**
 * plugin Name: Top 5 wordpress block 
 * 
 * Description: this is for 5 blog post 
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function top_5_wp_blog_register_block() {
    wp_register_script(
        'top-5-wp-blogs-js',
        plugins_url( 'index.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' )
    );

    wp_register_style(
        'top-5-wp-blogs-css',
        plugins_url( 'style.css', __FILE__ )
    );

    register_block_type( 'custom/top-5-blog', array(
        'editor_script' => 'top-5-wp-blogs-js',
        'editor_style'  => 'top-5-wp-blogs-css',
        'render_callback'         => 'top_5_blog_render',
    ) );
}
add_action( 'init', 'top_5_wp_blog_register_block' );

function top_5_blog_render($attributes){
    $orderby = isset($attributes['orderBy'])?$attributes['orderBy']: 'date';
    $order = isset($attributes['order'])?$attributes['order']: 'DESC';
    $number = isset($attributes['numberofPosts'])?$attributes['numberofPosts']: 5;

    //mapping

    $orderBy_map = [

        'name' => 'title',
        'date' => 'date'
    ];
    $orderBy = isset($orderBy_map['orderby'])?$orderBy_map['orderby']: 'date';

   $args = array(
        'post_type' => 'post',
        'posts_per_page' =>$number,
        'orderby' => $orderby,
        'order' => $order,

    );
    $query = new wp_Query($args);

    if(!$query->have_posts()) return '<p>No post found</p>';


    $html = '<div class="wp-block-custom-top-5-wp-blogs">';
    while($query->have_posts()){
    $query->the_post();
    $image = get_the_post_thumbnail(get_the_ID(), array(300, 240), array('style' => 'width:300px; height:240px'));
    $html .='<article>';
    $html .=$image? $image : '<div style="width:300px; heigh:240px; background:#ccc;"></div>';
    $html .= '<h3><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></h3>';
    $html .= '<p>'.esc_html(get_the_content()).'</p>';
    $html .='</article>';

    }
    $html .='</div><style>
    .wp-block-custom-top-5-wp-blogs {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    }
</style>';
    wp_reset_postdata();
    return $html;
}
?>