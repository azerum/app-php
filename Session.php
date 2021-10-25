<?php

use Google\Service\Oauth2\Resource\Userinfo;

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
}
