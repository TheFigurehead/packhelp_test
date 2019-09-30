<?php
$products = new WP_Query([
    'post_type' => 'ph_product',
    'numberposts' => -1
]);
?>
<?php if($products->have_posts()): ?>
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">

                <?php while($products->have_posts()): $products->the_post(); ?>

                    <?php get_template_part('partials/product/product', 'preview'); ?>

                <?php endwhile; ?>

            </div>
        </div>
    </div>
<?php endif; ?>