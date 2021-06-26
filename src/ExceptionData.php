<?php

namespace SunnyFlail\ExceptionHandler;

class ExceptionData
{

    /**
     * @var string $TEMPLATE_FILE Path to ExceptionData template
     */
    public static $TEMPLATE_FILE = __DIR__ . "/Assets/ExceptionTemplate.html.php";

    /**
     * @var string $INPUT_ID_PREFIX Prefix to be put before html id
     */
    public static $INPUT_ID_PREFIX = "exception-";

    private int $index;
    private string $name;
    private string $namespace;
    private string $message;
    /**
     * @var TraceBlock[] $stackTrace
     */
    private array $stackTrace;
    private ?string $parentName;
    
    public function __construct(
        int $index,
        string $name,
        string $namespace,
        string $message,
        array $stackTrace,
        ?string $parentName 
    ) {
        $this->index = $index;
        $this->name = $name;
        $this->namespace = $namespace;
        $this->message = $message;
        $this->stackTrace = $stackTrace;
        $this->parentName = $parentName;
    }

    /**
     * Creates a html id string with set prefix and provided index
     * 
     * @return string
     */
    public static function prepareId($index): string
    {
        return self::$INPUT_ID_PREFIX . $index;
    }

    /**
     * Returns the index of exception
     * 
     * @return string
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * Returns the html id of exception
     * 
     * @return string
     */
    public function getId(): string
    {
        return self::prepareId($this->index);
    }

    /**
     * Returns the name of exception
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the message of exception
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * Returns the name of parent exception (if this exception extends another)
     * 
     * @return null|string
     */
    public function getParentName(): ?string
    {
        return $this->parentName;
    }

    /**
     * Returns the namespace of exception
     * 
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Returns the exception stacktrace
     * 
     * @return TraceBlock[]
     */
    public function getStacktrace(): array
    {
        return $this->stackTrace;
    }

}