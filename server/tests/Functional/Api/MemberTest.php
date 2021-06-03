<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class MemberTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testJoin(): void
    {
        $this->login('user@example.com');

        $communityId = $this->getCommunity('Space industry')->getId();

        $this->request('POST', '/api/members', ['community' => $communityId]);

        self::assertResponseStatusCodeSame(201);

        self::assertJsonContains([
            '@type' => 'Member',
        ]);
    }

    public function testJoinAlreadyJoin(): void
    {
        $this->login('member@example.com');
        $communityId = $this->getCommunity('Space industry')->getId();

        $this->request('POST', '/api/members', ['community' => $communityId]);

        self::assertResponseStatusCodeSame(201);

        self::assertJsonContains([
            '@type' => 'Member',
        ]);
    }
}
