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

    public static function key_field()
    {
        return static::$key_field;
    }

    function escape($db, $data)
    {
        #escape and quoted
        foreach ($data as $key => &$value) {
            if (gettype($value) == 'string') {
                $value = "'" . mysqli_real_escape_string($db, $value) . "'";
            }
        }
        return $data;
    }

    private static function check_fields()
    {
        array_push(static::$fields, static::$key_field);
        array_push(static::$read_only_fields, static::$key_field);
    }

    static function collect_filter($db, $filter, $logical = 'AND')
    {
        if ($logical == 'AND') $is_and = true; else $is_and = false;
        if ($logical == 'OR') $is_or = true; else $is_or = false;
        if ($logical == 'NOT') $is_not = true; else $is_not = false;

        $where = '';
        $i = -1;
        if ($filter) {
            foreach ($filter as $key => $value) {
                $i++;
                if ($i == 0) {
                    if ($is_not) $where .= ' not ';
                    $where .= '(';
                }
                if ($i > 0) {
                    if ($is_or) $where .= ' or ';
                    else $where .= ' and ';
                }
                if ($key == '&&') {
                    $where .= static::collect_filter($db, $filter['&&'], 'AND');
                    continue;
                }
                if ($key == '||') {
                    $where .= static::collect_filter($db, $filter['||'], 'OR');
                    continue;
                }
                if ($key == '!=') {
                    $where .= static::collect_filter($db, $filter['!='], 'NOT');
                    continue;
                }

                if ($e = explode('__', $key)) {
                    $suffix = array_pop($e);
                    if ($suffix == 'icontains') {
                        $value = mysqli_real_escape_string($db, $value);
                        $where .= implode($e) . " like '%$value%'";
                    } else {
                        if (gettype($value) == 'string') {
                            $where .= $key . "='" . mysqli_real_escape_string($db, $value) . "'";
                        } else {
                            $where .= $key . "=" . $value . "";
                        }

                    }
                }

            }
            $where .= ')';
        }
        return $where;
    }

    static function read($filter = [])
    {
        self::check_fields();
        $db = static::db();
        $where = '';
        if ($filter) $where .= ' where ' . static::collect_filter($db, $filter);

        $orders = '';
        if (static::$orders) {
            $orders = 'order by ' . static::$orders;
        }
        $query = sprintf('select %s from %s %s %s ',
            implode(",", static::$fields),
            static::$table_name,
            $where,
            $orders);

        $stmt = $db->query($query);

        $data = [];
        if ($stmt) {
            while ($row = $stmt->fetch_assoc()) {
                $item = [];
                foreach (static::$fields as &$field) {
                    $item[$field] = $row[$field];
                }
                array_push($data, $item);
            }
        } else return false;

        return $data;

    }

    static function retrieve($id)
    {
        return static::read([static::$key_field => $id]);
    }

    static function destroy(array $filter)
    {
        $db = static::db();
        $where = '';
        if ($filter) $where .= ' where ' . static::collect_filter($db, $filter);
        if (!$where) return false;
        $item = static::read($filter);
        if (!$item) return false;
        $query = sprintf('delete from %s %s', static::$table_name, $where);
        if ($db->query($query)) {
            return $item;
        } else
        return false;
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

    static function update(array $filter, array $data)
    {
        $db = static::db();
        $data = static::escape($db, $data);
        $where = '';
        if ($filter) $where .= ' where ' . static::collect_filter($db, $filter);
        $p_string = urldecode(http_build_query($data, '', ','));
        if (!$where) return false;

        $query = sprintf('Update %s set %s %s', static::$table_name, $p_string, $where);
        if ($db->query($query)) {
            return static::read($filter);
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