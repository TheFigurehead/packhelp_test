<div class="row features-wrapper">
    <?php $col_size = round(12 / count(get_field('features')), 0, PHP_ROUND_HALF_DOWN); ?>
    <?php while(have_rows('features')): the_row(); ?>
        <div class="feature-block col-lg-<?=$col_size?>">
        <div class="feature-image" style="background-image: url(<?php the_sub_field('image'); ?>)" >
            <!-- src="<?php // the_sub_field('image'); ?>"
            class="bd-placeholder-img rounded-circle"
            width="150px"
            height="auto" 
            focusable="false" 
            aria-label="Placeholder: 140x140" -->
        </div>
        <h2><?php the_sub_field('heading'); ?></h2>
        <p><?php the_sub_field('text'); ?></p>
        <?php if(get_sub_field('details_link')): ?>
            <p>
                <a class="btn btn-secondary" href="<?php the_sub_field('details_link'); ?>" role="button">
                    View details »
                </a>
            </p>
        <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<hr class="featurette-divider">