<?php
    /** @var SunnyFlail\ExceptionHandler\ExceptionData $e */
    /** @var SunnyFlail\ExceptionHandler\TraceBlock $trace */
?>
<div id="<?php echo $trace->getId(); ?>" class="block">
    <div class="block__header">
        <a data-toggle-id="<?php echo $trace->getId(); ?>"
            <?php echo null !== ($lineId = $trace->getLineId()) ? sprintf(' href="#%s"', $lineId) : ""; ?>
            class="button__expand">
        </a>
        <div class="block__title">
            <div class="block__trace">
                <?php if (null !== $trace->getClassName()): ?>
                    <span class="block__class"><?php echo $trace->getClassName(); ?></span>
                <?php endif; ?>
                <?php if (null !== $trace->getType()): ?>
                    <span class="block__type"><?php echo $trace->getType(); ?></span>
                <?php endif; ?>                                    
                <span class="block__function">
                    <?php echo $trace->getFunction(); ?>
                </span>
            </div>
            <div class="block__location">
                in <?php printf("%s<b>%s</b>", $trace->getFilePath(), $trace->getFileName()); ?>
                <?php if (!is_null($trace->getType())): ?>
                    <?php printf('<span class="block__type">%s</span>', $trace->getType()) ?>
                <?php endif; ?>                                    
                <span class="block__function">
                    <?php echo $trace->getFunction() ?>
                </span>
                (line <?php echo $trace->getLine() ?>)
            </div>
        </div>
    </div>
    <code class="block__body">
        <?php foreach ($trace->getLines() as $line): ?>
            <?php require $line::$TEMPLATE_FILE; ?>
        <?php endforeach; ?>
        <?php if (!$trace->isValid()): ?>
            <?php require $trace::$INCORRECT_TEMPLATE_FILE; ?>
        <?php endif; ?>
    </code>
</div>