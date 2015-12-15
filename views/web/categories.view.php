
    <?php
        if (isset(Path::get_path()['call_parts'][1])) {
            $catId = Path::get_path()['call_parts'][1];
          $cat = Category::read("SELECT * FROM categories WHERE id = ?", PDO::FETCH_CLASS, 'Category', [$catId]);
            if ($cat) {
                echo '<h2>' . $cat->name . '</h2>';
                echo '<p>' . $cat->content . '</p>';
            }
        }




