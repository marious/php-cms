<?php
$activate_code = isset(Path::get_path()['call_parts'][1]) ?  Path::get_path()['call_parts'][1] : null;

if ($activate_code) {
   $user = User::read("SELECT * FROM users WHERE activation = ?", PDO::FETCH_CLASS, 'User', [$activate_code]);

    if ($user) {
        $user->activation = '';
        $user->status = 1;
        $user->save();
        echo '<p class="success">Your account has been activated</p>';
    } else {
        echo '<p class="error">This activation link doesn\'t exist</p>';
    }
} else {
    header('Location: ' . HOST_NAME);
}