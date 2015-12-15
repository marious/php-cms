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
        $category = new Category();
        $category->name = $_POST['name'];
        $category->title = $_POST['title'];
        $category->content = $_POST['content'];

        if ( $category->save() ) {
            header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=success');
        } else {
            header('Location: ' . HOST_NAME . 'admin/' . $view . '/?message=failed');
        }
    }
} elseif ( $action != null && $action == 'edit' ) {
    $item = isset( Path::get_path()['call_parts'][2] ) ? (int) Path::get_path()['call_parts'][2] : null;
    if ( $item ) {
        $category = Category::read("SELECT * FROM categories WHERE id = ?", PDO::FETCH_CLASS, 'Category', [$item]);
        if ($category != false) {
            if (isset($_POST['save'])) {
                $category->name = $_POST['name'];
                $category->title = $_POST['title'];
                $category->content = $_POST['content'];

                if ( $category->save() ) {
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
        $category = Category::read("SELECT * FROM categories WHERE id = ?", PDO::FETCH_CLASS, 'Category', [$item]);
        if ($category != false) {
                if ( $category->delete() ) {
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

<h3>Manage Your Website Categories</h3>
<p>Please use this panel to manage your categories</p>

<?php if (isset($message)) {echo $message; } ?>

<?php if ( $action != null && ($action == 'edit' || $action == 'add') ){ ?>

    <form action="" method="post" class="admin-form">
        <table>
            <tr>
                <td>
                    <label for="name">Caregory Name:</label>
                    <p>The name that should appear in the menu</p>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="name" value="<?php if (isset($category)) echo $category->title; ?>" required></td>
            </tr>
            <tr>
                <td>
                    <label for="title">Caregory title:</label>
                    <p>The title that should appear in the web page</p>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="title" value="<?php if (isset($category)) echo $category->title; ?>" required></td>
            </tr>
            <tr>
                <td>
                    <label for="content">Caregory Content:</label>
                    The content of the category
                </td>
            </tr>
            <tr>
                <td><textarea name="content" required><?php if (isset($category)) echo $category->content; ?></textarea></td>
            </tr>
            <tr>
                <td><input type="submit" name="save" value="Save"></td>
            </tr>
        </table>
    </form>


<?php } else { echo Category::control(); }?>