<?php
/**
* 
*/
class AccountDB
{
    private $con;
    
    function __construct()
    {
        $this->con = new mysqli('egon.cs.umn.edu', 'C4131F16U128', '18606', 'C4131F16U128', '3307');
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
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login='".$login."'";
        if (mysqli_query($this->con, $sql)->num_rows > 0) {
            return 0;
        }
        $sql = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('".$name."', '".$login."', '".$passcode_sha."');";
        mysqli_query($this->con, $sql);
        return 1;
    }

    public function update($id, $name, $login, $password_sha)
    {
        $sql="UPDATE tbl_accounts SET acc_name='".$name."', acc_login='".$login."', acc_password='".$password_sha."' WHERE acc_id='".$id."'";
        mysqli_query($this->con, $sql);
    }    
}

?>