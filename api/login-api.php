<?php
session_start();
ob_start();

/*
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
$dn  = 'ou=People, DC=stuba, DC=sk';

// connect to ldap server
$ldapconn = ldap_connect("ldap.stuba.sk")
    or die("Could not connect to LDAP server.");

$set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

$ldapuid = $_POST['name'];
$ldappass = $_POST['password'];

if ($ldapconn) {

    $ldaprdn = "uid=$ldapuid, $dn";

    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
    // verify binding
    if ($ldapbind) {
      $results = ldap_search($ldapconn, $dn, 'uid='.$ldapuid.'', array("givenname", "employeetype", "surname", "mail", "faculty", "cn", "uisid", "uid"), 0, 8);
      $info = ldap_get_entries($ldapconn, $results);
      //var_dump($info);

  /*
      echo "<br>" . $info[0]['cn'][0] . "<br>"; //cele meno
      echo $info[0]['givenname'][0] . "<br>";
      echo $info[0]['sn'][0] . "<br>";
      echo $info[0]['mail'][0] . "<br>";
      echo $info[0]['employeetype'][0] . "<br>"; //student 
      echo $info[0]['uisid'][0] . "<br>"; //id
      echo $info[0]['uid'][0] . "<br>"; //username

*/
      $_SESSION['login'] = 'true';
      $_SESSION['full_name'] = $info[0]['cn'][0];
      $_SESSION['name'] = $info[0]['givenname'][0]." ".$info[0]['sn'][0];
      $_SESSION['type'] = $info[0]['employeetype'][0];
      $_SESSION['id'] = $info[0]['uisid'][0];
      $_SESSION['language'] = "slovak";

      //echo "LDAP bind successful...";

      ldap_unbind($ldapconn);
      //header("Location: /new/ide/ui/index.php");
      //die(); 
      //echo("good but TODO lol");
      if(isset($_POST['adminRole'])){
        $_SESSION['type'] = "staff";
        //echo("log as teacher");
      }

      if (strcmp($info[0]['employeetype'][0],'student')==0){

        require('students/index.php');

        insertStudentDB($info[0]['mail'][0],$info[0]['uisid'][0],$info[0]['givenname'][0],$info[0]['sn'][0]); 
      }

    }else {
        header("Location:/loginPage/index.php?msg=Zadané meno alebo heslo nie je správne!");
        die();
      }

      header("Location:/api/roleCheck.php");
      die();
}
ob_flush();
    
?>





