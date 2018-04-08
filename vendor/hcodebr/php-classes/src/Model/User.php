<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model
{
    const SESSION ="User";

    public static function login($login, $pass)
    {
        $sql = new Sql();
        $result = $sql->select("select * From tb_users where deslogin = :LOGIN",
        array(
         ":LOGIN"=> $login
        ));
       
        if(count($result)===0 ){

            throw new Exception("Usuário inexistente ou senha inválidos",1);
        } 

        $data = $result[0];

        $isOk = password_verify($pass ,$data["despassword"] )===true;
        
        if($isOk){
            
            $user = new User();
            //$user->setiduser($data["iduser"]);
            // $teste= $user->getidUser();
            $user->setData($data);
             
            $_SESSION[User::SESSION]=$user->getData();
          
            //  var_dump($_SESSION[User::SESSION]);
            //   exit;
        }
        else{

            throw new Exception("Usuário inexistente ou senha inválidos",1);
        }

        return $user;


    }

    public static function verifyLogin($inadmin=true){

        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"]>0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"]!==$inadmin
        ){
            header("Location: /admin/login");             
            exit;
        }

    }
    public static function logout(){

        try{
            $_SESSION[User::SESSION]=null;
            session_abort();

        }
        catch(Exception $e){

        }

    }

}

?>