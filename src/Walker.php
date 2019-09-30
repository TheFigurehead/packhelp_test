<?php 

class PH_Nav_Menu_Walker extends Walker {
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    function start_lvl(&$output, $depth = 0, $args = []) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent";
        $output .= "<i class=\"dropdown icon\"></i>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = []) {
        $indent = str_repeat("\t", $depth);
    }

    function start_el(&$output, $object, $depth = 0, $args = [], $current_object_id = 0) {
        $value = '';
        $classes = $object->classes;
        $classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array();
        $classes[] = 'nav-link';    
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object, $args ) );
        $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', '', $object, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';
        $object_output = $args->before;
        $object_output .= '<li class ="nav-item">';
        $object_output .= '<a ' . $class_names . $attributes . '>';
        $object_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
        $object_output .= "</a>\n";
        $object_output .= "</li>\n";
        $object_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
    }
}