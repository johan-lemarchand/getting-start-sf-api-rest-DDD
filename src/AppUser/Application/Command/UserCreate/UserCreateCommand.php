<?php

namespace App\AppUser\Application\Command\UserCreate;


class UserCreateCommand
{
    /**
     * @var string 
     */
    private string $_email;

    /**
     * @var string 
     */
    private string $_password;

    /**
     * @var string 
     */
    private string $_lang;
    public function __construct(string $email, string $password, string $lang)
    {
        $this->_email = $email;
        $this->_password = $password;
        $this->_lang = $lang;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->_lang;
    }
}