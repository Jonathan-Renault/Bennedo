<?php


namespace App\Service;


use App\Entity\Admin;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminService
{
    private $validator;
    private $om;
    private $passwordEncoder;
    private $errors = [];
    private $admin;

    /**
     * AdminService constructor.
     * @param Validator $validator
     * @param ObjectManager $om
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Validator $validator, ObjectManager $om, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->validator = $validator;
        $this->om = $om;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param array $props
     * @return bool
     */
    public function create($props = [])
    {
        $login = isset($props['login']) ? $props['login'] : "";
        $password = isset($props['password']) ? $props['password'] : "";
        $passwordConfirmation = isset($props['passwordConfirmation']) ? $props['passwordConfirmation'] : "";
        $errors = [];
        if ($password != $passwordConfirmation) {
            $errors[] = "Password does not match the password confirmation.";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password should be at least 6 characters.";
        }

        if (!$errors) {
            $admin = new Admin();
            $encodedPassword = $this->passwordEncoder->encodePassword($admin, $password);
            $admin->setLogin($login);
            $admin->setPassword($encodedPassword);

            $isValid = $this->validator->validate($admin);
            if ($isValid) {
                $this->om->persist($admin);
                $this->om->flush();
                $this->admin = $admin;
                return true;
            } else {
                $errors = $this->validator->getErrors();
            }
        }
        $this->errors = $errors;

        return false;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->admin;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}