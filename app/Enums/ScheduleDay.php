<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Monday()
 * @method static static Tuesday()
 * @method static static Wednesday()
 * @method static static Thursday()
 * @method static static Friday()
 * @method static static Saturday()
 */
final class ScheduleDay extends Enum
{
    const Monday = 'Monday';
    const Tuesday = 'Tuesday';
    const Wednesday = 'Wednesday';
    const Thursday= 'Thursday';
    const Friday = 'Friday';
    const Saturday = 'Saturday';
}
