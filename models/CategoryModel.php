<?php

namespace Models;

class CategoryModel extends Model {

    public function read()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM category")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function category()
    {
        return self::getDatabaseInstance()->query("SELECT DISTINCT c.*, p.category_id FROM category c LEFT JOIN post p ON p.category_id = c.id")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create($name)
    {
        $r = self::getDatabaseInstance()->prepare("INSERT INTO category SET title = :name");
        $r->bindValue(':name', $name);
        $r->execute();
    }

    public function delete($id)
    {
        $r = self::getDatabaseInstance()->prepare("DELETE FROM category WHERE id = :id");
        $r->bindValue(':id', $id);
        return $r->execute();
    }
}
