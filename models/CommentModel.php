<?php

namespace Models;

class CommentModel extends Model {

    public function read($id)
    {
        return self::getDatabaseInstance()->query("SELECT c.*, u.name, u.surname, u.photo FROM comment c LEFT JOIN user u ON c.user_id = u.id LEFT JOIN post p ON c.post_id = p.id WHERE p.id = ".$id." ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
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