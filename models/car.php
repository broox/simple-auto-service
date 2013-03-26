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
| retired_at | datetime     | YES  |     | NULL    |                |
| created_at | datetime     | YES  |     | NULL    |                |
| updated_at | datetime     | YES  |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
*/

class Car extends Model {
    protected static $_table = 'cars';
    protected $_fields = array('id','slug','year','make','model','trim','retiredAt','createdAt','updatedAt');

    private $_serviceLogs = NULL;

    /*
     * This car's title
     */
    public function title() {
        $parts = array($this->year, $this->make, $this->model, $this->trim);
        $title = implode(' ', rejectEmptyArrayValues($parts));
        return empty($title) ? 'Unknown car' : $title;
    }

    /*
     * This car's URLs
     */
    public function url() {
        $id = empty($this->slug) ? $this->id : $this->slug;
        return SITE_URL.'/cars/'.$id.'/';
    }

    /*
     * The URL to edit this car
     */
    public function editURL() {
        return $this->url().'edit';
    }

    /*
     * The URL to add service to this car
     */
    public function serviceURL() {
        return $this->url().'service';
    }

    /*
     * The URL to retire this car
     */
    public function retireURL() {
        return $this->url().'retire';
    }

    /*
     * The URL to resurrect a retired car
     */
    public function resurrectURL() {
        return $this->url().'resurrect';
    }

    /*
     * Is this car retired?
     */
    public function retired() {
        return !empty($this->retiredAt);
    }

    /*
     * Retire this car
     */
    public function retire() {
        return $this->updateAttribute('retiredAt', new Date(), true);
    }

    /*
     * Resurrect this car from being retired
     */
    public function resurrect() {
        error_log('RESURRECT ME');
        return $this->updateAttribute('retiredAt', NULL, true);
    }

    public function serviceLogs() {
        if (empty($_serviceLogs))
            $_serviceLogs = CarService::index(array('conditions' => array('car_id = ?', $this->id),
                                                    'order' => 'serviced_at ASC'));

        return $_serviceLogs;
    }

    public function lastService() {
        if (empty($_lastService))
            $_lastService = CarService::one(array('conditions' => array('car_id = ?', $this->id),
                                                  'order' => 'serviced_at DESC',
                                                  'limit 1'));
        return $_lastService;
    }

    public function totalCost() {
        $cost = 0;
        foreach ($this->serviceLogs() as $log)
            $cost += $log->totalCost();

        return $cost;
    }

    /*
     * A collection of cars that aren't retired
     */
    public static function active() {
        return self::index(array('conditions' => array('retired_at IS NULL'),
                                 'order' => 'created_at ASC'));
    }

    /*
     * A collection of cars that have been retired
     */
    public static function inactive() {
        return self::index(array('conditions' => array('retired_at IS NOT NULL'),
                                 'order' => 'created_at DESC'));
    }

    /*
     * Extend Model::create() to generate slugs
     */
    public function create() {
        $this->generateSlug();
        return parent::create();
    }

    /*
     * Extend Model::generateSlug() to use our custom definition
     */
    public function generateSlug() {
        return parent::generateSlug('year','make','model','trim');
    }

    /*
     * Extend Model::updateSlug() to use our custom definition
     */
    public function updateSlug() {
        return parent::updateSlug('year','make','model','trim');
    }

}
?>