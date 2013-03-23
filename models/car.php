<?php
/*
+------------+--------------+------+-----+---------+----------------+
| Field      | Type         | Null | Key | Default | Extra          |
+------------+--------------+------+-----+---------+----------------+
| id         | int(9)       | NO   | PRI | NULL    | auto_increment |
| slug       | varchar(100) | NO   |     | NULL    |                |
| year       | int(4)       | NO   |     | NULL    |                |
| make       | varchar(100) | YES  |     | NULL    |                |
| model      | varchar(100) | YES  |     | NULL    |                |
| trim       | varchar(100) | YES  |     | NULL    |                |
| retired_on | date         | YES  |     | NULL    |                |
| created_at | datetime     | YES  |     | NULL    |                |
| updated_at | datetime     | YES  |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
*/

class Car extends Model {
    protected static $_table = 'cars';
    protected $_fields = array('id','slug','year','make','model','trim','retired_on','createdAt','updatedAt');

    public function title() {
        $title = array($this->year, $this->make, $this->model, $this->trim);
        return implode(' ', rejectEmptyArrayValues($title));
    }

    /*
     * This car's URL
     */
    public function url() {
        return SITE_URL.'/cars/'.$this->slug.'/';
    }

    /*
     * A collection of cars that aren't retired
     */
    public static function current() {
        return self::index(array('conditions' => array('retired_on IS NULL'),
                                 'order' => 'created_at ASC'));
    }

    /*
     * A collection of cars that have been retired
     */
    public static function retired() {
        return self::index(array('conditions' => array('retired_on IS NOT NULL'),
                                 'order' => 'created_at DESC'));
    }
}
?>