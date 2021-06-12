<?php

namespace SunnyFlail\ExceptionHandler;

use ReflectionClass;
use SplFileObject;
use Throwable;

class ExceptionHandler
{

    public static int $EDGE_LINES = 5;

    public static function handleException(Throwable $e)
    {
        $exceptionMessage = $e->getMessage();
        $reflection = new ReflectionClass($e);
        [$exceptionNmscp, $exceptionName] = self::splitLast($reflection->getName(), "\\");
        $exceptionParent = $reflection->getParentClass();
        if ($exceptionParent) {
            $exceptionParent = $exceptionParent->getName();
        }
        $stackTraces = $e->getTrace(); 

        require_once __DIR__."/ExceptionTemplate.html.php";
        die();
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

    private static function getCode(string $path, int $line)
    {
        $startLine = $line - self::$EDGE_LINES;
        $startLine = $startLine >= 0 ? $startLine : 0;
        $endLine = $line + self::$EDGE_LINES;

        $file = new SplFileObject($path);
        $file->seek($startLine);

        while ($file->valid() && $endLine !== ($currentLine = $file->key() + 1)) {
            yield [
                "line" => $currentLine,
                "value" => self::highlightBrackets($file->current())
            ];
            $file->next();
        }

    }

    private static function highlightBrackets(string $line): string
    {
        return preg_replace(["/[\[\]\(\)\;:=]+/", "/\-\>/"], '<span class="red">$0</span>', $line);
    }

}