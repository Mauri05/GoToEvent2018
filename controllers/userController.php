<?php

namespace controllers;
use daos\databases\UserDB as UserDB;
use models\User as User;

class UserController{

    protected $dao;
    public function __construct()
    {
        $this->dao=UserDB::getInstance();
    }

    public function index(){

        include(ROOT . "views/registerForm.php");
    }

    public function store($email, $userName, $pass)
    {
        $flag = $this->searchInDatabase($email, $userName);
        if(!$flag){
            $user = new User($email, $userName, $pass, "user");
            $ultimoID=$this->dao->insert($user);
            header("Location:" . HOME);
        }
        else{
            throw new \Exception ('El email o nombre de usuario ya existe');
        }
    }

    /*public function delete($email)
    {
        $flag = $this->searchInDatabase($email);
        if($flag){
            $user = new User($email);
            $this->dao->delete($user);
        }
        else{
            throw new \Exception ('Ha ocurrido un error'); 
        }
    }*/

    public function retride(){
        $list=$this->dao->retride();
        return $list;
    }

    public function searchByUsername($username){
        $user = $this->dao->searchByUsername($username);
        return $user;
    }

    public function searchInDatabase($email, $userName){
        $list = $this->retride();
        $flag = false;
        if($list){
            foreach ($list as $key => $value) {
                if($value->getEmail() === $email || $value->getUserName() === $userName){
                    $flag = true;
                }
            }
        }
        return $flag;
    }


}

?>