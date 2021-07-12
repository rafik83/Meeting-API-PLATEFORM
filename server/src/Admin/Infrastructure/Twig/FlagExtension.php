<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FlagExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('flagAsEmoji', [$this, 'getFlagEmojiByISOCode']),
        ];
    }

    public function getFlagEmojiByISOCode(string $countryCode): string
    {
        $flag = '';
        $letters = str_split($countryCode);
        foreach ($letters as $letter) {
            $flag .= mb_chr(\ord($letter) + 127_397, 'UTF-8');
        }

        return $flag;
    }
}
