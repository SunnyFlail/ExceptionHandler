# Exception Handler
A simple graphical interface over exception message
# How to use
Just include your composer autoload file and 
```php
<?php
require_once __DIR__."/../vendor/autoload.php";

set_exception_handler([SunnyFlail\ExceptionHandler\ExceptionHandler::class, "handleException"]);
```

It's as simple as that :)