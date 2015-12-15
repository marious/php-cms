<?php
if ( User::isLoggedIn() ) {
    $user = new User();
    $user->logout();
} else {
    header('Location: ' . HOST_NAME);
}