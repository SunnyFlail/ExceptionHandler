<?php /** @var SunnyFlail\ExceptionHandler\ExceptionData $e */ ?>
<div class="panel" id="<?php echo $e->getId(); ?>">
    <div class="panel__header">
        <div class="panel__header__top">
            <?php if (!empty($e->getNamespace())): ?>
                <div>
                    <?php echo $e->getNamespace(); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="panel__header__bottom">
            <?php echo $e->getName(); ?>
        </div>
        <div data-toggle-id="<?php echo $e->getId(); ?>" class="button__expand big"></div>
    </div>
    <div class="panel__body">
        <?php foreach ($e->getStacktrace() as $trace): ?>
            <?php require $trace::$TEMPLATE_FILE; ?>
        <?php endforeach; ?>
    </div>
</div>