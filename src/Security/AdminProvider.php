<?php


namespace App\Security;


use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AdminProvider implements UserProviderInterface
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Client $client, Serializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;

    }

    /**
     * @param string $username
     * @return User|UserInterface
     */
    public function loadUserByUsername(string $username)
    {
        $url = 'localhost:8000/auth?access_token=' . $username;
        $response = $this->client->get($url);
        $res = $response->getBody()->getContents();
        $userData = $this->serializer->deserialize($res, 'array', 'json');

        if (!$userData) {
            throw new \LogicException('Did not managed to get your administrator info from bennedo.com');
        }
        return new User($userData['login'], $userData['role']);

    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException();
        }
        return $user;
    }

    /**
     * @param string $class
     * @return bool
     */

    public function supportsClass(string $class)
    {
        return 'Entity\Admin' === $class;
    }
}