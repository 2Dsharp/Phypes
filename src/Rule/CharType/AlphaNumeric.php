<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\CharType;

use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Primitive\StringType;
use Phypes\Rule\Rule;

class AlphaNumeric extends CharType implements Rule
{
    // TODO: Add AlphaNumeric test

    public function validate($data): Result
    {
        $result = (new StringType())->validate($data);

        if (!$result->isValid())
            return new $result;

        if (ctype_alnum(str_replace($this->allowedSpecialChars, '', $data)))
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::NOT_ALNUM, 'String is not Alphanumeric.'));
    }
}