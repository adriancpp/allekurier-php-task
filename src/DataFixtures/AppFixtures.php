<?php

namespace App\DataFixtures;

use App\Core\Invoice\Domain\Invoice;
use App\Core\User\Domain\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $activeUser1 = new User('active1@example.com');
        $activeUser1->setActive(true);

        $activeUser2 = new User('active2@example.com');
        $activeUser2->setActive(true);

        $inactiveUser = new User('inactive@example.com');
        $inactiveUser->setActive(false);

        $manager->persist($activeUser1);
        $manager->persist($activeUser2);
        $manager->persist($inactiveUser);

        $invoices = [
            new Invoice($activeUser1, 10000),
            new Invoice($activeUser1, 5000),
            new Invoice($activeUser2, 20000),
            new Invoice($activeUser2, 15000),
            new Invoice($activeUser1, 7000),
            new Invoice($inactiveUser, 12000),
            new Invoice($activeUser1, 3000),
            new Invoice($activeUser2, 8000),
        ];

        $invoices[3]->cancel();
        $invoices[7]->cancel();

        foreach ($invoices as $invoice) {
            $manager->persist($invoice);
        }

        $manager->flush();
    }
}
