<?php
$action = isset( Path::get_path()['call_parts'][1] ) ? Path::get_path()['call_parts'][1] : null;
$view = Path::get_path()['call_parts'][0];

if ( isset($_GET['message']) && $_GET['message'] == 'success' ) {
    $message = '<p class="success">Item has been saved successfully</p>';
} elseif ( isset($_GET['message']) && $_GET['message'] == 'failed' ) {
    $message = '<p class="error">Error Saving Item in the database</p>';
}

if ( $action != null && $action == 'edit' ) {
    $item = isset( Path::get_path()['call_parts'][2] ) ? (int) Path::get_path()['call_parts'][2] : null;
    if ( $item ) {
        $user = User::read("SELECT * FROM Users WHERE id = ?", PDO::FETCH_CLASS, 'User', [$item]);
        if ($user != false) {
            if (isset($_POST['save'])) {
                $user->privilege = $_POST['privilege'];
                $user->status = $_POST['status'];

                if ( $user->save() ) {
                    header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=success');
                } else {
                    header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=failed');
                }
            }
        } else {
            header('Location: ' . HOST_NAME . 'admin/404.php' );
        }
    }
} elseif ( $action != null && $action == 'delete' ) {
    $item = isset( Path::get_path()['call_parts'][2] ) ? (int) Path::get_path()['call_parts'][2] : null;
    if ( $item ) {
        $user = User::read("SELECT * FROM users WHERE id = ?", PDO::FETCH_CLASS, 'User', [$item]);
        if ($user != false) {
            if ( $user->delete() ) {
                header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=success');
            } else {
                header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=failed');
            }
        }
    } else {
        header('Location: ' . HOST_NAME . 'admin/404.php' );
    }
}


?>

    <h3>Manage Your Users</h3>
    <p>Please use this panel to manage Web users </p>

<?php if (isset($message)) {echo $message; } ?>

<?php if ( $action != null && ($action == 'edit' || $action == 'add') ){ ?>

    <form action="" method="post" class="admin-form">
        <table>
            <tr>
                <td>
                    <label for="title">User Privilege:</label>
                    <p>Set the user privilege</p>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="privilege" id="privilege">
                        <option value="1" <?php if (isset($user) && $user->privilege == 1) echo 'selected'; ?>>Aministrator</option>
                        <option value="2" <?php if (isset($user) && $user->privilege == 2) echo 'selected'; ?>>User</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="status">User Status:</label>
                    <p>Enabe / Disable user</p>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="status" id="status">
                        <option value="1" <?php if (isset($user) && $user->status == 1) echo 'selected'; ?>>Enabled</option>
                        <option value="2" <?php if (isset($user) && $user->status == 2) echo 'selected'; ?>>Disabled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="save" value="Save"></td>
            </tr>
        </table>
    </form>


<?php } else { echo User::control(); }?>