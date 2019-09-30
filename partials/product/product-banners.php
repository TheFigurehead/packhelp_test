<?php 
    $left = false;
    while(have_rows('banners')): the_row(); ?>
    <?php
        if(get_field('banners_auto_align')){
            $left = !$left;
        }else{
            $left = (get_sub_field('align')=='left') ? true : false;
        }
    ?>
    <div class="row featurette">
        <div class="flex-column col-md-7 <?=($left) ? 'order-md-2' : ''?>">
            <h2 class="featurette-heading">
                <?php the_sub_field('heading'); ?>
                <span class="text-muted"><?php the_sub_field('subheading'); ?></span>
            </h2>
            <?php the_sub_field('content'); ?>
        </div>
        <div class="flex-column col-md-5 <?=($left) ? 'order-md-1' : ''?>">
            <img width="100%" src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('heading'); ?>">
        </div>
    </div>

    <hr class="featurette-divider">

<?php endwhile; ?>


<!-- <div class="row featurette">
    <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
    </div>
    <div class="col-md-5 order-md-1">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
    </div>
</div>

<hr class="featurette-divider">

<div class="row featurette">
    <div class="col-md-7">
        <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
    </div>
    <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
    </div>
</div>

<hr class="featurette-divider"> -->