<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 8/31/18
 * Time: 1:26 AM
 */

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;

final class EmailTest extends TestCase
{

    public function test__construct()
    {
    }

    public function test__toString()
    {
    }

    public function testGetValue()
    {
        $validator = $this->getValidatorMock("email@example.com");
        $email = new Email("email@example.com", $validator);
        $this->assertEquals('email@example.com', $email->getValue());
    }

    private function getValidatorMock(string $email) : Validator
    {
        $validator = Mockery::mock(Validator::class);
        $validator->allows()->validate($email)->andReturns(true);
        return $validator;
    }
}