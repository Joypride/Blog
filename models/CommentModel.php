<?php

namespace Models;
use Utils\Tools;

class CommentModel extends Model {

    public function read($id)
    {
        $request = self::getDatabaseInstance()->prepare("SELECT c.*, u.id, u.name, u.surname, u.photo FROM comment c LEFT JOIN user u ON c.user_id = u.id LEFT JOIN post p ON c.post_id = p.id WHERE p.id = :id ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
        $request->bindValue(':id', $id);
        return $request->execute();
    }

    public function create($comment)
    {
        $request = self::getDatabaseInstance()->prepare("INSERT INTO comment SET date = NOW(), content = :content, user_id = :user, post_id = :post");
        $request->bindValue(':content', $comment['content']);
        $request->bindValue(':user', $comment['user']);
        $request->bindValue(':post', $comment['post']);
        $request->execute();
    }

    // Tous les commentaires en attente de validation
    public function allPending()
    {
        return self::getDatabaseInstance()->query("SELECT c.*, p.id as p_id, p.image FROM comment c LEFT JOIN post p ON c.post_id = p.id WHERE c.status = 'pending' ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Nombre de commentaires en attente de validation
    public function countAllPending()
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*) FROM comment WHERE status = 'pending'")->fetchColumn();
    }

    public function validate($id)
    {
        $request = self::getDatabaseInstance()->prepare("UPDATE comment SET status = 'validated' WHERE id = :id");
        $request->bindValue(':id', $id);
        return $request->execute();
    }

    // Commentaires validés
    public function validated($id)
    {
        return self::getDatabaseInstance()->query("SELECT c.*, u.id, u.name, u.surname, u.photo FROM comment c LEFT JOIN user u ON c.user_id = u.id LEFT JOIN post p ON c.post_id = p.id WHERE p.id = ".$id." AND c.status = 'validated' ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function delete($id)
    {
        $request = self::getDatabaseInstance()->prepare("DELETE FROM comment WHERE id = :id");
        $request->bindValue(':id', $id);
        return $request->execute();
    }
}
