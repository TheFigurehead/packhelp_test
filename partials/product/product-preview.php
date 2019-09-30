<div class="col-md-4">
    <div class="card mb-4 shadow-sm">
        <?php echo get_the_post_thumbnail( 
            get_the_ID(), 
            'medium', 
            array( 
                'class' => 'bd-placeholder-img card-img-top', 
                'placeholder' => get_the_title(),
                'width' => '100%',
                'height' => 'auto'
                ) 
            ); 
        ?>
        <div class="card-body">
            <p class="card-text">
                <?php the_excerpt(); ?>
            </p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-secondary">View</a>
                    <?php if(current_user_can( 'edit_post', get_the_ID() )): ?>
                        <a href="<?=get_edit_post_link(get_the_ID())?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <?php endif; ?>
                </div>
                <small class="text-muted"><?php the_date(); ?></small>
            </div>
        </div>
    </div>
</div>