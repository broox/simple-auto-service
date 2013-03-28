<?php
class db {
    var $conn;
    
    public function db($user, $password, $name, $host) {
        $this->host = $host;
        $this->user = $user;
        $this->name = $name;
        $this->password = $password;
        $this->connect();
    }

    public function connect() {
        if (!is_resource($this->conn) && !is_object($this->conn)) {
            $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->name) or
            die(__FILE__."(Line: ".__LINE__."): ".mysql_errno()." - ".mysql_error()); 
        }
    }

    public function disconnect() {
        mysqli_close($this->conn);
    }

    public function selectDB($db_name) {
        mysql_select_db($db_name) or
            die(__FILE__."(Line: ".__LINE__."): ".mysql_errno()." - ".mysql_error());
    }

    public function query($query) {

        if (func_num_args() > 1) {
            $argv = func_get_args();
            $binds = (is_array(next($argv))) ? current($argv) : array_slice($argv, 1);
        }

        if (isset($binds) && $binds != null)
            $query = $this->compileBinds($query, $binds);

        if (!$this->conn->multi_query($query)) {
            error_log('[WARN] '.$this->conn->error.' - '.$query.' @ '.$_SERVER['SCRIPT_NAME']);
            return false;
        }
        $this->result = $this->conn->store_result();
        if (is_object($this->result)) {
            $this->currentRow = 0;
            $this->totalRows  = $this->result->num_rows;
        } elseif ($this->conn->error) {
            error_log('[WARN] '.$this->conn->error.' - '.$query.' @ '.$_SERVER['SCRIPT_NAME']);
        } else  {
            // It's a DELETE, INSERT, REPLACE, or UPDATE query
            $this->insert_id  = $this->conn->insert_id;
            $this->total_rows = $this->conn->affected_rows;
        }
        return $this->result;
    }

    public function insertID() {
        return $this->conn->insert_id;
    }

    public function getRow($query) {
        $binds = null;
        if (func_num_args() > 1) {
            $argv = func_get_args();
            $nextArg = next($argv);
            $binds = is_array($nextArg) ? current($argv) : array_slice($argv, 1);
        }

        $result = $this->query($query, $binds);
        if ($result) {
            $row = $this->fetchObject($result);
            return $row;
        }
        else
            return null;
    }

    public function getCount($query) {
        if (func_num_args() > 1) { 
            $argv = func_get_args(); 
            $binds = (is_array(next($argv))) ? current($argv) : array_slice($argv, 1); 
        } else $binds = null;
        return $this->getVar($query,$binds);
    }

    public function getVar($query) {
        if (func_num_args() > 1) { 
            $argv = func_get_args(); 
            $binds = (is_array(next($argv))) ? current($argv) : array_slice($argv, 1); 
        } else $binds = null;
        $result = $this->query($query,$binds);
        if ($result) {
            $row = $this->fetchRow($result);
            return $row[0];
        }
        else
            return null;
    }

    public function numRows($result) {
        return $result->num_rows;
    }

    public function numFields($result) {
        return $result->num_fields();
    }

    public function fetchArray($result) {
        return $result->fetch_array();
    }

    public function fetchRow($result) {
        return $result->fetch_row();
    }

    public function fetchObject($result) {
        return $result->fetch_object();
    }

    public function compileBinds($sql, $binds) {
        foreach ((array) $binds as $val) {
            // If the SQL contains no more bind marks ("?"), we're done.
            if (($next_bind_pos = strpos($sql, '?')) === FALSE)
                break;

            // Properly escape the bind value.
            $val = $this->escape($val);

            // Temporarily replace possible bind marks ("?"), in the bind value itself, with a placeholder.
            $val = str_replace('?', '{%B%}', $val);

            // Replace the first bind mark ("?") with its corresponding value.
            $sql = substr($sql, 0, $next_bind_pos).$val.substr($sql, $next_bind_pos + 1);
        }

        // Restore placeholders.
        return str_replace('{%B%}', '?', $sql);
    }

    public function escape($value) {
        switch (gettype($value)) {
            case 'string':
                $value = '\''.$this->conn->real_escape_string($value).'\'';
                break;
            case 'boolean':
                $value = (int) $value;
                break;
            case 'double':
                $value = sprintf('%F', $value);
                break;
            default:
                $value = ($value === NULL) ? 'NULL' : $value;
                break;
        }
        return (string) $value;
    }
}
$db = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
?>
