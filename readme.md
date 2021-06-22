# Exception Handler
A simple graphical interface over exception message
# How to use
After installing it with composer and importing composer autoloader in your front controller file,
insert this code at top of your  front controller, just after importing autoload.php

```php
use SunnyFlail\ExceptionHandler\ExceptionHandler;

set_error_handler([ExceptionHandler::class, "handleError"]);
set_exception_handler([ExceptionHandler::class, "handleException"]);
```