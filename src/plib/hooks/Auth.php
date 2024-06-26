<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_OauthSso_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        \pm_Log::info("Authenticating user $login");
        //$oauth = OAuthClient::test();
        //\pm_Log::info("Data response: $oauth");
        return false;
    }

    public function isEnabled()
    {
        return true;
    }

    public function breakChainOnFailure()
    {
        return (bool)pm_Settings::get('disableNativeAuth');
    }

}
