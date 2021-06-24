<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class CardTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCardLists(): void
    {
        $communityId = $this->getCommunity('Space industry')->getId();

        self::$client->request('GET', sprintf('/api/communities/%d/card_lists', $communityId));

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/CardList',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 4,
                'hydra:member' => [
                    [
                        'position' => 0,
                        'title' => 'Last users registered',
                    ],
                    [
                        'position' => 1,
                        'title' => 'Last company registered',
                    ],
                    [
                        'position' => 2,
                        'title' => 'Last cardTypes registered',
                    ],
                    [
                        'position' => 3,
                        'title' => 'Last published events',
                    ],
                ],
            ]
        );
    }

    public function testGetCardsMember(): void
    {
        $community = $this->getCommunity('Space industry');
        $communityId = $community->getId();

        $cardList = $community->getPublishedCardLists()->filter(
            fn (CardList $cardList) => $cardList->getTitle() === 'Last users registered'
        )->first();

        self::$client->request('GET', sprintf('/api/communities/%d/lists/%d', $communityId, $cardList->getId()));

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Card',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 2,
                'hydra:member' => [
                    [
                        '@type' => 'MemberCard',
                        'firstName' => 'Member',
                        'lastName' => 'Doe',
                        'picture' => 'http://localhost/storage/test/accountAvatar/avatar.png',
                        'companyName' => 'Proximum',
                        'mainGoal' => [
                            'name' => 'buy',
                        ],
                        'secondaryGoal' => [
                            'name' => 'sell',
                        ],
                        'goals' => [],
                        'kind' => 'member',
                    ],
                ],
            ]
        );
    }

    public function testGetCardsCompanies(): void
    {
        $community = $this->getCommunity('Space industry');
        $communityId = $community->getId();

        $cardList = $community->getPublishedCardLists()->filter(
            fn (CardList $cardList) => $cardList->getTitle() === 'Last company registered'
        )->first();

        self::$client->request('GET', sprintf('/api/communities/%d/lists/%d', $communityId, $cardList->getId()));

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Card',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 1,
                'hydra:member' => [
                    [
                        '@type' => 'CompanyCard',
                        'picture' => 'http://localhost/storage/test/companyLogos/logo.png',
                        'name' => 'Proximum',
                        'activity' => '',
                        'kind' => 'company',
                    ],
                ],
            ]
        );
    }

    public function testGetCardsEvent(): void
    {
        $community = $this->getCommunity('Space industry');
        $communityId = $community->getId();

        $cardList = $community->getPublishedCardLists()->filter(
            fn (CardList $cardList) => $cardList->getTitle() === 'Last published events'
        )->first();

        self::$client->request('GET', sprintf('/api/communities/%d/lists/%d', $communityId, $cardList->getId()));

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Card',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 1,
                'hydra:member' => [
                    [
                        '@type' => 'EventCard',
                        'picture' => 'http://localhost/storage/test/eventPictures/picture1.jpg',
                        'name' => 'Published event',
                        'eventType' => 'online',
                        'registerUrl' => 'http://localhost/register-1',
                        'findOutMoreUrl' => 'http://localhost/find-out-more-1',
                        'kind' => 'community_event',
                        'tags' => [
                            ['name' => 'Satellites'],
                            ['name' => 'Ground'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function testGetCardsMixed(): void
    {
        $community = $this->getCommunity('Space industry');
        $communityId = $community->getId();

        $cardList = $community->getPublishedCardLists()->filter(
            fn (CardList $cardList) => $cardList->getTitle() === 'Last cardTypes registered'
        )->first();

        self::$client->request('GET', sprintf('/api/communities/%d/lists/%d', $communityId, $cardList->getId()));

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Card',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 3,
                'hydra:member' => [
                    [
                        '@type' => 'MemberCard',
                        'firstName' => 'Member',
                        'lastName' => 'Doe',
                        'picture' => 'http://localhost/storage/test/accountAvatar/avatar.png',
                        'companyName' => 'Proximum',
                        'mainGoal' => [
                            'name' => 'buy',
                        ],
                        'secondaryGoal' => [
                            'name' => 'sell',
                        ],
                        'goals' => [],
                        'kind' => 'member',
                    ],
                    [
                        '@type' => 'MemberCard',
                    ],
                    [
                        '@type' => 'CompanyCard',
                        'picture' => 'http://localhost/storage/test/companyLogos/logo.png',
                        'name' => 'Proximum',
                        'activity' => '',
                        'kind' => 'company',
                    ],
                ],
            ]
        );
    }
}
