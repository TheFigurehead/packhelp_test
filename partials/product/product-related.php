<section class="related-products">
    <h2>Related Products</h2>
    <div class="row">
        <?php 
            $related = PackhelpTheme::getRelatedProducts(get_the_ID());
            $related_ids = wp_list_pluck($related, 'ID');
            $related_query = new WP_Query( [
                'post__in' => $related_ids,
                'numberposts' => -1,
                'post_type' => 'any'
            ] );
        ?>
        <?php while($related_query->have_posts()): $related_query->the_post();?>
            <?php get_template_part('partials/product/product', 'preview'); ?>
        <?php endwhile; ?>
    </div>

    <div id="root_related"></div>
</section>