<?php declare(strict_types=1);

namespace Phypes\UnitTest\Rule\String;

use Phypes\Error\Error;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;
use Phypes\Rule\String\MaximumLength;
use PHPUnit\Framework\TestCase;

class MaximumLengthTest extends TestCase
{
    /**
     * Test if the rule implements the Rule interface
     */
    public function testImplementsRuleInterface() : void
    {
        $this->assertInstanceOf(Rule::class, new MaximumLength(10));
    }

    /**
     * Calling validate should return a AbstractResult value object
     */
    public function testValidateReturnsResult() : void
    {
        $rule = new MaximumLength(5);
        $successResult = $rule->validate('MediumText');
        $this->assertInstanceOf(Result::class, $successResult);

        $rule = new MaximumLength(5);
        $failureResult = $rule->validate('Small');
        $this->assertInstanceOf(Result::class, $failureResult);
    }

    /**
     * Check validation status on failure
     */
    public function testValidateFailureBoolean() : void
    {
        $result = $this->getFailedResult();
        $this->assertFalse($result->isValid()) ;
    }

    /**
     * Return error on failure
     */
    public function testValidateFailureErrorInstance() : void
    {
        $result = $this->getFailedResult();
        $this->assertInstanceOf(Error::class, $result->getFirstError());
    }

    /**
     * Validate the Error object values
     */
    public function testValidateFailureError()
    {
        $result = $this->getFailedResult();
        $error = $result->getFirstError();

        $this->assertEquals(RuleErrorCode::LENGTH_ERROR, $error->getCode());
        $this->assertEquals('The supplied string is too long', $error->getMessage());
    }

    /**
     * Should pass at the exact maximum value specified
     */
    public function testValidateSuccessExactValue()
    {
        $text = 'Apple';
        $rule = new MaximumLength(5);
        $result = $rule->validate($text);

        $this->assertTrue($result->isValid());
    }

    /**
     * Arbitrary length less than max limit should pass
     */
    public function testValidateSuccessBoolean()
    {
        $text = 'LongEnoughText';
        $rule = new MaximumLength(20);
        $result = $rule->validate($text);

        $this->assertTrue($result->isValid());
    }

    public function testValidateSuccessError()
    {
        $text = 'Player';
        $rule = new MaximumLength(7);
        $result = $rule->validate($text);

        $this->assertInstanceOf(Success::class, $result);
    }

    private function getFailedResult() : Result
    {
        $text = "Hello";
        $rule = new MaximumLength(3);
        return $rule->validate($text);
    }
}
