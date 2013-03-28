<?php
/*
+-----------------+--------------+------+-----+---------+----------------+
| Field           | Type         | Null | Key | Default | Extra          |
+-----------------+--------------+------+-----+---------+----------------+
| id              | int(9)       | NO   | PRI | NULL    | auto_increment |
| car_id          | int(9)       | NO   |     | NULL    |                |
| mileage         | varchar(7)   | YES  |     | NULL    |                |
| serviced_at     | datetime     | YES  |     | NULL    |                |
| serviced_by     | varchar(100) | YES  |     | NULL    |                |
| service_cost    | decimal(9,2) | NO   |     | 0.00    |                |
| parts           | varchar(255) | YES  |     | NULL    |                |
| parts_cost      | decimal(9,2) | NO   |     | 0.00    |                |
| parts_from      | varchar(100) | YES  |     | NULL    |                |
| service_details | text         | YES  |     | NULL    |                |
| created_at      | datetime     | YES  |     | NULL    |                |
| updated_at      | datetime     | YES  |     | NULL    |                |
+-----------------+--------------+------+-----+---------+----------------+
*/

class CarService extends Model {
    protected static $_table = 'car_services';
    protected $_fields = array('id','carID','mileage','servicedAt','servicedBy','serviceCost','parts','partsCost','partsFrom','serviceDetails','createdAt','updatedAt');

    private $_car;

    /*
     * The URL to edit this service
     */
    public function editURL() {
        return SITE_URL.'/car_services/'.$this->id.'/edit';
    }

    /*
     * The total cost for this service (parts + service fee)
     */
    public function totalCost() {
        return $this->partsCost + $this->serviceCost;
    }

    /*
     * The car associated with this service
     */
    public function car() {
        if (empty($_car))
            $_car = new Car($this->carID);

        return $_car;
    }
}
?>