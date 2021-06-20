<?php

namespace SunnyFlail\ExceptionHandler;

use ErrorException;
use ReflectionClass;
use Throwable;

class ExceptionHandler
{

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
        $exceptionMessage = $e->getMessage();
        $reflection = new ReflectionClass($e);
        [$exceptionNmscp, $exceptionName] = self::splitLast($reflection->getName(), "\\");
        $exceptionParent = $reflection->getParentClass();
        if ($exceptionParent) {
            $exceptionParent = $exceptionParent->getName();
        }
        $exceptionCode = $e->getCode();
        $stackTraces = $e->getTrace();
        array_unshift($stackTraces, [
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "function" => $exceptionMessage
            ]
        );

        $stackTraces = array_map([self::class, "createTraceBlock"],  array_keys($stackTraces), $stackTraces);
        
        require_once __DIR__."/Assets/ExceptionTemplate.html.php";
        die();
    }

    private static function createTraceBlock(int $index, array $traceData): TraceBlock
    {
        if ($class = $traceData["class"] ?? null) {
            [$namespace, $className] = self::splitLast($class, "\\");
        }
        if ($file = $traceData["file"] ?? null) {
            [$path, $fileName] = self::splitLast($file, "/");
        }
        $line = $traceData["line"] ?? null;
        $function = $traceData["function"] ?? null;
        $type = $traceData["type"] ?? null;

        return new TraceBlock(
            $index,
            $function,
            $className ?? "",
            $namespace ?? "",
            $path ?? "",
            $fileName ?? "",
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