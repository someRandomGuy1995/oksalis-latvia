<?php

class sql
{
    private $query;
    private $host;
    private $name;
    private $pass;
    private $data;
    public $cn;
    public $runQuery;
    private $is_select;

    public function __construct()
    {
        $this->setQuery();
        $this->host = cmsconfig::$host;
        $this->name = cmsconfig::$name;
        $this->pass = cmsconfig::$pass;
        $this->data = cmsconfig::$data;
        $this->cn = new mysqli($this->host, $this->name, $this->pass, $this->data);
    }

    public function setQuery()
    {
        $this ->query['select'] = "";
        $this ->query['insert'] = "";
        $this ->query['limit'] = "";
        $this ->query['update'] = "";
        $this ->query['order'] = "";
        $this ->query['delete'] = "";
        $this ->query['columns'] = "";
        $this ->query['values'] = "";
        $this ->query['set'] = "";
        $this ->query['where'] = "";
        $this ->is_select = false;
    }

    public function select($array="*")
    {

            $this->is_select = true;
            if ($array == "*") {
                $this->query['select'] = $array;
            } else {
                if (is_array($array))
                {
                    for ($i = 0; $i < count($array); $i++)
                    {
                        $array[$i] = preg_replace("/[^a-zA-Z0-9_]/", "", $array[$i]);
                        $array[$i] = "`" . $array[$i] . "`";
                    }
                    $this->query['select'] = implode(", ", $array);
                }
            }
    }

    public function orderBy($columnName, $order = 'ASC')
    {
        if (!empty($columnName)) {

            $columnName = mysqli_real_escape_string($this->cn , $columnName);
            $order = mysqli_real_escape_string($this->cn , $order);

            $this->query['order'] = $columnName . ' ' . $order;
        }
    }

    public function from($array)
    {
        if ($array != "")
        {
            if (is_array($array))
            {
                for ($i=0;$i<count($array);$i++)
                {
                    $array[$i] = preg_replace("/[^a-zA-Z0-9_āīščņķļēūžĀĪŠČŅĶĻĒŪŽ]/", "", $array[$i]);
                    $array[$i] = mysqli_real_escape_string($this->cn , $array[$i]);
                    $array[$i] = "`".$array[$i]."`";
                }
            }
        }
        $this->query['from'] = implode(",",$array);
    }



    public function where($new_array,$act,$bool="")
    {
        $array = array();
        foreach ($new_array as $key => $value)
        {
            $key = preg_replace("/[^a-zA-Z0-9_@.āīščņķļēūžĀĪŠČŅĶĻĒŪŽ ]/", "", $key);
            $key = mysqli_real_escape_string($this->cn , $key);
            $value = mysqli_real_escape_string($this->cn , $value);
            $array[$key] = $value;
        }

        if (is_string($array[key($array)]))
        {
            $act = preg_replace("/[^=<>]/", "", $act);
            $act = mysqli_real_escape_string($this->cn , $act);
            $bool = preg_replace("/[^a-zA-Z]/", "", $bool);
            $bool = mysqli_real_escape_string($this->cn , $bool);
            $this->query['where'] .= $bool." `".key($array)."` ".$act." '".$array[key($array)]."' ";
        }
        else
        {
            $act = preg_replace("/[^=<>]/", "", $act);
            $act = mysqli_real_escape_string($this->cn , $act);
            $bool = preg_replace("/[^a-zA-Z]/", "", $bool);
            $bool = mysqli_real_escape_string($this->cn , $bool);
            $this->query['where'] .= $bool." `".key($array)."` ".$act." `".$array[key($array)]."` ";
        }
    }

    public function insert($table)
    {
        if ($table != "")
        {
            $table = preg_replace("/[^a-zA-Z0-9_@. āīščņķļēūžĀĪŠČŅĶĻĒŪŽ,]/", "", $table);
            $table = mysqli_real_escape_string($this->cn , $table);
            $this->query['insert'] = "`".$table."`";
        }
    }

