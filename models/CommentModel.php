<?php

namespace Models;

class CommentModel extends Model {

    public function read($id)
    {
        return self::getDatabaseInstance()->query("SELECT c.*, u.id, u.name, u.surname, u.photo FROM comment c LEFT JOIN user u ON c.user_id = u.id LEFT JOIN post p ON c.post_id = p.id WHERE p.id = ".$id." ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create($comment)
    {
        $r = self::getDatabaseInstance()->prepare("INSERT INTO comment SET date = NOW(), content = :content, user_id = :user, post_id = :post");
        $r->bindValue(':content', $comment['content']);
        $r->bindValue(':user', $comment['user']);
        $r->bindValue(':post', $comment['post']);
        $r->execute();
    }

    public function allPending()
    {
        return self::getDatabaseInstance()->query("SELECT c.*, p.id as p_id, p.image FROM comment c LEFT JOIN post p ON c.post_id = p.id WHERE c.status = 'pending' ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function validate($id)
    {
        $r = self::getDatabaseInstance()->prepare("UPDATE comment SET status = 'validated' WHERE id = :id");
        $r->bindValue(':id', $id);
        return $r->execute();
    }

    public function delete($id)
    {
        $r = self::getDatabaseInstance()->prepare("DELETE FROM comment WHERE id =".$id.";");
        return $r->execute();
    }
}