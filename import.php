<?php

use SunnyFlail\ExceptionHandler\ExceptionHandler;

set_error_handler([ExceptionHandler::class, "handleError"]);
set_exception_handler([ExceptionHandler::class, "handleException"]);
