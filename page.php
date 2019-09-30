<?php
/** Template Name: Main page template */
get_header();
?>

<main role="main">

    <?php while(have_posts()): the_post(); ?>

        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">
                    <?php the_title(); ?>
                </h1>
                <p class="lead text-muted">
                    <?php the_excerpt(); ?>
                </p>
                <?php if( have_rows('page_navigation') ): ?>
                    <p>
                        <?php while ( have_rows('page_navigation') ) : the_row(); ?>

                            <?php $link = get_sub_field('link')[0]['value']; ?>

                            <a href="<?=$link?>" class="btn btn-<?php the_sub_field('priority'); ?>">
                                <?php the_sub_field('label'); ?>
                            </a>

                        <?php endwhile; ?>  
                    </p>
                <?php endif; ?>
            </div>
        </section>

    <?php endwhile; ?>

    <?php get_template_part('partials/content', 'page'); ?>

</main>

<?php get_footer(); ?>