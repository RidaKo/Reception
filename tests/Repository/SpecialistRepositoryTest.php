<?php

namespace App\Tests\Repository;

use App\Entity\Specialist;
use App\Repository\SpecialistRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialistRepositoryTest extends KernelTestCase
{
    public function testFindIfSpecialistIsAuthorizedWhenAuthorized(): void
    {
        $kernel = self::bootKernel();

        //$this->assertSame('test', $kernel->getEnvironment());
        $entitymanagerinterface = static::getContainer()->get(EntityManagerInterface::class);
        $repo = static::getContainer()->get(SpecialistRepository::class);
        $specialist = new Specialist();
        $specialist->setPassword('password');
        $specialist->setEmail('email');
        $specialist->setSecretKey('key');
        $entitymanagerinterface->persist($specialist);
        $entitymanagerinterface->flush();


        $this->assertTrue($repo->findIfSpecialistIsAuthorized('key'));
    }
}
