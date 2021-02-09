<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member;

use Proximum\Vimeet365\Application\Command\Member\SetCommunityTagCommand;
use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\ConstraintValidator;

class CommunityStepConfigurationMatchValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof SetCommunityTagCommand) {
            throw new \RuntimeException(sprintf('This validator must be called with %s value', SetCommunityTagCommand::class));
        }

        if (!$constraint instanceof CommunityStepConfigurationMatch) {
            throw new \RuntimeException(sprintf('This validator must be called with %s constraint', CommunityStepConfigurationMatch::class));
        }

        $community = $value->getMember()->getCommunity();

        /** @var Step|false $step */
        $step = $community->getSteps()->filter(fn (Step $step): bool => $step->getId() === $value->step)->first();

        if ($step === false) {
            throw new \RuntimeException(sprintf('This validator must be called after %s', CommunityStepExist::class));
        }

        $this->validateTagsCount($value, $step);
        $this->validateTags($value, $step, $constraint);
    }

    private function validateTagsCount(SetCommunityTagCommand $value, Step $step): void
    {
        $context = $this->context;
        $validator = $context->getValidator()->inContext($context);

        $exactly = $step->getMin() === $step->getMax() ? $step->getMin() : null;
        $min = $exactly === null ? $step->getMin() : null;
        $max = $exactly === null ? $step->getMax() : null;

        $validator->atPath('tags')->validate($value->tags, new Count($exactly, $min, $max));
    }

    private function validateTags(SetCommunityTagCommand $value, Step $step, CommunityStepConfigurationMatch $constraint): void
    {
        $existingTagsId = $step->getNomenclature()->getTags()->map(
            fn (NomenclatureTag $nomenclatureTag): int => (int) $nomenclatureTag->getTag()->getId()
        )->getValues();

        $tagIds = array_map(static fn (TagDto $tagDto): int => $tagDto->id, $value->tags);

        $invalidTags = array_diff($tagIds, $existingTagsId);

        if (\count($invalidTags) === 0) {
            return;
        }

        $this->context->buildViolation($constraint->unknownTagsMessage)
            ->setInvalidValue(implode(', ', $invalidTags))
            ->setParameter('{{ value }}', implode(', ', $invalidTags))
            ->setCode(CommunityStepConfigurationMatch::UNKNOWN_TAG_ERROR)
            ->atPath('tags')
            ->addViolation();
    }
}
