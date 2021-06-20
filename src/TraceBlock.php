<?php

namespace SunnyFlail\ExceptionHandler;

use SplFileObject;

class TraceBlock
{

    private ?string $index;
    public static int $EDGE_LINES = 5;

    public function __construct(
        ?string $index,
        private ?string $function,
        private ?string $className,
        private ?string $namespace,
        private ?string $filePath,
        private ?string $fileName,
        private ?string $file,
        private ?int $line,
        private ?string $type
    ) {
        $this->index = "block__".$index;
    }

    public function render()
    {
        require __DIR__."/Assets/TraceTemplate.html.php";
    }

    private function printLines()
    {
        $valid = false;
        foreach($this->getCode() as ["line" => $currLine, "value" => $value])
        {
            $valid = true;
            printf (
                '<div class="block__line%3$s">
                    <span class="line__num">%1$s.</span>
                    <span class="line__content">%2$s</span>
                </div>',
                $currLine,
                $value,
                $currLine === $this->line ? " current" : ""
            );
        }
        if (!$valid) {
            return printf("<div class='block__line'style='color: firebrick; font-weight: 600;'>Couldn't read file '%s'</div>", $this->file);
        }
    }

    private function getCode()
    {
        $path = $this->filePath.$this->fileName;
        $path = trim($path) === "" ? $this->file : $path;
        $line = $this->line;
        $startLine = $line - self::$EDGE_LINES;
        $startLine = $startLine >= 0 ? $startLine : 0;
        $endLine = $line + self::$EDGE_LINES;

        if (!is_readable($path)) {
            return [];
        }

        $file = new SplFileObject($path);
        $file->seek($startLine);

        while ($file->valid() && $endLine !== ($currentLine = $file->key() + 1)) {
            $line = $file->current();
            $line = $this->escapeHtmlTags($line);
            
            yield [
                "line" => $currentLine,
                "value" => $this->highlightBrackets($line)
            ];
            $file->next();
        }
    }

    private function highlightBrackets(string $line): string
    {
        return preg_replace(["/[\[\]\(\)\:=]+/", "/\-\>/", ], '<span class="red">$0</span>', $line);
    }

    private function escapeHtmlTags(string $line): string
    {
        return strtr($line, ["<" => "&lt;", ">" => "&gt;"]);
    }

}