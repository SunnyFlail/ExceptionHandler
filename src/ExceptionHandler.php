<?php

namespace SunnyFlail\ExceptionHandler;

use ErrorException;
use ReflectionClass;
use Throwable;

class ExceptionHandler
{

    public static $TEMPLATE_FILE = __DIR__ . "/Assets/ScreenTemplate.html.php";

    public static function handleError(
        int $errNo,
        string $errstr,
        string $errfile,
        int $errline
    ) {
        throw new ErrorException(
            $errstr,
            0,
            $errNo,
            $errfile,
            $errline
        );
    }

    public static function handleException(Throwable $e)
    {
        $exceptions = [];
        while ($e !== null) {
            $exceptions[] = $e;
            $e = $e->getPrevious();
        }

        $exceptions = array_map(
            [self::class, "createExceptionData"],
            array_keys($exceptions),
            $exceptions
        );

        return self::render($exceptions);
    }

    private static function render(array $exceptions)
    {
        require_once self::$TEMPLATE_FILE;
        die();
    }

    private static function createExceptionData(int $index, Throwable $e): ExceptionData
    {
        $exceptionMessage = $e->getMessage();
        $reflection = new ReflectionClass($e);
        [$exceptionNmscp, $exceptionName] = self::splitLast($reflection->getName(), "\\");
        $exceptionParent = $reflection->getParentClass();
        if ($exceptionParent) {
            $exceptionParent = $exceptionParent->getName();
        }
        $stackTraces = $e->getTrace();

        array_unshift($stackTraces, [
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "function" => $exceptionMessage,
            "type" => " Message: "
            ]
        );

        $stackTraces = array_map(
            [self::class, "createTraceBlock"],
            array_keys($stackTraces),
            array_fill(0, count($stackTraces), $index),
            $stackTraces
        );

        return new ExceptionData(
            $index,
            $exceptionName,
            $exceptionNmscp,
            $exceptionMessage,
            $stackTraces,
            $exceptionParent
        );
    }

    private static function createTraceBlock(int $index, int $exceptionIndex, array $traceData): TraceBlock
    {
        if (strlen($class = $traceData["class"] ?? null) > 0) {
            [$namespace, $className] = self::splitLast($class, "\\");
        }
        if (strlen($file = $traceData["file"] ?? null) > 0) {
            [$path, $fileName] = self::splitLast($file, "/");
        }
        $line = $traceData["line"] ?? null;
        $function = $traceData["function"] ?? null;
        $type = $traceData["type"] ?? null;

        return new TraceBlock(
            $index,
            $exceptionIndex,
            $function,
            $className ?? "",
            $namespace ?? "",
            $path ?? "",
            $fileName ?? "",
            $file,
            $line,
            $type
        );
    }

    private static function splitLast(string $string, string $separator): array
    {
        if (!$breakpoint = strrpos($string, $separator)) {
            return ["", $string];
        }
        $split = str_split($string, $breakpoint + 1);
        $path = array_shift($split);

        return [$path, implode($split)];
    }

}