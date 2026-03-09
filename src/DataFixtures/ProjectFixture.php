<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $project = new Project();
        $project->setTitle('Portfolio Website');
        $project->setSlug('portfolio-website');
        $project->setDescription('Proyecto personal desarrollado con Symfony.');
        $project->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($project);

        $manager->flush();
    }
}