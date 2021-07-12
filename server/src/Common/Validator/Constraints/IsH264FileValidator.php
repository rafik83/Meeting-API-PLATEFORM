<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Validator\Constraints;

use FFMpeg\FFProbe;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsH264FileValidator extends ConstraintValidator
{
    public function __construct(
        private FFProbe $probe
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        if (!$value instanceof UploadedFile) {
            throw new UnexpectedValueException($value, UploadedFile::class);
        }

        if (!$constraint instanceof IsH264File) {
            throw new UnexpectedTypeException($constraint, IsH264File::class);
        }

        $codec = $this->probe->streams((string) $value->getRealPath())->videos()->first()?->get('codec_name');

        if ($codec === 'h264') {
            return;
        }

        $this->context
            ->buildViolation($constraint->message, ['{{ invalid }}' => $codec])
            ->setInvalidValue($codec)
            ->addViolation()
        ;
    }
}
