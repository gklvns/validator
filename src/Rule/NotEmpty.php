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
final class NotEmpty extends AbstractRule
{
    public function __construct(private readonly string $message = 'This value must not be empty.') {}

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
