<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $passwordHasher;
    
    public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function saveUser($name, $username, $password, $roles)
    {
        $user = new User();

        $user
            ->setName($name)
            ->setUsername($username)
            ->setPassword($this->generateHashedPassword($user, $password))
            ->setRoles($roles);


        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function updateUser(User $user): User
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    public function removeUser(User $user)
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    public function generateHashedPassword(User $user, string $password)
    {
        return $this->passwordHasher->hashPassword(
            $user,
            $password
        );
    }
}
