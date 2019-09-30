<?php get_header(); ?>

<main role="main">

    <?php if(have_posts()): ?>
    <?php while(have_posts()): the_post(); ?>

        <?php if(have_rows('slider')): ?>
            <?php get_template_part('partials/product/product', 'slider'); ?>
        <?php endif; ?>

        <div class="container marketing">

            <?php if(have_rows('features')): ?>

                <?php get_template_part('partials/product/product', 'features'); ?>

            <?php endif; ?>

            <?php if(have_rows('banners')): ?>

                <?php get_template_part('partials/product/product', 'banners'); ?>

            <?php endif; ?>

            <?php if(true): ?>

                <?php get_template_part('partials/product/product', 'related'); ?>

            <?php endif; ?>

            <!-- /END THE FEATURETTES -->

        </div>

        <?php endwhile; ?>

    <?php endif; ?>
</main>

<?php get_footer(); ?>