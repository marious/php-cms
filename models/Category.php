<?php
//`id`, `user_id`, `name`, `created`, `title`, `content

class Category extends DatabaseModel
{
    public $id;
    public $user_id;
    public $name;
    public $created;
    public $title;
    public $content;
    public $tableName = 'categories';
    public $dbFields = ['user_id', 'name', 'created', 'title', 'content'];


    public static function control()
    {
        $view = Path::get_path()['call_parts'][0];
        $addUrl = HOST_NAME . 'admin/'  . $view .'/add';
        $editUrl = HOST_NAME . 'admin/'  . $view .'/edit/';
        $deleteUrl = HOST_NAME . 'admin/'  . $view .'/delete/';

        $allCategories = self::read("SELECT * FROM categories", PDO::FETCH_CLASS, __CLASS__);
        $table = '<a href="' . $addUrl . '" class="add-link">+ Add New Category</a>';
        $table .= '<table class="admin-table">
                    <tr>
                        <th width="3%">#</th>
                        <th>Category Name</th>
                        <th width="10%" colspan="2">Control</th>
                    </tr>
                    ';
        if ($allCategories != false) {
            if (is_object($allCategories)) {
                $table .= '<tr>
                            <td>'. $allCategories->id .'</td>
                             <td>'. $allCategories->name .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $allCategories->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $allCategories->id .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
            } else {

                foreach ($allCategories as $category) {
                    $table .= '<tr>
                            <td>'. $category->id .'</td>
                             <td>'. $category->name .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $category->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $category->id .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="4">No Categories Found</td></tr>';
        }

        $table .= '</table>';
        return $table;
    }


    public static function renderNavigation()
    {
        $allCategories = self::read("SELECT * FROM categories ORDER BY name", PDO::FETCH_CLASS, __CLASS__);
        if ($allCategories) {
            $output = '';
            foreach ($allCategories as $category) {
                $output .= '<li><a href="'.HOST_NAME.'categories/'. $category->id .'">'.$category->name.'</a></li>';
            }
            return $output;
        }
    }
}