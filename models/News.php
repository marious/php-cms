<?php
//`id`, `title`, `user_id`, `created`, `content`

class News extends DatabaseModel
{
    public $id;
    public $title;
    public $user_id;
    public $created;
    public $content;
    public $tableName = 'news';
    public $dbFields = ['title', 'user_id', 'created', 'content'];

    public static function control()
    {
        $view = Path::get_path()['call_parts'][0];
        $addUrl = HOST_NAME . 'admin/'  . $view .'/add';
        $editUrl = HOST_NAME . 'admin/'  . $view .'/edit/';
        $deleteUrl = HOST_NAME . 'admin/'  . $view .'/delete/';

        $news = self::read("SELECT * FROM news", PDO::FETCH_CLASS, __CLASS__);
        $table = '<a href="' . $addUrl . '" class="add-link">+ Add New News</a>';
        $table .= '<table class="admin-table">
                    <tr>
                        <th width="3%">#</th>
                        <th>News title</th>
                        <th width="10%" colspan="2">Control</th>
                    </tr>
                    ';
        if ($news != false) {
            if (is_object($news)) {
                $table .= '<tr>
                            <td>'. $news->id .'</td>
                             <td>'. $news->title .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $news->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $news->id .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
            } else {

                foreach ($news as $item) {
                    $table .= '<tr>
                            <td>'. $item->id .'</td>
                             <td>'. $item->title .'</td>
                             <td class="button">
                                <a href="'. $editUrl . $item->id .'"><i class="fa fa-edit"></i></a>
                                <a href="'. $deleteUrl . $item->id .'" class="delete"><i class="fa fa-trash-o"></i></a>
                             </td>
                        </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="4">No news Found</td></tr>';
        }

        $table .= '</table>';
        return $table;
    }
}