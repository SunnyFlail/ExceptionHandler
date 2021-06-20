<div id="<?php echo $this->index ?>" class="block">
    <div class="block__header">
        <div data-toggle-id="<?php echo $this->index ?>" class="button__expand"></div>
        <div class="block__title">
            <div class="block__trace">
                <?php if (null !== $this->className): ?>
                    <?php printf('<span class="block__class">%s</span>', $this->className); ?>
                <?php endif; ?>
                <?php if (null !== $this->type): ?>
                    <?php printf('<span class="block__type">%s</span>', $this->type) ?>
                <?php endif; ?>                                    
                <span class="block__function">
                    <?php echo $this->function ?>
                </span>
            </div>
            <div class="block__location">
                in <?php printf("%s<b>%s</b>", $this->filePath, $this->fileName); ?>
                <?php if (!is_null($this->type)): ?>
                    <?php printf('<span class="block__type">%s</span>', $this->type) ?>
                <?php endif; ?>                                    
                <span class="block__function">
                    <?php echo $this->function ?>
                </span>
                (line <?php echo $this->line ?>)
            </div>
        </div>
    </div>
    <code class="block__body"><?php $this->printLines();?></code>
</div>