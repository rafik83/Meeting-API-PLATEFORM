<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\EditCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community;

class EditCommandhandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getName()->willReturn('name');
        $community->getLanguages()->willReturn(['fr', 'es']);
        $community->getDefaultLanguage()->willReturn('fr');
        $community->getSkillNomenclature()->willReturn(null);
        $community->getEventNomenclature()->willReturn(null);

        $command = new EditCommand($community->reveal());
        $command->languages = ['fr', 'en', 'es'];

        $community
            ->update('name', 'fr', ['fr', 'en', 'es'], null, null)
            ->shouldBeCalledOnce()
        ;

        $handler = new EditCommandHandler();
        $handler($command);
    }
}
