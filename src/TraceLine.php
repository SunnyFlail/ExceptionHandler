<?php

namespace SunnyFlail\ExceptionHandler;

class TraceLine
{

    /**
     * @var static $TEMPLATE_FILE Path to TraceLine template
     */
    public static $TEMPLATE_FILE = __DIR__ . "/Assets/TraceLineTemplate.html.php";

    /**
     * @var string $INPUT_ID_PREFIX Prefix to be put before html id
     */
    public static $INPUT_ID_PREFIX = "_line-";

    /**
     * @var int $traceIndex Index of trace block
     */
    private int $traceIndex;
    
    /**
     * @var int $exceptionIndex Index of exception to which this trackblock relates to
     */
    private int $exceptionIndex;

    /**
     * @var int $traceIndex Index of line block
     */
    private int $index;

    /**
     * @var string $contents Contents of line
     */
    private string $contents;

    /**
     * @var bool $highlighted Determines whether this line needs to be highlighted
     */
    private bool $highlighted;

    public function __construct(
        int $index,
        int $traceIndex,
        int $exceptionIndex,
        string $contents,
        bool $highlighted
    ) {
        $this->index = $index;
        $this->traceIndex = $traceIndex;
        $this->exceptionIndex = $exceptionIndex;
        $this->contents = $contents;
        $this->highlighted = $highlighted;
    }

    public static function prepareId(int $lineIndex, int $traceIndex, int $exceptionIndex): string
    {
        return TraceBlock::prepareId($exceptionIndex, $traceIndex) . self::$INPUT_ID_PREFIX . $traceIndex;
    }

    public function getId(): string
    {
        return self::prepareId($this->index, $this->traceIndex, $this->exceptionIndex);
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function isHighlighted(): bool
    {
        return $this->highlighted;
    }

}