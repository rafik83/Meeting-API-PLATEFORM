<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Company;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class CompanyContext implements Context
{
    public function __construct(private EntityManagerInterface $doctrine)
    {
    }

    /**
     * @Given those company are created
     */
    public function createCompanies(TableNode $companies)
    {
        foreach ($companies as $company) {
            $company = new Company($company['name'], $company['countryCode'], $company['website'], $company['activity']);

            $this->doctrine->persist($company);
        }

        $this->doctrine->flush();
    }
}
