<?php
require_once 'lib/phpmailer/PHPMailerAutoload.php';

    if (isset($_POST['register'])) {
        $validation = new Validation($_POST, [
            'username' => [
                'required' => true,
                'minlength' => 3,
                'maxlength' => 20,
                'alnum' => true,
                'unique' => 'users'
            ],
            'password' => [
                'required' => true,
                'minlength' => 6,
                'maxlength' => 50
            ],
            'cpassword' => [
            'required' => true,
            'match' => 'password'
        ],
            'email' => [
                'email' => true
            ]
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
        } else {
            $user = new User();
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->gender = $_POST['gender'];
            $user->status = 2;
            $user->privilege = 2;

            // Encrypte password
            $user->password = md5($user->username . $user->password . SALT);
            $user->activation = md5($user->username . $user->password . $user->email . SALT . time());

            if ($user->save()) {
                // Send activation mail
                $m = new PHPMailer();
                $m->isSMTP();
                $m->SMTPAuth = true;
                $m->Host = 'ssl://smtp.googlemail.com';
                $m->Username = 'mohameraya1991@gmail.com';
                $m->Password = '2634231f16';
                $m->SMTPSecure = 'ssl';
                $m->Port = 465;

                $m->isHTML();

                $m->Subject = 'Thank you for rgisteration';
                $m->Body = 'Please Copy and past following link to your browser to activate your account
                                ' . HOST_NAME .'active/' . $user->activation;

                $m->FromName = 'Register';

                $m->AddAddress($user->email, $user->username);

                if ($m->send()) {
                    echo '<p class="success">Thanks for registering check your email address for acivation</p>';
                }
            }
        }

    }


?>

<?php
    if (isset($errors)) {
        echo '<p class="error">' . implode('</p><p class="error">', $errors);
    }
?>
<form action="" method="post" class="register-form" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
                <label for="username">Username:</label>
                <p>Enter Your username</p>
            </td>
        </tr>
        <tr>
            <td><input type="text" name="username" id="username" required></td>
        </tr>
        <tr>
            <td>
                <label for="password">Password:</label>
                <p>Enter Your Password</p>
            </td>
        </tr>
        <tr>
            <td><input type="password" name="password" id="password" required></td>
        </tr>
        <tr>
            <td>
                <label for="cpassword">Confirm Password:</label>
                <p>Enter Your Password again</p>
            </td>
        </tr>
        <tr>
            <td><input type="password" name="cpassword" id="cpassword" required></td>
        </tr>
        <tr>
            <td>
                <label for="email">Email:</label>
                <p>Enter Your email address</p>
            </td>
        </tr>
        <tr>
            <td><input type="email" name="email" id="email" required></td>
        </tr>
        <tr>
            <td>
                <label for="gender">Gender</label>
                <p>Please Select you gender</p>
            </td>
        </tr>
        <tr>
            <td>
                <label for="male"><input type="radio" name="gender" value="1" id="male"> Male</label>
                <label for="female"><input type="radio" name="gender" value="1" id="female"> female</label>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="register" value="Register"></td>
        </tr>
    </table>
</form>