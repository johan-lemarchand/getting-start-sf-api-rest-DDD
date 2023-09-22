<?php

namespace App\Tests\Factory\User;

use App\AppUser\Domain\User\User;
use App\AppUser\Infrastructure\Doctrine\User\UserDoctrineRepository;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        User|Proxy create(array|callable $attributes = [])
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User|Proxy find(object|array|mixed $criteria)
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy first(string $sortedField = 'id')
 * @method static User|Proxy last(string $sortedField = 'id')
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static UserDoctrineRepository|RepositoryProxy repository()
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 * @capstan-method        Proxy<User> create(array|callable $attributes = [])
 * @capstan-method static Proxy<User> createOne(array $attributes = [])
 * @capstan-method static Proxy<User> find(object|array|mixed $criteria)
 * @capstan-method static Proxy<User> findOrCreate(array $attributes)
 * @capstan-method static Proxy<User> first(string $sortedField = 'id')
 * @capstan-method static Proxy<User> last(string $sortedField = 'id')
 * @capstan-method static Proxy<User> random(array $attributes = [])
 * @capstan-method static Proxy<User> randomOrCreate(array $attributes = [])
 * @capstan-method static RepositoryProxy<User> repository()
 * @capstan-method static list<Proxy<User>> all()
 * @capstan-method static list<Proxy<User>> createMany(int $number, array|callable $attributes = [])
 * @capstan-method static list<Proxy<User>> createSequence(iterable|callable $sequence)
 * @capstan-method static list<Proxy<User>> findBy(array $attributes)
 * @capstan-method static list<Proxy<User>> randomRange(int $min, int $max, array $attributes = [])
 * @capstan-method static list<Proxy<User>> randomSet(int $number, array $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            '_email' => self::faker()->email(),
            '_lang' => 'fr',
            '_password' => self::faker()->password(),
            '_roles' => ['ROLE_USER_CONNECTED', 'ROLE_USER'],
            '_uuid' => Uuid::v4(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }

    public static function getFake(UserPasswordHasher $hasher = null): \stdClass
    {
        $faker = Factory::create('fr_FR');
        $user = User::create(
            $id = 0,
            $email = $faker->email(),
            $roles = array('ROLE_USER_CONNECTED', 'ROLE_USER'),
            $password = $faker->password(),
            $uuid = Uuid::v4(),
            $lang = 'fr'
        );
        if ($hasher) {
            $hashedPassword = $hasher->hashPassword(
                $user,
                $password
            );
            $user->setPassword($hashedPassword);
        }

        $stClass=  new \stdClass();
        $stClass->user = $user;
        $stClass->id = $id;
        $stClass->email = $email;
        $stClass->roles = $roles;
        $stClass->password = $password;
        $stClass->uuid = $uuid->toRfc4122();
        $stClass->lang = $lang;

        return $stClass;
    }
}
