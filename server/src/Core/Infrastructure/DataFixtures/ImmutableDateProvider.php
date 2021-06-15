<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\DataFixtures;

use Faker\Provider\DateTime;

class ImmutableDateProvider extends DateTime
{
    public static function immutableDateTimeBetween(
        \DateTime | string $startDate = '-30 years',
        \DateTime | string $endDate = 'now',
        ?string $timezone = null
    ): \DateTimeImmutable {
        return \DateTimeImmutable::createFromMutable(self::dateTimeBetween($startDate, $endDate, $timezone));
    }
}
