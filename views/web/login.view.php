<?php
    if ( isset($_POST['login']) ) {
        $validation = new Validation($_POST, [
            'username' => ['required' => true],
            'password' => ['required' => true]
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
        } else {
            $user = new User();
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!User::authinticate($username, $password)) {
                echo '<p class="error">Username / Password doesn\'t match or you may be disbaled</p>';
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
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td><input type="submit" name="login" value="Login"></td>
        </tr>
    </table>
    </form>