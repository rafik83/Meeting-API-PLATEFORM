<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Media;

use Proximum\Vimeet365\Admin\Application\Dto\CommunityMedia\TranslationDto;
use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Common\Validator\Constraints\IsH264File;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @var TranslationDto[]
     *
     * @Assert\Valid()
     */
    public array $translations = [];

    /**
     * @Assert\NotNull
     */
    public ?Community\Media\MediaType $mediaType;

    /**
     * @var Tag[]
     *
     * @Assert\All(
     *     @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="community.skillNomenclature")
     * )
     */
    public array $tags = [];

    /**
     * @Assert\Sequentially(
     *     @Assert\File(mimeTypes="video/mp4", maxSize="100M"),
     *     @IsH264File()
     * )
     */
    public ?UploadedFile $video = null;

    public bool $published = false;

    public function __construct(private Community $community)
    {
        foreach ($this->community->getLanguages() as $language) {
            $this->translations[$language] = new TranslationDto($language);
        }
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }
}
