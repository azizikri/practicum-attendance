<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static Assistant()
 * @method static static Student()
 */
final class UserRole extends Enum
{
    const Admin = 0;
    const Assistant = 1;
    const Student = 2;
}
