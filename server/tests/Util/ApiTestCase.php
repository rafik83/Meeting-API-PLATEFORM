<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Util;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase as ApiPlatformApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Api\Infrastructure\Security\SymfonyUser;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\AccountRepository;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CommunityRepository;

abstract class ApiTestCase extends ApiPlatformApiTestCase
{
    protected static Client $client;

    public function setUp(): void
    {
        self::$client = static::createClient();
    }

    protected function login(string $username): Account
    {
        $account = $this->getAccount($username);

        self::$client->getKernelBrowser()->loginUser(new SymfonyUser($account), 'main');

        return $account;
    }

    protected function getCommunity(string $name): Community
    {
        if (self::$container === null) {
            self::$client = static::createClient();
        }

        $communityRepository = self::$container->get(CommunityRepository::class);

        return $communityRepository->findOneByName($name);
    }

    protected function getAccount(string $email): Account
    {
        $accountRepository = self::$container->get(AccountRepository::class);

        return $accountRepository->findOneByEmail($email);
    }

    protected function getMember(string $email, string $communityName): Member
    {
        $managerRegistry = self::$container->get(ManagerRegistry::class);
        $memberRepository = $managerRegistry->getRepository(Member::class);
        $queryBuilder = $memberRepository->createQueryBuilder('m');
        $queryBuilder
            ->join('m.account', 'account')
            ->join('m.community', 'community')
            ->andWhere('account.email = :email')
            ->andWhere('community.name = :community')
            ->setMaxResults(1)
            ->setParameters(['email' => $email, 'community' => $communityName]);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    protected function request(string $method, string $url, ?array $body = null, array $headers = [], array $extra = [])
    {
        return self::$client->request(
            $method,
            $url,
            [
                'headers' => array_merge(
                    [
                        'content-type' => 'application/ld+json',
                    ],
                    $headers
                ),
                'extra' => $extra,
                'body' => \json_encode($body),
            ]
        );
    }

    protected function getTagId(string $name): ?int
    {
        /** @var EntityRepository<Tag> $tagRepository */
        $tagRepository = self::$container->get(ManagerRegistry::class)->getRepository(Tag::class);
        $queryBuilder = $tagRepository->createQueryBuilder('tag');
        $queryBuilder
            ->innerJoin('tag.translations', 'translation')
            ->where('translation.label = :label')
            ->andWhere('translation.locale = :locale')
            ->setParameter('label', $name)
            ->setParameter('locale', 'en');

        $tag = $queryBuilder->getQuery()->getOneOrNullResult();

        if ($tag !== null) {
            return $tag->getId();
        }

        return null;
    }
}
