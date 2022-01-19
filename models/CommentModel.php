<?php

namespace Models;

class CommentModel extends Model {

    public function read()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM comment ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create($comment)
    {
        $r = self::getDatabaseInstance()->prepare("INSERT INTO comment SET date = NOW(), content = :content");
        $r->bindValue(':content', $content);
        $r->execute();
    }

    public function delete($id)
    {
        $r = self::getDatabaseInstance()->prepare("DELETE FROM comment WHERE id =".$id.";");
        return $r->execute();
    }
}