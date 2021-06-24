<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

abstract class Card
{
    abstract public function getId(): int;

    abstract public function getName(): string;

    abstract public function getDate(): \DateTimeImmutable;
}
