<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ScheduleShift extends Enum
{
    const Zero = 0;
    const First = 1;
    const Second = 2;
    const Third = 3;
    const Fourth = 4;
    const Fifth = 5;

}
