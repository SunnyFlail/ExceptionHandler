<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>An error occured!</title>
    <style>
        <?php require_once "style.css" ?>
    </style>

</head>
<body>
    <header class="header">
        <div class="header__top">
            <?php if ($exceptionParent) { printf('<div>%s</div>', $exceptionParent); } ?>
            <div> <?php echo $exceptionName ?> </div> 
        </div>
        <div class="header__bottom">
            <div>   
                <?php echo $exceptionMessage ?>
            </div>
        </div>                
     </header>
    <main class="main">
        <div class="panel">
            <div class="panel__header">
                <div class="panel__header__top">
                    <div>
                        <?php echo $exceptionNmscp ?>
                    </div>
                </div>
                <div class="panel__header__bottom">
                    <?php echo $exceptionName ?>
                </div>
            </div>
            <div class="panel__body">
                 
                <?php
                foreach ($stackTraces as $key => $stackTrace) : ?>
                    <?php $blockId = "block__$key"; 
                        extract($stackTrace)
                    ?>
                    <div id="<?php echo $blockId ?>" class="block">
                        <div class="block__header">
                            <div data-toggle-id="<?php echo $blockId ?>" class="button__expand"></div>
                            <div class="block__title">
                                <div class="block__trace">
                                    <?php if (isset($class)): ?>
                                        <?php printf('<span class="block__class">%s</span>', self::splitLast($class, "\\")[1]); ?>
                                    <?php endif; ?>
                                    <?php if (isset($type)): ?>
                                        <?php printf('<span class="block__type">%s</span>', $type) ?>
                                    <?php endif; ?>                                    
                                    <span class="block__function">
                                        <?php echo $function ?>
                                    </span>
                                </div>
                                <div class="block__location">
                                    in <?php printf("%s<b>%s</b>", ...self::splitLast($file, "/")); ?>
                                    <?php if (isset($type)): ?>
                                        <?php printf('<span class="block__type">%s</span>', $type) ?>
                                    <?php endif; ?>                                    
                                    <span class="block__function">
                                        <?php echo $function ?>
                                    </span>
                                    (line <?php echo $line ?>)
                                </div>
                            </div>
                        </div>
                        <pre class="block__body">
                            <code>
                                <?php foreach(self::getCode($file, $line) as ["line" => $currLine, "value" => $value] ): ?>
                                    <?php printf ('<div class="block__line%3$s"><span class="line__num">%1$s.</span><span class="line__content">%2$s</span></div>', $currLine, $value, $currLine === $line ? " current" : ""); ?>
                                <?php endforeach; ?>
                            </code>
                        </pre>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        <?php require_once __DIR__."/script.js" ?>
    </script>
</body>
</html>