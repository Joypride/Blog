<?php

namespace Models;
use Utils\Tools;

class CategoryModel extends Model {

    public function read()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM category")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Catégorie associée à un article
    public function category()
    {
        return self::getDatabaseInstance()->query("SELECT DISTINCT c.*, p.category_id FROM category c LEFT JOIN post p ON p.category_id = c.id")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create($name)
    {
        $request = self::getDatabaseInstance()->prepare("INSERT INTO category SET title = :name");
        $request->bindValue(':name', $name);
        $request->execute();
    }

    public function delete($id)
    {
        $request = self::getDatabaseInstance()->prepare("DELETE FROM category WHERE id = :id");
        $request->bindValue(':id', $id);
        return $request->execute();
    }
}
