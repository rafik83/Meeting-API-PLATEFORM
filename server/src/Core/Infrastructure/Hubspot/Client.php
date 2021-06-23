<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Hubspot;

use HubSpot\Client\Crm\Companies;
use HubSpot\Client\Crm\Contacts;
use HubSpot\Crm\ObjectType;
use HubSpot\Discovery\Discovery;
use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Contact;

class Client implements ClientInterface
{
    private const CONTACT_PROPERTIES = ['email', 'firstname', 'lastname'];
    private const COMPANIES_PROPERTIES = ['name', 'country', 'website', 'domain', 'description'];

    private Discovery $client;

    public function __construct(Discovery $client)
    {
        $this->client = $client;
    }

    public function findContact(string $email): ?Contact
    {
        $input = new Contacts\Model\PublicObjectSearchRequest([
            'filter_groups' => [
                new Contacts\Model\FilterGroup([
                    'filters' => [
                        new Contacts\Model\Filter(['property_name' => 'email', 'operator' => 'EQ', 'value' => $email]),
                    ],
                ]),
            ],
            'limit' => 1,
            'properties' => self::CONTACT_PROPERTIES,
        ]);

        $response = $this->client->crm()->contacts()->searchApi()->doSearch($input);

        if ($response instanceof Contacts\Model\Error) {
            throw new Contacts\ApiException($response->getMessage());
        }

        /** @var Contacts\Model\SimplePublicObject|null $result */
        $result = $response->getResults()[0] ?? null;

        if ($result === null) {
            return null;
        }

        return new Contact(
            $result->getId(),
            array_filter(
                (array) $result->getProperties(),
                static fn ($key) => \in_array($key, self::CONTACT_PROPERTIES, true),
                ARRAY_FILTER_USE_KEY
            )
        );
    }

    public function createContact(Contact $contact): Contact
    {
        $result = $this->client->crm()->contacts()->basicApi()->create(
            new Contacts\Model\SimplePublicObjectInput(['properties' => $contact->properties])
        );

        if ($result instanceof Contacts\Model\Error) {
            throw new Contacts\ApiException($result->getMessage());
        }

        $contact->id = $result->getId();
        $contact->properties = array_merge($contact->properties, array_filter(
            (array) $result->getProperties(),
            static fn ($key) => \in_array($key, self::CONTACT_PROPERTIES, true),
            ARRAY_FILTER_USE_KEY
        ));

        return $contact;
    }

    public function getContactCompanyId(string $id): ?string
    {
        $result = $this->client->crm()->contacts()->associationsApi()->getAll($id, ObjectType::COMPANIES);

        if ($result instanceof Contacts\Model\Error) {
            throw new Contacts\ApiException($result->getMessage());
        }

        $result = $result->getResults()[0] ?? null;

        if ($result === null) {
            return null;
        }

        return $result->getId();
    }

    public function findCompany(string $id): ?Company
    {
        try {
            $result = $this->client->crm()->companies()->basicApi()->getById($id, self::COMPANIES_PROPERTIES);

            if ($result instanceof Companies\Model\Error) {
                throw new Companies\ApiException($result->getMessage());
            }

            return new Company(
                $result->getId(),
                array_filter(
                    (array) $result->getProperties(),
                    static fn ($key) => \in_array($key, self::COMPANIES_PROPERTIES, true),
                    ARRAY_FILTER_USE_KEY
                )
            );
        } catch (Companies\ApiException $apiException) {
            if (404 === $apiException->getCode()) {
                return null;
            }

            throw $apiException;
        }
    }

    /**
     * @return Company[]
     */
    public function findCompaniesByDomain(string $domain, int $limit = 10): array
    {
        $input = new Companies\Model\PublicObjectSearchRequest([
            'filter_groups' => [
                new Companies\Model\FilterGroup([
                    'filters' => [
                        new Companies\Model\Filter(['property_name' => 'domain', 'operator' => 'CONTAINS_TOKEN', 'value' => $domain]),
                    ],
                ]),
            ],
            'limit' => min($limit, 100),
            'properties' => self::COMPANIES_PROPERTIES,
        ]);

        $response = $this->client->crm()->companies()->searchApi()->doSearch($input);

        if ($response instanceof Companies\Model\Error) {
            throw new Companies\ApiException($response->getMessage());
        }

        return array_map(
            static fn (Companies\Model\SimplePublicObject $company) => new Company(
                $company->getId(),
                array_filter(
                    (array) $company->getProperties(),
                    static fn ($key) => \in_array($key, self::COMPANIES_PROPERTIES, true),
                    ARRAY_FILTER_USE_KEY
                )
            ),
            $response->getResults()
        );
    }

    public function linkContactAndCompany(string $contactId, string $companyId): void
    {
        $this->client->crm()->contacts()->associationsApi()->create(
            $contactId,
            ObjectType::COMPANIES,
            $companyId,
            'contact_to_company'
        );
    }

    public function createCompany(Company $company): Company
    {
        $result = $this->client->crm()->companies()->basicApi()->create(
            new Companies\Model\SimplePublicObjectInput(['properties' => $company->properties])
        );

        if ($result instanceof Companies\Model\Error) {
            throw new Companies\ApiException($result->getMessage());
        }

        $company->id = $result->getId();
        $company->properties = array_filter(
            (array) $result->getProperties(),
            static fn ($key) => \in_array($key, self::COMPANIES_PROPERTIES, true),
            ARRAY_FILTER_USE_KEY
        );

        return $company;
    }
}
