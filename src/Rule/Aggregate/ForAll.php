<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Aggregate;


use Phypes\Error\Error;
use Phypes\Exception\InvalidAggregateRule;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class ForAll implements Rule
{
    /**
     * @var array $rules
     */
    private $rules = [];

    /**
     * ForAll constructor.
     * @param Rule ...$rules
     * @throws InvalidAggregateRule
     */
    public function __construct(Rule... $rules)
    {
        if (empty($rules))
            throw new InvalidAggregateRule("No rules specified for aggregate rule", ForAll::class);
        $this->rules = $rules;
    }

    /**
     * Validate for each rule. Works with an AND logic.
     * @param $data
     * @return Result
     */
    public function validate($data): Result
    {
        /**
         * @var Error $errors[]
         */
        $errors = [];
        foreach ($this->rules as $rule) {

            $result = $rule->validate($data);

            if (!$result->isValid()) {
                /**
                 * @var Failure $result
                 * @var Error $error
                 */
                foreach ($result->getErrors() as $error) {
                    $errors[] = $error;
                }
            }

        }

        if (!($errors))
            return new Success();
        else {
            return new Failure(...$errors); // Use the splat operator

        }
    }
}