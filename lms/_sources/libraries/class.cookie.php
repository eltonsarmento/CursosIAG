<?php

class Cookie {
    const Session = null;
    const OneDay = 86400;
    const SevenDays = 604800;
    const ThirtyDays = 2592000;
    const SixMonths = 15811200;
    const OneYear = 31536000;
    const Lifetime = -1; // 2030-01-01 00:00:00
    const KEY = KmF2013;

    static public function Exists($name) {
        return isset($_COOKIE[$name]);
    }

    static public function IsEmpty($name) {
        return empty($_COOKIE[$name]);
    }

    static public function Get($name, $default = FALSE) {
        if (isset($_COOKIE[$name])) {
            $value = mcrypt_decrypt(MCRYPT_BLOWFISH, Cookie::KEY, $_COOKIE[$name], MCRYPT_MODE_ECB);    
            return unserialize($value);
        } else {
            return $default;
        }
    }

    static public function Set($name, $value, $expiry = self::Session, $path = '/', $domain = false) {

        $value = serialize($value);
        $value = mcrypt_encrypt(MCRYPT_BLOWFISH, Cookie::KEY, $value, MCRYPT_MODE_ECB);

        $retval = false;
        if (!headers_sent()) {
            if ($domain === false)
                $domain = '.cursosiag.com.br';

            if ($expiry === -1)
                $expiry = 1893456000; // Lifetime = 2030-01-01 00:00:00
            elseif (is_numeric($expiry))
                $expiry += time();
            else
                $expiry = strtotime($expiry);

            //$value = serialize($value);
            $retval = @setcookie($name, $value, $expiry, $path, $domain);
            if ($retval) {
                $_COOKIE[$name] = $value;
            }
        }
        return $retval;
    }

    static public function Delete($name, $path = '/', $domain = false, $remove_from_global = false) {
        $retval = false;
        if (!headers_sent()) {
            if ($domain === false)
                $domain = '.cursosiag.com.br';
            $retval = setcookie($name, '', time() - 3600, $path, $domain);

            if ($remove_from_global)
                unset($_COOKIE[$name]);
        }
        return $retval;
    }
}

/* Exemplos de uso:
// Style preference, persists only until the browser is closed
Cookie::Set('style', 'black_and_orange', Cookie::Session);

// Remember the users email address to pre-fill the login form when they return
Cookie::Set('rememberme', 'email@domain.com', Cookie::ThirtyDays);

// Tracking cookie that effectively lasts forever
Cookie::Set('tracking', 'sdfoiwuyo8who8wfhow8fhso4', Cookie::Lifetime, '/', '.domain.com');