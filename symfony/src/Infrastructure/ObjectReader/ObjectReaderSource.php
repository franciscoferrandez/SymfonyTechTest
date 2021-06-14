<?php
namespace App\Infrastructure\ObjectReader;

class ObjectReaderSource implements ObjectReaderSourceInterface
{
    private $url;
    private $user;
    private $password;

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    public function getUrl():string
    {
        return $this->url;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function getUser(): string
    {
        return $this->user;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}