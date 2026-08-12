<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests;

use Countable;
use Gklvns\Validator\AbstractRule;
use Gklvns\Validator\AbstractRuleValidator;
use Gklvns\Validator\Rule\Count;
use Gklvns\Validator\Rule\CountValidator;
use Gklvns\Validator\Rule\Length;
use Gklvns\Validator\Rule\LengthValidator;
use Gklvns\Validator\Rule\NotEmpty;
use Gklvns\Validator\Rule\NotEmptyValidator;
use Gklvns\Validator\Rule\Type;
use Gklvns\Validator\Rule\TypeValidator;
use Gklvns\Validator\Validator;
use LogicException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use stdClass;
use Stringable;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class ValidatorTest extends TestCase
{
    public function testInvalidValidatorThrowsException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessageIs(
            sprintf('Class "%s" must extend "%s".', 'TestRuleValidator', AbstractRuleValidator::class),
        );

        $testRule = new TestRule()->setValidator('TestRuleValidator');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $testRule->getValidator();
    }

    /**
     * @throws ReflectionException
     */
    public function testViolationContainsRule(): void
    {
        $violations = new Validator()->validate(null, [new TestRule()]);

        $this->assertCount(1, $violations);
        $this->assertInstanceOf(AbstractRule::class, $violations[0]->getRule());
    }

    /**
     * @throws ReflectionException
     */
    public function testRuleValidatorCached(): void
    {
        $validator = new Validator([new TestRule()]);

        $this->assertCount(1, $validator->validate(''));

        $rules = $validator->getRules();
        $ruleValidator = $validator->getRuleValidator($rules[0]);

        $this->assertCount(1, $validator->validate(''));
        $this->assertSame($ruleValidator, $validator->getRuleValidator($rules[0]));
    }

    /**
     * @throws ReflectionException
     */
    public function testNotBlankRule(): void
    {
        $validator = new Validator([new NotEmpty()]);

        $this->assertCount(1, $validator->validate(null));
        $this->assertCount(1, $validator->validate(''));

        $rules = $validator->getRules();

        $this->assertInstanceOf(NotEmptyValidator::class, $validator->getRuleValidator($rules[0]));
    }

    /**
     * @throws ReflectionException
     */
    public function testLengthRule(): void
    {
        $validator = new Validator([new Length(min: 1, max: 4)]);

        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return '12345';
            }
        };
        $violations = $validator->validate($stringable);
        $this->assertSame('This value must be at most 4 characters.', $violations[0]->getErrorMessage());

        $violations = $validator->validate('12345');
        $this->assertSame('This value must be at most 4 characters.', $violations[0]->getErrorMessage());

        $violations = $validator->validate(12345);
        $this->assertSame('This value must be at most 4 characters.', $violations[0]->getErrorMessage());

        $violations = $validator->validate(12345.5);
        $this->assertSame('This value must be at most 4 characters.', $violations[0]->getErrorMessage());

        $this->assertCount(0, $validator->validate('café'));
        $this->assertCount(0, $validator->validate('🚗'));
        $this->assertCount(0, $validator->validate('日本語'));

        $this->assertCount(0, $validator->validate('test', [new Length(min: 4)]));
        $this->assertCount(0, $validator->validate('test', [new Length(max: 4)]));
        $this->assertCount(0, $validator->validate('test', [new Length(min: 4, max: 4)]));

        $this->assertCount(1, $validator->validate('test', [new Length(min: 5)]));
        $this->assertCount(1, $validator->validate('test', [new Length(max: 3)]));

        $lengthRule = new Length(min: 1, max: 3);
        $this->assertCount(1, $validator->validate('test', [$lengthRule]));

        $this->assertInstanceOf(LengthValidator::class, $validator->getRuleValidator($lengthRule));
    }

    /**
     * @throws ReflectionException
     */
    public function testCountRule(): void
    {
        $validator = new Validator([new Count(min: 1, max: 4)]);

        $countable = new class implements Countable {
            public function count(): int
            {
                return 5;
            }
        };
        $violations = $validator->validate($countable);
        $this->assertSame('This value must have at most 4 items.', $violations[0]->getErrorMessage());

        $violations = $validator->validate([1, 2, 3, 4, 5]);
        $this->assertSame('This value must have at most 4 items.', $violations[0]->getErrorMessage());

        $violations = $validator->validate(call_user_func(static function () {
            foreach ([1, 2, 3, 4, 5] as $item) {
                yield $item;
            }
        }));
        $this->assertSame('This value must have at most 4 items.', $violations[0]->getErrorMessage());

        $this->assertCount(0, $validator->validate([1, 2, 3, 4], [new Count(min: 4)]));
        $this->assertCount(0, $validator->validate([1, 2, 3, 4], [new Count(max: 4)]));
        $this->assertCount(0, $validator->validate([1, 2, 3, 4], [new Count(min: 4, max: 4)]));

        $this->assertCount(1, $validator->validate([1, 2, 3], [new Count(min: 5)]));
        $this->assertCount(1, $validator->validate([1, 2, 3, 4, 5], [new Count(max: 3)]));

        $countRule = new Count(min: 1, max: 3);
        $this->assertCount(1, $validator->validate([1, 2, 3, 4], [$countRule]));

        $this->assertInstanceOf(CountValidator::class, $validator->getRuleValidator($countRule));
    }

    /**
     * @throws ReflectionException
     */
    public function testTypeRule(): void
    {
        $validator = new Validator([new Type('string')]);

        $this->assertCount(0, $validator->validate(''));
        $this->assertCount(0, $validator->validate(null, [new Type('null')]));
        $this->assertCount(0, $validator->validate(1, [new Type('integer')]));
        $this->assertCount(0, $validator->validate(0.5, [new Type('double')]));
        $this->assertCount(0, $validator->validate(true, [new Type('boolean')]));
        $this->assertCount(0, $validator->validate([], [new Type('array')]));
        $this->assertCount(0, $validator->validate(new stdClass(), [new Type('object')]));

        $rules = $validator->getRules();

        $this->assertInstanceOf(TypeValidator::class, $validator->getRuleValidator($rules[0]));
    }

    /**
     * @throws ReflectionException
     */
    public function testMultipleRules(): void
    {
        $notEmptyRule = new NotEmpty();
        $lengthRule = new Length(min: 1);
        $typeRule = new Type('integer');

        $violations = new Validator([$notEmptyRule, $lengthRule, $typeRule])->validate('');

        $this->assertCount(3, $violations);
        $this->assertSame(
            json_encode([
                [
                    'rule' => ['message' => 'This value must not be empty.'],
                    'value' => '',
                    'errorMessage' => 'This value must not be empty.',
                ],
                [
                    'rule' => [
                        'min' => 1,
                        'minMessage' => 'This value must be at least %d characters.',
                        'max' => null,
                        'maxMessage' => 'This value must be at most %d characters.',
                    ],
                    'value' => '',
                    'errorMessage' => 'This value must be at least 1 characters.',
                ],
                [
                    'rule' => ['type' => 'integer', 'message' => 'This value must of be of type "%s".'],
                    'value' => '',
                    'errorMessage' => 'This value must of be of type "integer".',
                ],
            ]),
            json_encode($violations),
        );
    }
}
