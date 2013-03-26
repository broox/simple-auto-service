<?php
class Date {

    private $_datetime;

    /*
     * Instantiate a Date object from a given parameter.
     * 
     * Params
     * - 0: Can be an existing any Date/DateTime that is recoginized by PHP's DateTime constructor
     *      Can also be an existing Date object (though I'm not sure why this would be useful)
     */
    public function __construct($datetime = NULL) {
        if (is_object($datetime)) {
            if (strtolower(get_class($date)) == 'date') {
                $this->_datetime = $datetime->datetime();
            }
        } elseif (!empty($datetime)) {
            $this->_datetime = new DateTime($datetime);
        } else {
            $this->_datetime = new DateTime();
        }

        // After instantiation, force $this->_datetime to UTC.
        $this->_datetime->setTimezone(new DateTimeZone('UTC'));
    }

    public function datetime()  {
        return $this->_datetime;
    }

    /*
     * Format the datetime for MySQL, optionally convert to a timezone
     *
     * Params
     * - 0: A timezone to convert this DateTime to while formatting it for MySQL
     *      Defaults to UTC
     */
    public function mysqlDateTime($timezone = 'UTC') {
        $this->_datetime->setTimezone(new DateTimeZone($timezone));
        return $this->_datetime->format('Y-m-d H:i:s');
    }

    /*
     * Format the datetime as a MySQL date, optionally convert to a timezone
     *
     * Params
     * - 0: A timezone to convert this DateTime to while formatting it for MySQL
     *      Defaults to UTC
     */
    public function mysqlDate($timezone = 'UTC') {
        $this->_datetime->setTimezone(new DateTimeZone($timezone));
        return $this->_datetime->format('Y-m-d');
    }

    /*
     * Format this particular Date object
     *
     * Params
     * - 0: The desired format to convert this DateTime to
     * - 1: TimeZone to display the date in
     *      Defaults to local timezone
     */
    public function format($format = 'Y-m-d H:i:s', $timezone = TIMEZONE) {
        $this->_datetime->setTimezone(new DateTimeZone($timezone));
        return $this->_datetime->format($format);
    }

}
?>