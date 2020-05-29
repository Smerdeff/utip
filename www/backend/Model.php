<?php

abstract class Model
{
    static $table_name = '';
    static $fields = [];
    static $read_only_fields = [];
    static $key_field = 'id'; #default key field 'id'

    static abstract function db();

    public static function get_table_name()
    {
        return static::$table_name;
    }

    private static function check_fields()
    {
        array_push(static::$fields, static::$key_field);
        array_push(static::$read_only_fields, static::$key_field);
    }

    static function read()
    {
        self::check_fields();
        $db = static::db();
        $query = sprintf('select %s from %s ', implode(",", static::$fields), static::$table_name);
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

    function destroy($id)
    {
        $db = static::db();
        $query = sprintf('delete from %s where %s = %s', static::$table_name, static::$key_field, $id);
        return $db->query($query);;
    }

    function update($id, array $data)
    {
        #TODO extract validate
        self::check_fields();
        $validated_data = [];
        foreach ($data as $key => $value) {
            if (in_array($key, static::$fields) and !in_array($key, static::$read_only_fields)) {
                if (!is_numeric($value)) {
                    $validated_data[$key] = '\'' . addslashes($value) . '\'';
                }
            }
        }
        $p_string = urldecode(http_build_query($validated_data, '', ','));

        $db = static::db();
        $query = sprintf('Update %s set %s where %s = %s', static::$table_name, $p_string, static::$key_field, $id);
        return $db->query($query);;
    }

    function create(array $data)
    {
        #TODO extract validate
        self::check_fields();
        $validated_data = [];
        foreach ($data as $key => $value) {
            if (in_array($key, static::$fields) and !in_array($key, static::$read_only_fields)) {
                if (!is_numeric($value)) {
                    $validated_data[$key] = '\'' . addslashes($value) . '\'';
                }
            }
        }
        $p_fields = implode(', ', array_keys($validated_data));
        $p_values = implode(', ', $validated_data);
        $db = static::db();
        $query = sprintf('insert into %s(%s) values(%s) ', static::$table_name, $p_fields, $p_values);
        return $db->query($query);;
    }


}