    public function limit($arg1, $arg2)
    {
            $arg1 = preg_replace("/[^0-9_]/", "", $arg1);
            $arg1 = mysqli_real_escape_string($this->cn, $arg1);
            $arg2 = preg_replace("/[^0-9_]/", "", $arg2);
            $arg2 = mysqli_real_escape_string($this->cn, $arg2);
            $this->query['limit'] = $arg1.", " . $arg2;
    }

    public function columns($array)
    {
        if ($array != "")
        {
            for ($i=0;$i<count($array);$i++)
            {
                $array[$i] = preg_replace("/[^a-zA-Z0-9_]/", "", $array[$i]);
                $array[$i] = "`".$array[$i]."`";
                $array[$i] = mysqli_real_escape_string($this->cn, $array[$i]);
                next($array);
            }
        }
        $this->query['columns'] = " (".implode(",",$array).") ";
    }

    public function values($array)
    {
        if ($array != "")
        {
            for ($i=0;$i<count($array);$i++)
            {
                $array[$i] = preg_replace("/[^a-zA-Z0-9_@.āīščņķļēūžĀĪŠČŅĶĻĒŪŽ, ]/", "", $array[$i]);
                $array[$i] = mysqli_real_escape_string($this->cn , $array[$i]);
                $array[$i] =  "'".$array[$i]."'";
            }
        }
        $this->query['values'] = " (".implode(",",$array).")";
    }

    public function update($table)
    {
        $table = preg_replace("/[^a-zA-Z0-9_@.āīščņķļēūžĀĪŠČŅĶĻĒŪŽ, ]/", "", $table);
        $table = mysqli_real_escape_string($this->cn , $table);
        $this->query['update'] = "`".$table."`";
    }

    public function set($new_array)
    {
        $array = array();
        foreach ($new_array as $key => $value)
        {
            $new_array[$key] = mysqli_real_escape_string ($this->cn , $new_array[$key]);
            $key = preg_replace("/[^a-zA-Z0-9_@.āīščņķļēūžĀĪŠČŅĶĻĒŪŽ, ]/", "", $key);
            $value = preg_replace("/[^a-zA-Z0-9_@.āīščņķļēūžĀĪŠČŅĶĻĒŪŽ, ]/", "", $value);
            $array[$key] = $value;
        }

        foreach ($array as $key => $value)
        {
            $this->query['set'] = $this->query['set']."`".$key."` = "."'".$value."'".", ";
        }
        $this->query['set'] = substr_replace($this->query['set'] ,"",-2);
    }

    public function delete($table)
    {
        $table = preg_replace("/[^a-zA-Z0-9_āīščņķļēūžĀĪŠČŅĶĻĒŪŽ ]/", "", $table);
        $table = mysqli_real_escape_string($this->cn , $table);
        $this->query['delete'] ="`".$table."`";
    }

    public function runQuery()
    {
        if ($this->is_select)
        {
            $query = "SELECT " . $this->query['select'] . " FROM " . $this->query['from'];
            if (!empty($this->query['where'])) {
                $query .= " WHERE " . $this->query['where'];
            }

            if (!empty($this->query['order'])) {
                $query .= " ORDER BY " . $this->query['order'];
            }

            if (!empty($this->query['limit'])) {
                $query .= " LIMIT " . $this->query['limit'];
            }

            $this->runQuery = $query;
        }

        else if ($this->query['insert'] != "")
        {
            if ($this->query['columns'] == "")
            {$this->runQuery =  "INSERT INTO ".$this->query['insert']." VALUES ".$this->query['values'];}
            else
            {$this->runQuery =  "INSERT INTO ".$this->query['insert'].$this->query['columns']."VALUES ".$this->query['values'];}
        }

        else if ($this->query['update'] != "")
        {
            if ($this->query['where'] == "")
            {
                $this->runQuery = "UPDATE " . $this->query['update']." SET ". $this->query['set'];
            }
            else
            {
                $this->runQuery = "UPDATE " . $this->query['update']." SET ". $this->query['set']." WHERE ".$this->query['where'];
            }
        }

        else
        {
            $this->runQuery = "DELETE FROM ".$this->query['delete']." WHERE ".$this->query['where'];
        }

        $this->runQuery = $this->runQuery.";";

//        echo $this->runQuery; ///////////////////////////////////////////////////////////////////////////ECHO RUNQUERY

        $a = $this->cn->query($this->runQuery);

        $result = $a;

        if ($this->is_select && $result)
        {
            $result = array();
            while ($obj = $a->fetch_object())
            {
               $result[] = $obj;
            }

        }

        $this -> setQuery();

        return $result;
    }

