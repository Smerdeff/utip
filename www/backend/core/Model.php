<?php

abstract class Model
{
    static $table_name = '';
    static $fields = [];
    static $read_only_fields = [];
    static $key_field = 'id'; #default key field 'id'
    static $orders = '';

    static abstract function db();

    public static function get_table_name()
    {
        return static::$table_name;
    }

    function escape($db, $data)
    {
        #escape and quoted
        foreach ($data as $key => &$value) {
            $value = "'" . mysqli_real_escape_string($db, $value) . "'";
        }
        return $data;
    }

    private static function check_fields()
    {
        array_push(static::$fields, static::$key_field);
        array_push(static::$read_only_fields, static::$key_field);
    }

    static function read($filer=[], $exclude=[])
    {
        self::check_fields();
        $db = static::db();
        $p_string = urldecode(http_build_query(static::escape($db, $filer), '', ' and '));
        $p_string .= ' not '. urldecode(http_build_query(static::escape($db, $exclude), '', ' and '));

//        var_dump($p_string);

        $orders = '';
        if (static::$orders) {
            $orders = 'order by ' . static::$orders;
        }
        $query = sprintf('select %s from %s %s ',
            implode(",", static::$fields),
            static::$table_name,
             $orders);
//        var_dump($query);
        $stmt = $db->query($query);

        $data = [];
        $data["data"] = [];
        if ($stmt) {
            while ($row = $stmt->fetch_assoc()) {
                $item = [];
                foreach (static::$fields as &$field) {
                    $item[$field] = $row[$field];
                }
                array_push($data["data"], $item);
            }
        }

        return $data;

    }

    static function retrieve($id)
    {
        self::check_fields();
        $db = static::db();
        $query = sprintf('select %s from %s where %s = %s', implode(",", static::$fields), static::$table_name, static::$key_field, $id);
        $stmt = $db->query($query);
        $data = [];
        $data["data"] = [];
        if ($stmt) {
            while ($row = $stmt->fetch_assoc()) {
                $item = [];
                foreach (static::$fields as &$field) {
                    $item[$field] = $row[$field];
                }
                array_push($data["data"], $item);
            }
        }
        if (!$data["data"]) {
            return Null;
        }
        return $data;
    }

    static function destroy($id)
    {
        $db = static::db();
        $query = sprintf('delete from %s where %s = %s', static::$table_name, static::$key_field, $id);
        return $db->query($query);;
    }

    static function validate(array $data)
    {
        self::check_fields();
        $validated_data = [];
        foreach ($data as $key => $value) {
            if (in_array($key, static::$fields) and !in_array($key, static::$read_only_fields)) {
                $validated_data[$key] = $value;
            }
        }
        return $validated_data;
    }

    static function update($id, array $data)
    {
        $db = static::db();
        $data = static::escape($db, $data);
        $p_string = urldecode(http_build_query($data, '', ','));

        $query = sprintf('Update %s set %s where %s = %s', static::$table_name, $p_string, static::$key_field, $id);
        var_dump($data, $query);
        if ($db->query($query)) {
            return static::retrieve($id);
        } else
            return false;
    }

    static function create(array $data)
    {
        $db = static::db();
        $data = static::escape($db, $data);
        $p_fields = implode(', ', array_keys($data));
        $p_values = implode(', ', $data);
        $query = sprintf("insert into %s(%s) values(%s) ", static::$table_name, $p_fields, $p_values);

        if ($db->query($query)) {
            return static::retrieve($db->insert_id);
        } else
            return false;
    }


}