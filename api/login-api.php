<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dn  = 'ou=People, DC=stuba, DC=sk';

// connect to ldap server
$ldapconn = ldap_connect("ldap.stuba.sk")
    or die("Could not connect to LDAP server.");

$set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

$idecko = 97741;

if ($ldapconn) {
    $results=ldap_search($ldapconn,$dn,'surname=Žáková',array("givenname","employeetype","surname","mail","faculty","cn","uisid","uid"),0,8);
    $info=ldap_get_entries($ldapconn,$results);
    //var_dump($info);
    
    $i=0;
    while ($i <= 10) {
        echo $info[$i]['cn'][0]."<br>";
        echo $info[$i]['givenname'][0]."<br>";
        echo $info[$i]['sn'][0]."<br>";
        echo $info[$i]['mail'][0]."<br>";
        echo $info[$i]['employeetype'][0]."<br>";
        echo $info[$i]['uisid'][0]."<br>";     
        echo $info[$i]['uid'][0]."<br>";
        echo $info[$i]['faculty'][0]."<br><br>";
        $i++; 
    }
    
}
    
ldap_unbind($ldapconn);
?>





