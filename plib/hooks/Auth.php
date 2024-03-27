<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_LdapAuth_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        $ch = curl_init();
        $protocol = "ldap://";
        $port = "1389";
        if ((bool)pm_Settings::get('ssl')) {
            $protocol = "ldaps://";
            $port = "636";
        }

        \pm_Log::info("LDAP connection test: " . $test);

        curl_setopt($ch, CURLOPT_URL, $protocol . pm_Settings::get('host') . ":" . $port . "/DC=domaingenie,DC=net?attributes?sub?(objectClass=inetorgperson)");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Force closing TLS channel after login
        if (!\pm_ProductInfo::isWindows()) {
            curl_setopt($ch, CURLOPT_CONNECT_ONLY, true);
        }
        curl_setopt($ch, CURLOPT_USERPWD, pm_Settings::get('loginPrefix') . $login . pm_Settings::get('loginSuffix') . ":" . $password);
        \pm_Log::debug('Sending a request to the LDAP server');
        $result = curl_exec($ch);
        if ($result === false) {
            \pm_Log::info('Communication with LDAP server failed: ' . curl_error($ch));
            \pm_Log::info('LDAP server response: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE));
            \pm_Log::info('LDAP server response: ' . $result);
        }
        curl_close($ch);

        return false !== $result;
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
