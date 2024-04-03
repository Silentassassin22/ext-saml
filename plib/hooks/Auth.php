<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_LdapAuth_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        return false;
    }

    public function isEnabled()
    {
        return (bool)pm_Settings::get('enable');
    }

    public function breakChainOnFailure()
    {
        return (bool)pm_Settings::get('disableNativeAuth');
    }

}
