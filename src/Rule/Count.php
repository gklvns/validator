<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Rule;

use Gklvns\Validator\AbstractRule;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class Count extends AbstractRule
{
    public function __construct(
        private readonly ?int $min = null,
        private readonly string $minMessage = 'This value must have at least %d items.',
        private readonly ?int $max = null,
        private readonly string $maxMessage = 'This value must have at most %d items.',
    ) {}

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMinMessage(): string
    {
        return sprintf($this->minMessage, $this->min);
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function getMaxMessage(): string
    {
        return sprintf($this->maxMessage, $this->max);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'min' => $this->min,
            'minMessage' => $this->minMessage,
            'max' => $this->max,
            'maxMessage' => $this->maxMessage,
        ];
    }
}
