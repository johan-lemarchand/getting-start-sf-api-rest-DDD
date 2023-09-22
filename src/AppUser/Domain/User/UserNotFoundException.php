<?php

namespace App\AppUser\Domain\User;


use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserNotFoundException extends BadCredentialsException
{
} // UserNotFoundException