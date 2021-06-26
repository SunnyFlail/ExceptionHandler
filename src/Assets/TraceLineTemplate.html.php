<?php /** @var SunnyFlail\ExceptionHandler\TraceLine $line */ ?>
<div id="<?php echo $line->getId(); ?>" class="block__line<?php echo $line->isHighlighted() ? ' highlight' : ""; ?>">
    <span class="line__num"><?php echo $line->getIndex(); ?>.</span>
    <span class="line__content"><?php echo $line->getContents(); ?></span>
</div>