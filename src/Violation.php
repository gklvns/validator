<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator;

use JsonSerializable;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final readonly class Violation implements JsonSerializable
{
    public function __construct(
        private AbstractRule $rule,
        private mixed $value,
        private ?string $errorMessage = null,
    ) {}

    public function getRule(): AbstractRule
    {
        return $this->rule;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'rule' => $this->rule->jsonSerialize(),
            'value' => $this->value,
            'errorMessage' => $this->errorMessage,
        ];
    }
}
