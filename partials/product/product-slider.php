<?php
$slides = get_field('slider');
if(count($slides)>0):
?>
<div id="carousel_<?=get_the_ID()?>" class="carousel slide" data-ride="carousel">

    <?php if( count( $slides ) > 1 ): ?>
        <ol class="carousel-indicators">
            <?php for($i = 0; $i < count($slides); $i++): ?>
                <li data-target="#carousel_<?=get_the_ID()?>" data-slide-to="<?=$i?>" class="<?=($i==0) ? 'active' : ''?>"></li>
            <?php endfor; ?>
        </ol>
    <?php endif; ?>

    <div class="carousel-inner">

    <?php foreach($slides as $key => $slide): 
            $text_align = $slide['align'];
            switch($text_align){
                case 'left': 
                    $text_class = 'text-left';
                    break;
                case 'right': 
                    $text_class = 'text-right';
                    break;
                default:
                    $text_class = '';
            }
        ?>

        <div class="carousel-item <?=($key == 0) ? 'active' : ''?>">

            <img src="<?=$slide['image']?>" class="bd-placeholder-img" width="100%" focusable="false" />
        
            <div class="container">
                <div class="carousel-caption <?=$text_class?>">
                <h1><?=$slide['heading']?></h1>
                <p><?=$slide['text']?></p>
                <?php if($slide['button']['label']): ?>
                    <p>
                        <a class="btn btn-lg btn-primary" href="<?=$slide['button']['link']?>" role="button">
                            <?=$slide['button']['label']?>
                        </a>
                    </p>
                <?php endif; ?>
                </div>
            </div>

        </div>
    <?php endforeach; ?>

    </div>
    <?php if( count( $slides ) > 1 ): ?>
        <a class="carousel-control-prev" href="#carousel_<?=get_the_ID()?>" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel_<?=get_the_ID()?>" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>