<?php
require_once './db.php';

/*
 * A super basic Model class to support simple CRUD functionality.
 */
class Model {
    protected static $db;
    private $_changedFields;

    protected $_table;
    protected $_fields = array();

    public function __construct($reference = null) {
        global $db;
        self::$db = $db;
        if ($reference != null) {
            $this->load($reference);
        } else {
            foreach ($this->_fields as $field) {
                $this->$field = null;
            }
        }
    }

    /*
     * Load an object up from the DB by ID or slug
     * Also supports loading an object from a given array or object
     */
    public function load($reference) {
        if ($reference != null) {
            global $db;
            
            if (is_numeric($reference))
                $params = $db->get_row('SELECT * FROM '.$this->_table.' WHERE id = '.$reference);
            elseif (is_string($reference))
                $params = $db->get_row('SELECT * FROM '.$this->_table.' WHERE slug = "'.$reference.'"');
            elseif (is_array($reference) || is_object($reference))
                $params = $reference;

            if ($params)
                $this->loadProperties($params);
        }
        return $this;
    }

    /*
     * Loads up all of the properties from the DB on the current object
     */
    public function loadProperties($reference) {
        if (!$reference) return;
        foreach ($reference as $key => $value) {
            if (is_numeric($key)) continue;

            if (substr($key,-3) == '_at' and !empty($value))
                    $value = ($value == '0000-00-00 00:00:00') ? NULL : new Date($value.' UTC');

            if (substr($key,-3) == '_on' && !empty($value)) {
                $value = ($value == '0000-00-00') ? NULL : new Date($value.' UTC');
            }

            $key = str_replace('_id','ID',$key);
            $key = camelCase($key);

            // Remove properties not defined in our fields
            if (!in_array($key,$this->_fields)) continue;

            $this->$key = $value;
        }
    }

    /*
     * Retrieve a single item in a collection based on some query arguments
     * This is ghetto in that it requires an index() method on the child object.
     */
    public static function one(array $kwargs = array()) {
        if (!method_exists(get_called_class(),'index')) {
            error_log('[WARN] '.get_called_class().'::index() does not exist');
            return false;
        }

        $kwargs['limit'] = 1;
        $one = static::index($kwargs);
        if (!$one)
            return new self;

        return $one[0];
    }

    /* 
     * Does this object exist in the database?
     */
    public function exists() {
        return !empty($this->id);
    }

    /*
     * Does this object not exist in the database?
     */
    public function doesntExist() {
        return empty($this->id);
    }

    /*
     * Creates an object in the database
     */
    public function create() {
        global $db;
        if (empty($this->_table)) { error_log('[WARN] Table name is not defined on object'); return false; }
        if (empty($this->_fields)) { error_log('[WARN] Fields are not defined on object'); return false; }

        $params = array();
        foreach($this->_fields as $field) {
            if (isset($this->$field)) {
                $tableKey = underscore(str_replace('ID','Id',$field));
                $params[$tableKey] = $this->$field;
                if (is_a($params[$tableKey],'Date')) { $params[$tableKey] = $params[$tableKey]->mysqlDateTime('UTC'); }
            }
        }
        if (empty($params)) { error_log('[WARN] Cannot create object with no parameters'); return false; }

        $sql = 'INSERT INTO '.$this->_table.' ('.implode(', ',array_keys($params));
        if (in_array('createdAt',$this->_fields) && !array_key_exists('created_at',$params)) { $sql.= ',created_at'; }

        $sql.= ') VALUES ('.implode(',',array_fill(0,count($params),'?'));
        if (in_array('createdAt',$this->_fields) && !array_key_exists('created_at',$params)) { $sql.= ',UTC_TIMESTAMP()'; }
        $sql.= ')';
        $query = $db->query($sql,$params);
        $this->__construct($db->insert_id());
        return true;
    }

    /*
     * Update a single attribute on the current object.
     *
     * Params
     * - 0: a string representing the attribute name
     * - 1: a string representing the attribute value
     * - 2: a boolean specifying whether or not the attribute should be immediately saved to the DB.
     *            Defaults to true.
     */
    public function updateAttribute($key, $value, $save = true) {
        if ($key == 'id') return false;
        if (!in_array($key,$this->_fields)) return false;
        if (is_string($value)) $value = stripslashes($value);

        if ($this->$key == $value) return false;

        $this->_changedFields[$key] = array($this->$key, $value);
        $this->$key = $value;

        if (!$save) return $this->$key;

        return $this->update();
    }

    /*
     * Update a collection of attributes on the current object.
     * This method does not save to the database, so calling update() on the object
     * is necessary.
     *
     * Params
     * - 0: a hash (named array) representing the keys and values to update.
     */
    public function updateAttributes($params) { 
        foreach($params as $k => $v) {
            if ($k == 'id') { continue; }
            if (!in_array($k,$this->_fields)) { continue; }
            if (!isset($this->$k)) $this->$k = NULL;

            if (is_string($v)) $v = stripslashes($v);

            if ($this->$k != $v) {
                $this->_changedFields[$k] = array($this->$k, $v);
            }
            $this->$k = $v;
        }
        return $this->_changedFields;
    } 

    /*
     * Updates the current object in the DB if there is a diff between its current state
     * and the state of the object in the database.
     */
    public function update() {
        global $db;
        if (empty($this->_table)) { error_log('[WARN] Table name is not defined on object'); return false; }
        if (empty($this->_fields)) { error_log('[WARN] Fields are not defined on object'); return false; }

        //let's only update if updateAttributes actually updated any attributes... 
        if (empty($this->_changedFields)) { /* error_log('[DBUG] No fields were changed'); */ return $this; }

        $params = array();
        foreach($this->_changedFields as $key => $values) {
            $tableKey = underscore(str_replace('ID','Id',$key));
            $params[$tableKey] = $this->$key;
            if (is_a($params[$tableKey],'Date')) { $params[$tableKey] = $params[$tableKey]->mysqlDateTime('UTC'); }
        }

        unset($params['id']);
        //unset($params['created_at']);

        $sql = 'UPDATE '.$this->_table.' SET '.join(' = ?, ',array_keys($params)).' = ? ';
        if (in_array('updatedAt',$this->_fields) && !array_key_exists('updated_at',$params))
            $sql.= ', updated_at = UTC_TIMESTAMP() ';
        $sql.= 'WHERE id = '.$this->id.' LIMIT 1';

        $query = $db->query($sql,$params);
        $this->__construct($this->id);
        return true;
    }

    /*
     * Deletes the current object from the database.
     */
    public function delete() {
        global $db;
        if (empty($this->_table)) { error_log('[WARN] Table name is not defined on object'); return false; }
        if (empty($this->_fields)) { error_log('[WARN] Fields are not defined on object'); return false; }
        if (empty($this->id)) { error_log('[WARN] Cannot delete an object without an ID'); return false;}

        // Remove any associated Tags, Comments, and Check Ins
        if (!empty($this->contentTypeID)) {
            $params = array($this->id,$this->contentTypeID);
            $db->query('DELETE FROM derek_taggings    WHERE attached_id = ? AND attached_type = ?',$params);
            $db->query('DELETE FROM derek_comments    WHERE attached_id = ? AND attached_type = ?',$params);
        }

        // Remove any associated Check Ins
        if (!empty($this->contentType)) {
            $db->query('DELETE FROM derek_check_ins WHERE attached_id = ? AND attached_type = ?',array($this->id,$this->contentType));
        }

        // Delete object
        $db->query('DELETE FROM '.$this->_table.' WHERE id = ? LIMIT 1',$this->id);
        return true;
    }

}
?>
