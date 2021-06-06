<?php

namespace App;

use Doctrine\ORM\EntityManagerInterface;

class StartDoctrineConnectionForOctane
{
    public function handle($event): void
    {
        /** @var DoctrineEntityManagerDecorator $em */
        $em = $event->sandbox
            ->get(EntityManagerInterface::class)
        ;

        $em->startConnection();
    }
}
