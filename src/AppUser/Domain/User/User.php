<?php

namespace App\AppUser\Domain\User;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;


class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?int $_id = null;
    private ?string $_email;
    private array $_roles = [];
    private string $_password;
    private string $_uuid;
    private string $_lang;
    private function __construct(
        int $id,
        string $email,
        array $roles,
        string $password,
        string $uuid,
        string $lang
    ) {
        $this->_id = $id;
        $this->_roles = $roles;
        $this->_email = $email;
        $this->_password = $password;
        $this->_uuid = $uuid;
        $this->_lang = $lang;
    }

    public static function create(
        int $id,
        string $email,
        array $roles,
        string $password,
        string $uuid,
        string $lang
    ): self {
        return new self($id, $email, $roles, $password, $uuid, $lang);
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->_lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->_lang = $lang;
    }

    public function getUuid(): string
    {
        return $this->_uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->_uuid = $uuid;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->_id;
    }

    public function getEmail(): ?string
    {
        return $this->_email;
    }

    public function setEmail(string $email): self
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username,
     * an email address, etc.)
     *
     * @see    UserInterface
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->_email;
    }

    /**
     * @see    UserInterface
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->_roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->_roles = $roles;

        return $this;
    }

    /**
     * @see    PasswordAuthenticatedUserInterface
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    public function setPassword(string $password): self
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @return string|null
     * @see    UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see    UserInterface
     * @return void
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
