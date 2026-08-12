<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator;

use ReflectionClass;
use ReflectionException;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array<AbstractRuleValidator<object>>
     */
    private array $ruleValidators = [];

    /**
     * @param AbstractRule[] $rules
     */
    public function __construct(private readonly array $rules = []) {}

    /**
     * @return AbstractRule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param AbstractRule[]|null $rules
     *
     * @throws ReflectionException
     */
    public function validate(mixed $value, ?array $rules = null): array
    {
        $rules ??= $this->rules;

        $violations = [];

        foreach ($rules as $rule) {
            if ($message = $this->getRuleValidator($rule)->validate($value, $rule)) {
                $violations[] = new Violation($rule, $value, $message);
            }
        }

        return $violations;
    }

    /**
     * @param AbstractRule $rule
     *
     * @return AbstractRuleValidator<object>
     *
     * @throws ReflectionException
     */
    public function getRuleValidator(AbstractRule $rule): AbstractRuleValidator
    {
        $this->ruleValidators[$rule::class] ??= new ReflectionClass($rule->getValidator())->newInstance();

        return $this->ruleValidators[$rule::class];
    }
}
