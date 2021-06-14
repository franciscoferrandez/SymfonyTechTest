<?php
namespace App\Infrastructure\ObjectReader;

interface ObjectReaderSourceInterface
{
    public function setUrl(string $url);
    public function getUrl(): string;

    public function setUser(string $user);
    public function getUser():string;
    
    public function setPassword(string $password);
    public function getPassword():string;
}