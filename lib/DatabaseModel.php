<?php

class DatabaseModel
{
    public function attributes()
    {
        $string = [];
        foreach ($this->dbFields as $field) {
            $string[] = "$field = :$field";
        }
        return implode(', ', $string);
    }

    public  static function read($sql, $type = PDO::FETCH_ASSOC, $class = null, $params = null)
    {
        global $dbh;
        $stmt = $dbh->prepare($sql);
        if (count($params)) {
            $x = 1;
            foreach ($params as $param) {
                $stmt->bindValue($x, $param);
                $x++;
            }
        }

        if ($stmt->execute()) {
            if ($class != null && $type == PDO::FETCH_CLASS) {
                $data = $stmt->fetchAll($type, $class);
            } else {
                $data = $stmt->fetchAll($type);
            }

            if (count($data) == 1) {
                $data = array_shift($data);
            }
            return $data;
        } else {
            return false;
        }
    }

    public function add()
    {
        global $dbh;
        $sql = "INSERT INTO {$this->tableName} SET " . $this->attributes();
        try {
            $stmt = $dbh->prepare($sql);
            foreach ($this->dbFields as $field) {
                if ($this->$field == null ) {
                    $this->$field = '';
                }
                $stmt->bindValue(':' . $field, $this->$field);
            }
           if ($stmt->execute()) {
               $this->id = $dbh->lastInsertId();
           } else {
               return false;
           }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return true;
    }

    public function update()
    {
        global $dbh;
        $sql = "UPDATE {$this->tableName} SET ". $this->attributes() ." WHERE id = " . $this->id;
        try {
            $stmt = $dbh->prepare($sql);
            foreach ( $this->dbFields as $field ) {
                if ($this->$field == null ) {
                    $this->$field = '';
                }
                $stmt->bindValue(':' . $field, $this->$field);
            }
            return $stmt->execute() == true ? true : false;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function delete() 
    {
        global $dbh;
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $this->id);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $stmt->execute() == true ? true : false;
    }

    public function save()
    {
        return $this->id == null ? $this->add() : $this->update();
    }
} 