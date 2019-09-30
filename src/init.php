<?php
require PachhelpThemePath . '/src/Walker.php';

class PackhelpTheme{

    public static function initTheme(){

        static::enqueueAssets();

        add_action('after_setup_theme', [__CLASS__, 'addPostTypes']);
        add_action('init', [__CLASS__, 'addTaxonomies']);
        add_action('init', [__CLASS__, 'registerMenus']);

        add_action( 'rest_api_init', function () {
            register_rest_route( 'related/v1', '/product/(?P<id>\d+)/(?P<user>\d+)', array(
                'methods' => 'GET',
                'callback' => [__CLASS__, 'relatedEndpoint']
            )); 
        });
        
    }

    public static function relatedEndpoint($request_data){
        $related = static::getRelatedProducts($request_data['id']);
        $related_ids = wp_list_pluck($related, 'ID');
        $related_query = new WP_Query( [
            'post__in' => $related_ids,
            'numberposts' => -1,
            'post_type' => 'any'
        ] );
        if($related_query->have_posts()){
            $result = [];
            while($related_query->have_posts()){ 
                $related_query->the_post();
                $result[] = [
                    'ID' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'date' => get_the_date(),
                    'permalink' => get_permalink(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium')
                ];
            }
            return $result;
        }
        return false;
    }

    public static function enqueueAssets(){
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueueAssetsScripts']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueueAssetsStyles']);
    }

    public static function enqueueAssetsScripts(){
        wp_enqueue_script( 'packhelp-theme-bs-script', PachhelpThemeUrl . '/assets/js/bootstrap/bootstrap.bundle.min.js', [], time(), true );
        wp_enqueue_script( 'packhelp-theme-react-script', PachhelpThemeUrl . '/assets/js/rendered.js', [], time(), true );
        wp_localize_script(
            'packhelp-theme-react-script',
            'packhelp_data',
            [
                'id' => get_the_ID(),
                'user' => get_current_user_id()
            ]
        );
    }
    
    public static function enqueueAssetsStyles(){
        wp_enqueue_style( 'packhelp-theme-main-style', get_stylesheet_uri() );
        wp_enqueue_style( 'packhelp-theme-bs-style', PachhelpThemeUrl . '/assets/css/bootstrap.min.css' );
    }

    public static function addPostTypes(){
        $labels = array(
            'name'               => _x( 'Products', 'post type general name', 'packhelp' ),
            'singular_name'      => _x( 'Product', 'post type singular name', 'packhelp' ),
            'menu_name'          => _x( 'Products', 'admin menu', 'packhelp' ),
            'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'packhelp' ),
            'add_new'            => _x( 'Add New', 'book', 'packhelp' ),
            'add_new_item'       => __( 'Add New Product', 'packhelp' ),
            'new_item'           => __( 'New Product', 'packhelp' ),
            'edit_item'          => __( 'Edit Product', 'packhelp' ),
            'view_item'          => __( 'View Product', 'packhelp' ),
            'all_items'          => __( 'All Products', 'packhelp' ),
            'search_items'       => __( 'Search Products', 'packhelp' ),
            'parent_item_colon'  => __( 'Parent Products:', 'packhelp' ),
            'not_found'          => __( 'No products found.', 'packhelp' ),
            'not_found_in_trash' => __( 'No products found in Trash.', 'packhelp' )
        );
    
        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', 'packhelp' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'ph_product' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-archive',
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
    
        register_post_type( 'ph_product', $args );
    }

    public static function addTaxonomies(){

        $labels = array(
            'name'                       => _x( 'Product Categories', 'taxonomy general name', 'packhelp' ),
            'singular_name'              => _x( 'Product Category', 'taxonomy singular name', 'packhelp' ),
            'search_items'               => __( 'Search Product Categories', 'packhelp' ),
            'popular_items'              => __( 'Popular Product Categories', 'packhelp' ),
            'all_items'                  => __( 'All Product Categories', 'packhelp' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Product Category', 'packhelp' ),
            'update_item'                => __( 'Update Product Category', 'packhelp' ),
            'add_new_item'               => __( 'Add New Product Category', 'packhelp' ),
            'new_item_name'              => __( 'New Product Category Name', 'packhelp' ),
            'separate_items_with_commas' => __( 'Separate Product Categories with commas', 'packhelp' ),
            'add_or_remove_items'        => __( 'Add or remove Product Categories', 'packhelp' ),
            'choose_from_most_used'      => __( 'Choose from the most used Product Categories', 'packhelp' ),
            'not_found'                  => __( 'No Product Categories found.', 'packhelp' ),
            'menu_name'                  => __( 'Product Categories', 'packhelp' ),
        );
    
        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,    
            'rewrite'               => array( 'slug' => 'ph_product_cat' ),
        );
    
        register_taxonomy( 'ph_product_cat', 'ph_product', $args );
    }

    public static function getRelatedProducts($post_id, $quantity = 3){

        $related = (!empty($related)) ? 
        array_map(function ($ar) {return $ar['product'];}, (array)get_field('related', $post_id)) : null;

        $left = $quantity - count((array)$related);

        if($left > 0){
            $related = static::addRelatedFromCat($post_id, $related, $left);
            $left = $quantity - count((array)$related);
            if($left > 0){
                $related = static::addAnyProducts($post_id, $related, $left);
            }
        }

        return $related;

    }

    public static function addRelatedFromCat($post_id, $related, $left = 0){

        $related = (!$related) ? [] : $related;

        $terms = get_the_terms($post_id, 'ph_product_cat');
        $related_ids = wp_list_pluck( $related, 'ID' );

        $term_ids = [];

        foreach($terms as $term){
            $term_ids[] = $term->term_id;
        }
        
        $products = get_posts(
            [
                'post_type' => 'ph_product',
                'numberposts' => $left,
                'tax_query' => array(
                    array(
                    'taxonomy' => 'ph_product_cat',
                    'field' => 'term_id',
                    'terms' => $term_ids
                    )
                ),
                'post__not_in' => $related_ids
            ]
        );

        $related = array_merge( $related, $products );

        return $related;

    }

    public static function addAnyProducts($post_id, $related, $left = 0){

        $related_ids = wp_list_pluck( $related, 'ID' );

        $products = get_posts(
            [
                'post_type' => 'ph_product',
                'numberposts' => $left,
                'post__not_in' => $related_ids
            ]
        );

        $related = array_merge( $related, $products );

        return $related;

    }

    public static function registerMenus(){
        register_nav_menus(
            [
                'primary' => 'Primary menu',
                'secondary' => 'Secondary menu'
            ]
        );
    }

}

PackhelpTheme::initTheme();