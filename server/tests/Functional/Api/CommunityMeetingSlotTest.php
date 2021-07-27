<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Slot;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;


class CommunityMeetingSlotTest  extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testCreate(): void
    {
        $account = $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');

        $memberFrom = $this->getMember('joined@example.com', 'Space industry');

        $memberTo = $this->getMember('member@example.com', 'Space industry');
         
        $startDate =new \DateTimeImmutable('+ 1 hours');
        
        $endDate =new \DateTimeImmutable(' + 2 hours');

        $this->request(
            'POST',
            sprintf('/api/meetings'),
            [
                'participantTo' => $memberTo->getId(),
                'community' => $community->getId(),
                'message' => 'POST API Request',
                'slots' => [[
                    'startDate' => $startDate->format(\DateTimeImmutable::RFC3339_EXTENDED),               
                    'endDate'=> $endDate->format(\DateTimeImmutable::RFC3339_EXTENDED)
                           ]],
                           
            ]
        );
        self::assertResponseIsSuccessful();

        self::assertJsonContains([
             
                'participantFrom' => '/api/members/'.$memberFrom->getId(),
                'participantTo' => '/api/members/'.$memberTo->getId(),
                'message' => 'POST API Request',
                'slots' => [],
            
        ]);
     }

     public function testCreateInvalidDate(): void
     {
        $account = $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');

        $memberFrom = $this->getMember('joined@example.com', 'Space industry');

        $memberTo = $this->getMember('member@example.com', 'Space industry');
         
        $startDate =new \DateTimeImmutable('+ 3 hours');
        
        $endDate =new \DateTimeImmutable(' + 1 hours');

         $this->request(
            'POST',
            sprintf('/api/meetings'),
            [
                'participantTo' => $memberTo->getId(),
                'community' => $community->getId(),
                'message' => 'POST API Request',
                'slots' => [[
                    'startDate' => $startDate->format(\DateTimeImmutable::RFC3339_EXTENDED),               
                    'endDate'=> $endDate->format(\DateTimeImmutable::RFC3339_EXTENDED)
                           ]],
                           
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'slots[0].startDate',
                    ],
                ],
            ]
        );
     }

     public function testWithEqualDate(): void
     {
        $account = $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');

        $memberFrom = $this->getMember('joined@example.com', 'Space industry');

        $memberTo = $this->getMember('member@example.com', 'Space industry');
        
        $startDate =new \DateTimeImmutable('+ 1 hours');
        
        $endDate =new \DateTimeImmutable(' + 1 hours');

        $this->request(
            'POST',
            sprintf('/api/meetings'),
            [
                'participantTo' => $memberTo->getId(),
                'community' => $community->getId(),
                'message' => 'POST API Request',
                'slots' => [[
                    'startDate' => $startDate->format(\DateTimeImmutable::RFC3339_EXTENDED),               
                    'endDate'=> $endDate->format(\DateTimeImmutable::RFC3339_EXTENDED)
                           ]],
                           
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'slots[0].startDate',
                    ],
                ],
            ]
        );
        
     }

     public function testWithoutDate(): void
     {
        $account = $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');

        $memberFrom = $this->getMember('joined@example.com', 'Space industry');

        $memberTo = $this->getMember('member@example.com', 'Space industry');

        $this->request(
            'POST',
            sprintf('/api/meetings'),
            [
                'participantTo' => $memberTo->getId(),
                'community' => $community->getId(),
                'message' => 'POST API Request',
                'slots' => [],
                           
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'slots',
                        'message' => 'This collection should contain 1 element or more.',
                    ],
                ],
                
            ]
        );
     }
}