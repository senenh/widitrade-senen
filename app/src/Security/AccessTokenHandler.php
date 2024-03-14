<?php

namespace App\Security;

use App\Service\ValidParentheses;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ValidParentheses $validParentheses
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        if (!$this->validParentheses->isValid($accessToken)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        return new UserBadge('john_admin');
    }
}
