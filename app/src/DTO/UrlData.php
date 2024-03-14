<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UrlData
{
    #[Assert\Url]
    #[Assert\NotBlank]
    private string $url;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
