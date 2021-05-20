<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuestionType extends Enum
{
    const input = "input";
    const textarea = "textarea";
    const select = "select";
    const checkbox = "checkbox";
    const radio = "radio";
    const file = "file";
}
