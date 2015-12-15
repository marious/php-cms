<?php

class User extends DatabaseModel
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $gender;
    public $status;
    public $activation;
    public $privilege;
    public $lastlogin;
    public $tableName = 'users';
    public $dbFields = ['username', 'password', 'email', 'gender', 'status', 'activation', 'privilege', 'lastlogin'];

    public static function authinticate($username, $password)
    {
        // encrypte password
        $encrypted_password = md5($username . $password . SALT);
        $sql = "SELECT * FROM users WHERE username = ? AND password = ? AND status = 1";

        $found_user = self::read($sql, PDO::FETCH_CLASS, __CLASS__, [$username, $encrypted_password]);
        if ($found_user) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $found_user;
            $found_user->lastlogin = date('Y-m-d H:i:s');
            if ($found_user->save()) {
                header('Location: ' . HOST_NAME);
            }
        } else {
            return false;
        }
    }

    public static function isLoggedIn()
    {
        return (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) ? true : false;
    }

    public static function theUser()
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function isAdmin()
    {
        return $this->privilege == 1 ? true  : false;
    }

    public function logout()
    {
        unset($_SESSION['loggedin']);
        unset($_SERVER['user']);
        header('Location: ' . HOST_NAME);
    }

    public static function control()
    {
        $view = Path::get_path()['call_parts'][0];
        $editUrl = HOST_NAME . 'admin/'  . $view .'/edit/';
        $deleteUrl = HOST_NAME . 'admin/'  . $view .'/delete/';

        $users = self::read("SELECT * FROM Users WHERE id != " .  User::theUser()->id, PDO::FETCH_CLASS, __CLASS__);
      
        $table = '<table class="admin-table">
                    <tr>
                        <th width="3%">#</th>
                        <th>Username</th>
                        <th width="10%" colspan="2">Control</th>
                    </tr>
                    ';
        if ($users != false) {
            if (is_object($users)) {
                $table .= '<tr>
                            <td>'. $users->id .'</td>
                             <td>'. $users->username .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $users->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $users->id .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
            } else {

                foreach ($users as $item) {
                    $table .= '<tr>
                            <td>'. $item->id .'</td>
                             <td>'. $item->username .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $item->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $item->username .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="4">No User Found</td></tr>';
        }

        $table .= '</table>';
        return $table;
    }
}