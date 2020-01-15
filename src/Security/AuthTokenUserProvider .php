<?php


namespace App\Security;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthTokenUserProvider implements UserProviderInterface
{

    protected $authTokenRepository;
    protected $userRepository;

    /**
     * TokenAuthenticator constructor.
     * @param EntityRepository $authTokenRepository
     * @param EntityRepository $userRepository
     */
    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;

    }

    /**
     * @param $authTokenHeader
     * @return mixed
     */
    public function getAuthToken($authTokenHeader)
    {
        return $this->authTokenRepository->findOneByValue($authTokenHeader);
    }

    /**
     * @param string $login
     * @return UserInterface
     */
    public function loadUserByUsername($login)
    {
        return $this->userRepository->findByLog($login);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface|void
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class)
    {
       return 'App\Entity\Admin' === $class;
    }
}