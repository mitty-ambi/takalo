<?php
class User
{
    public $id_user;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($id_user = null, $username = null, $email = null, $password = null, $role = null)
    {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
}
?>