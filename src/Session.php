<?php

use Google\Service\Oauth2\Userinfo;

class Session 
{
    public static function setUserInfo(Userinfo $userInfo) 
    {
        $_SESSION['user_info'] = serialize($userInfo);
    }

    public static function userInfo(): ?Userinfo 
    {
        $serialized = $_SESSION['user_info'] ?? null;

        if ($serialized === null) {
            return null;
        }

        return unserialize($serialized);
    }

    public static function isUserInfoSet(): bool 
    {
        return isset($_SESSION['user_info']);
    }

    public static function setOAuthState(string $state) 
    {
        $_SESSION['state'] = $state;
    } 

    public static function oauthState(): ?string 
    {
        return $_SESSION['state'] ?? null;
    }

    public static function setAccessToken(string $accessToken) 
    {
        $_SESSION['access_token'] = $accessToken;
    }

    public static function accessToken(): ?string
    {
        return $_SESSION['access_token'] ?? null;
    }

    public static function setRefreshToken(string $refreshToken)
    {
        $_SESSION['refresh_token'] = $refreshToken;
    }

    public static function refreshToken(): ?string
    {
        return $_SESSION['refresh_token'] ?? null;
    }
}
