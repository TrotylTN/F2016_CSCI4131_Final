<?php
/**
* 
*/
class UsersDB
{
    private $con;

    public function __construct()
    {
        $this->con = new mysqli('egon.cs.umn.edu', 'C4131F16U128', '18606', 'C4131F16U128', '3307');
        if ($this->con->connect_error)
            echo "Failed to connect to MySQL: ".mysqli_connect_error();
    }

    public function get_user($login_name)
    {
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login='".$login_name."'";
        return (mysqli_query($this->con, $sql));
    }
}
?>