    public function install()
    {

        $sql[0] = <<<SQL
        CREATE TABLE `User`(
        `id` INT(11) AUTO_INCREMENT,
        `username` VARCHAR(50),
        `password` VARCHAR(50),
        `sait` VARCHAR(50),
        `name` VARCHAR(50),
        `surname` VARCHAR(50),
        `date` DATETIME,
        `is_admin` INT(11),
        PRIMARY KEY(id))
SQL;

        $pass = md5('admin');
        $sql[1] = <<<SQL
        INSERT INTO `User` (`username` , `password`, `sait`, `name`, `surname`, `date`, `is_admin`)
        VALUES ('admin' , "$pass" , 'sitename' , 'Rett' , 'Butler' , CURRENT_TIMESTAMP, '1')
SQL;

        $sql[2] = "CREATE TABLE `ResourceType`(
        `id` INT(11) AUTO_INCREMENT,
        `title` VARCHAR(50),
        `slug` VARCHAR(50),
        PRIMARY KEY(id),
        UNIQUE (`slug`)
        )";



        $sql[3] = "CREATE TABLE `Category`(
        `id` INT(11) AUTO_INCREMENT,
        `name` VARCHAR(255),
        `slug` VARCHAR(255),
        `type` VARCHAR(255),
        PRIMARY KEY(id)
        )";



        $sql[4] = "CREATE TABLE `Resource`(
        `id` INT(11) AUTO_INCREMENT,
        `type` VARCHAR(50),
        `slug` VARCHAR(50),
        `title` VARCHAR(50),
        `parent` INT(11),
        `author` INT(11),
        `order` INT(11),
        `date` DATETIME,
        CONSTRAINT auth FOREIGN KEY (`author`) REFERENCES `User`(`id`),
        CONSTRAINT slug FOREIGN KEY (`slug`) REFERENCES `ResourceType`(`slug`),
        PRIMARY KEY(id)
        )";


        $sql[5] = "CREATE TABLE `ResourceMeta`(
        `id` INTEGER(11) AUTO_INCREMENT,
        `resource_id` INT(11),
        `key` VARCHAR(255),
        `value` TEXT,
        CONSTRAINT res_id FOREIGN KEY (`resource_id`) REFERENCES `Resource`(`id`),
        PRIMARY KEY(id)
        )";


        $sql[6] = "CREATE TABLE `Category_Resource`(
        `category_id` INT(11),
        `resource_id` INT(11),
        CONSTRAINT cat FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`),
        CONSTRAINT res FOREIGN KEY (`resource_id`) REFERENCES `Resource`(`id`)
        )";

        $sql[7] = "CREATE TABLE `Option`(
    `id` INT(11) AUTO_INCREMENT,
    `key` VARCHAR(255),
    `value` TEXT,
    PRIMARY KEY(id)
    )";

        $sql[8] = "CREATE TABLE `File`(
    `id` INT(11) AUTO_INCREMENT,
    `title` VARCHAR(255),
    `alias` VARCHAR(255),
    `format` VARCHAR(255),
    `type` VARCHAR(255),
    `dir` VARCHAR(255),
    `date` DATETIME,
    `author` INT(11),
    PRIMARY KEY(id)
    )";

        $sql[9] = <<<SQL
        INSERT INTO `ResourceType` (`slug`, `title`)
        VALUES ('post','Post')
SQL;

        $sql[10] = <<<SQL
        CREATE TABLE `student`(
        `id` INT(11) AUTO_INCREMENT,
        `name` VARCHAR(50),
        `surname` VARCHAR(50),
        `birthdate` DATETIME(50),
        `phone` VARCHAR(50),
        `email` VARCHAR(50),
        `photo` DATETIME,
        `thisdate` INT(11),
        PRIMARY KEY(id))
SQL;

      foreach ($sql as $s)
      {
          $this->cn->query($s);
      }
    }
}
$sql = new sql;
