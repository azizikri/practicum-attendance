<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PTA()
 * @method static static ATA()
 */
final class AcademicPeriodEnum extends Enum
{
    const PTA = 'pta';
    const ATA = 'ata';
}
