<?php

class Account
{
    //Registrierung
    private int $id;
    private string $email;
    private string $password;
    private bool $activated = false;

    public function __construct($id, $email, $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function update(string $email, string $password, bool $activated)
    {
        if (isset($email)) {
            $this->setEmail($email);
        }

        if (isset($password)) {
            $this->setPassword($password);
        }

        if (isset($activated)) {
            $this->setActivated($activated);
        }
    }

    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getActivated(): bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): void
    {
        $this->activated = $activated;
    }

    /**
     * @throws Exception
     */
    public static function generateRandomString(int $length): string
    {
        $bytes = random_bytes($length);
        $chars = strtr(base64_encode($bytes), '+/', '-_');
        return substr($chars, 0, $length);
    }
}