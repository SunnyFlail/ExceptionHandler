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
            <div class="header__top__about">
                <?php if ($exceptionParent) { printf('<div>%s</div><div class="arrow__next"></div>', $exceptionParent); } ?>
                <div> <?php echo $exceptionName ?> </div> 
            </div>
            <div>Error Code: <?php echo $exceptionCode ?></div>
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
                <?php array_walk($stackTraces, fn($stack) => print($stack)); ?>
            </div>
        </div>
    </main>

    <script>
        <?php require_once __DIR__."/script.js" ?>
    </script>
</body>
</html>