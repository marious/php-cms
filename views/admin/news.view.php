<?php
$action = isset( Path::get_path()['call_parts'][1] ) ? Path::get_path()['call_parts'][1] : null;
$view = Path::get_path()['call_parts'][0];

if ( isset($_GET['message']) && $_GET['message'] == 'success' ) {
    $message = '<p class="success">Item has been saved successfully</p>';
} elseif ( isset($_GET['message']) && $_GET['message'] == 'failed' ) {
    $message = '<p class="error">Error Saving Item in the database</p>';
}

if ( $action != null && $action == 'add' ) {
    if ( isset($_POST['save']) ) {
        $News = new News();
        $News->title = $_POST['title'];
        $News->content = $_POST['content'];

        if ( $News->save() ) {
            header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=success');
        } else {
            header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=failed');
        }
    }
} elseif ( $action != null && $action == 'edit' ) {
    $item = isset( Path::get_path()['call_parts'][2] ) ? (int) Path::get_path()['call_parts'][2] : null;
    if ( $item ) {
        $News = News::read("SELECT * FROM news WHERE id = ?", PDO::FETCH_CLASS, 'News', [$item]);
        if ($News != false) {
            if (isset($_POST['save'])) {
                $News->title = $_POST['title'];
                $News->content = $_POST['content'];

                if ( $News->save() ) {
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
        $News = News::read("SELECT * FROM news WHERE id = ?", PDO::FETCH_CLASS, 'News', [$item]);
        if ($News != false) {
            if ( $News->delete() ) {
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

    <h3>Manage Your Daily News</h3>
    <p>Please use this panel to manage your News Items</p>

<?php if (isset($message)) {echo $message; } ?>

<?php if ( $action != null && ($action == 'edit' || $action == 'add') ){ ?>

    <form action="" method="post" class="admin-form">
        <table>
            <tr>
                <td>
                    <label for="title">news title:</label>
                    <p>The title that should appear in the web page</p>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="title" value="<?php if (isset($News)) echo $News->title; ?>" required></td>
            </tr>
            <tr>
                <td>
                    <label for="content">news Content:</label>
                    The content of the News
                </td>
            </tr>
            <tr>
                <td><textarea name="content" required><?php if (isset($News)) echo $News->content; ?></textarea></td>
            </tr>
            <tr>
                <td><input type="submit" name="save" value="Save"></td>
            </tr>
        </table>
    </form>


<?php } else { echo News::control(); }?>