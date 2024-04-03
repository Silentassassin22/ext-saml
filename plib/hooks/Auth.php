<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_LdapAuth_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        \pm_Log::info("Authenticating user $login");
        \pm_Log::error("Authenticating user $login");
        \pm_Log::debug("Authenticating user $login");
        return true;
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
