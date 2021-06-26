<?php

namespace SunnyFlail\ExceptionHandler;

use SplFileObject;

class TraceBlock
{

    /**
     * @var static $TEMPLATE_FILE Path to TraceBlock template
     */
    public static $TEMPLATE_FILE = __DIR__ . "/Assets/TraceTemplate.html.php";
    /**
     * @var static $INCORRECT_TEMPLATE_FILE Path to template for Incorrect lines
     */
    public static $INCORRECT_TEMPLATE_FILE = __DIR__ . "/Assets/IncorrectLineTemplate.html.php";

    /**
     * @var string $INPUT_ID_PREFIX Prefix to be put before html id
     */
    public static $INPUT_ID_PREFIX = "_trace-";

    /**
     * @var int $index Index of trace block
     */
    private int $index;
    
    /**
     * @var int $exceptionIndex Index of exception to which this trackblock relates to
     */
    private int $exceptionIndex;

    /** 
     * @var int EDGE_LINES Number of lines to be shown before and after the line on which the error occured
     */
    public static $EDGE_LINES = 5;
    private bool $valid;

    public function __construct(
        int $index,
        int $exceptionIndex,
        ?string $function,
        ?string $className,
        ?string $namespace,
        ?string $filePath,
        ?string $fileName,
        ?string $file,
        ?int $line,
        ?string $type
    ) {
        $this->valid = false;
        $this->function = $function;
        $this->className = $className;
        $this->namespace = $namespace;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->file = $file;
        $this->line = $line;
        $this->type = $type;
        $this->index = $index;
        $this->exceptionIndex = $exceptionIndex;
    }

    /**
     * Creates a html id string with set prefix and provided indexes
     * 
     * @return string
     */
    public static function prepareId($index, $exceptionIndex): string
    {
        return ExceptionData::prepareId($exceptionIndex) . self::$INPUT_ID_PREFIX . $index;
    }

    public function render()
    {
        require __DIR__."/Assets/TraceTemplate.html.php";
    }
    
    public function getIndex(): int
    {
        return $this->index; 
    }

    public function getId(): string
    {
        return self::prepareId($this->exceptionIndex, $this->index);
    }

    public function getLineId(): ?string
    {
        if (null === $this->line) {
            return null;
        }
        return TraceLine::prepareId($this->line, $this->index, $this->exceptionIndex);
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
    
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getLine(): ?int
    {
        return $this->line;
    }
    
    public function getClassName(): ?string
    {
        return $this->className;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getLines()
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

        $this->valid = true;

        $file = new SplFileObject($path);
        $file->seek($startLine);

        while ($file->valid() && $endLine !== ($currentLine = $file->key() + 1)) {
            $line = $file->current();
            $line = $this->escapeHtmlTags($line);
            
            yield new TraceLine(
                $currentLine,
                $this->index,
                $this->exceptionIndex,
                $this->highlightBrackets($line),
                $currentLine === $this->line
            );

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