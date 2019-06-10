<?php
error_reporting(0);
class func{
    public static function checkLoginState($dbh){
            if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
                $uri = 'https://';
            } else {
                $uri = 'http://';
            }
            $uri .= $_SERVER['HTTP_HOST'];

        if(!isset($_SESSION)){
            
            session_start();
        }
        if(isset($_COOKIE['username']) && isset($_COOKIE['token']) && isset($_COOKIE['serial'])){
            global $uri;
            $userid = $_COOKIE['username'];
            $token = $_COOKIE['token'];
            $serial = $_COOKIE['serial'];
                            
            $query = "SELECT * FROM `ptn_sess` WHERE `sess_us_id` = :userid AND `sess_tkn` = :token AND `sess_srl` = :serial;";
            
            $stmt = $dbh ->prepare($query);
            $stmt->execute(array(':userid' =>$userid, ':token' =>$token, ':serial' =>$serial));
            
            $row = $stmt-> fetch(PDO::FETCH_ASSOC);

            if($row['sess_id'] > 0){
                if($row['sess_us_id'] == $_COOKIE['username'] && $row['sess_tkn'] == $_COOKIE['token'] && $row['sess_srl'] == $_COOKIE['serial']){
                    
                    return true;
                }
                
            }else{
                return false;
            }

        }else{
            return false;
        }

    }
    public static function createRecord($dbh,$admin_name, $admin_id){

        $token = func:: createString(30);
        $serial = func:: createString(30);      
        $dt = date('Y-m-d G:i:s');

        func:: createSession($admin_id, $admin_name, $token, $serial);
        func:: createCookie($admin_name, $admin_id, $token, $serial);
    
        $dbh->prepare('DELETE FROM `ptn_sess` WHERE `sess_us_id` = :sessions_userid;') ->execute(array(':sessions_userid' =>$admin_name));

        $query ="INSERT INTO `ptn_sess`(`sess_id`,`sess_us_id`, `sess_tkn`, `sess_srl`, `sess_dt`) VALUES ('',:admin_id,:token,:serial,:dt)";
        $stmt = $dbh -> prepare($query);

        if($stmt->execute(array(':admin_id' =>$admin_name, ':token' => $token, ':serial' => $serial, ':dt' => $dt))){

            return true;

        }else{
            return false;
        }
            
    }


    
    public static function createSession($admin_id, $admin_name, $token, $serial){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['userid'] = $admin_id;
        $_SESSION['username'] = $admin_name;
        $_SESSION['token'] = $token;
        $_SESSION['serial'] = $serial;



    }

    public static function createCookie($admin_name, $admin_id, $token, $serial){
        setcookie('userid', $admin_id, time() + (86400) * 30, "/");
        setcookie('username', $admin_name, time() + (86400) * 30, "/");
        setcookie('token', $token, time() + (86400) * 30, "/");
        setcookie('serial', $serial, time() + (86400) * 30, "/");

    }
    public static function deleteCookie(){
        global $dbc;
        setcookie('userid', '', time() -1, "/");
        setcookie('username', '', time() -1, "/");
        setcookie('token', '', time() -1, "/");
        setcookie('serial', '', time() -1, "/");

        $sql = "SELECT * FROM `ptn_sess` WHERE `sess_us_id`=".$_COOKIE['username'];
        $qry = mysqli_query($dbc, $sql);
        if ($qry){
            return true;
        }else{
            return false;
        }
    }

    public static function createString($len){
        $string = "1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9ollpAQWSXEDCVFRTGBNHYZUJMKILOP";
        
        return substr(str_shuffle($string), 0, $len);
    }
    
    public static function escape_data ($dbc, $data) {

        if (function_exists('mysql_real_escape_string')) {
            $data = mysqli_real_escape_string ($dbc, trim($data));
            $data = strip_tags($data);
        } else {
            $data = mysqli_escape_string ($dbc, trim($data));
            $data = strip_tags($data);
        }   
        return $data;

    }
}



 ?>