<?php
/**
* 
*/
class Account
{
    private $con;
    
    function __construct()
    {
        $this->server_name = 'egon.cs.umn.edu';
        $this->user_name = 'C4131F16U128';
        $this->pass_code = '18606';
        $this->acc_name = 'C4131F16U128';
        $this->port_num = '3307';
        $this->con = new mysqli($this->server_name, $this->user_name, $this->pass_code, $this->acc_name, $this->port_num);
        if ($this->con->connect_error)
            echo "Failed to connect to MySQL: ".mysqli_connect_error();
    }

    public function getusers()
    {
        $sql= "SELECT * FROM tbl_accounts";
        $result = mysqli_query($this->con, $sql);
        $users = array();
        while ($user = mysqli_fetch_assoc($result))
        {
            array_push($users, $user);
        }
        return $users;
    }

    public function deluser($id) {
        $sql = "DELETE FROM tbl_accounts WHERE acc_id='".$id."'";
        mysqli_query($this->con, $sql);
    }

    public function adduser($name, $login, $passcode_sha) {
        $sql = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('".$name."', '".$login."', '".$password_sha."');";
        mysqli_query($this->con, $sql);
    }
}

?>