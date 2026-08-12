<?php

declare(strict_types=1);

namespace Gklvns\Validator\Rule;

use Gklvns\Validator\AbstractRule;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class Type extends AbstractRule
{
    /**
     * @param 'string'|'integer'|'double'|'boolean'|'array'|'object'|'null' $type
     * @param string                                                        $message
     */
    public function __construct(
        private readonly string $type,
        private readonly string $message = 'This value must of be of type "%s".',
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return sprintf($this->message, $this->type);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
        ];
    }
}
