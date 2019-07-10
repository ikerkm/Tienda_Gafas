<?php

namespace CoreBundle\Resources;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Hash Password Listener.
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 */
class passEncoder implements UserPasswordEncoderInterface
{
    public $var;


    public function __construct($mail, $plainPassword)
    {
        return  $this->var = encodePassword($mail, $plainPassword);
        // $this->passwordEncoder = $passwordEncoder;
    }


    public function getPasswordEncoder()
    {
        // return $this->passwordEncoder;
    }

    /**
     * Encode password.
     *
     * @param Player $entity
     */
    private function encodePassword(Player $entity)
    {
        if (!$entity->getPlainPassword()) {
            return;
        }
        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        );
        $entity->setPassword($encoded);
    }
}
