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
    const Admin = 'admin';
    const Assistant = 'assitant';
    const Student = 'student';
}
