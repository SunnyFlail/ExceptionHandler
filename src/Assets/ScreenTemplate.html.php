<?php
    /** @var SunnyFlail\ExceptionHandler\ExceptionData[] $exceptions */
    $exception = $exceptions[0]; 
    $exceptionName = $exception->getName();
    $exceptionParent = $exception->getParentname();
    $exceptionMessage = $exception->getMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>An error occured!</title>
    <style>
        <?php require_once __DIR__ . "/style.css" ?>
    </style>
</head>
<body>
    <header class="header">
        <div class="header__top">
            <div class="header__top__about">
                <?php if (null !== $exceptionParent): ?>
                    <div><?php echo $exceptionParent; ?></div>
                    <div class="arrow__next"></div>
                <?php endif; ?>
                <div>
                    <?php echo $exceptionName; ?>
                </div> 
            </div>
        </div>
        <div class="header__bottom">
            <div>   
                <?php echo $exceptionMessage; ?>
            </div>
        </div>                
     </header>
    <main class="main">
        <?php foreach ($exceptions as $e): ?>
            <?php require $e::$TEMPLATE_FILE; ?>
        <?php endforeach; ?>
    </main>

    <script>
        <?php require_once __DIR__ . "/script.js" ?>
    </script>
</body>
</html>