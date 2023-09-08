<?php

namespace App\Factory;

use App\Entity\Specialist;
use App\Repository\SpecialistRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Specialist>
 *
 * @method        Specialist|Proxy create(array|callable $attributes = [])
 * @method static Specialist|Proxy createOne(array $attributes = [])
 * @method static Specialist|Proxy find(object|array|mixed $criteria)
 * @method static Specialist|Proxy findOrCreate(array $attributes)
 * @method static Specialist|Proxy first(string $sortedField = 'id')
 * @method static Specialist|Proxy last(string $sortedField = 'id')
 * @method static Specialist|Proxy random(array $attributes = [])
 * @method static Specialist|Proxy randomOrCreate(array $attributes = [])
 * @method static SpecialistRepository|RepositoryProxy repository()
 * @method static Specialist[]|Proxy[] all()
 * @method static Specialist[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Specialist[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Specialist[]|Proxy[] findBy(array $attributes)
 * @method static Specialist[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Specialist[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class SpecialistFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        parent::__construct();
        $this->passwordHasher = $userPasswordHasherInterface;

    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'roles' => [],
            'secretKey' => self::faker()->regexify('[A-Z0-9]{10}'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Specialist $specialist): void {
                $specialist->setPassword($this->passwordHasher->hashPassword($specialist,'pass'));
        })
        ;
    }

    protected static function getClass(): string
    {
        return Specialist::class;
    }
}
