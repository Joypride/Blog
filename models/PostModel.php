<?php

namespace Models;

class PostModel extends Model {

    private $id;

    public function read()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function pending()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post WHERE status = 0 ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function validated()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post WHERE status = 1 ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create($post)
    {
        $r = self::getDatabaseInstance()->prepare("INSERT INTO post SET title = :title, headline = :headline, image = :image, content = :content, creation_date = NOW()");
        $r->bindValue(':title', $title);
        $r->bindValue(':headline', $headline);
        $r->bindValue(':image', $image);
        $r->bindValue(':content', $content);
        $r->execute();
    }

    public function find($id)
    {
        $q = self::getDatabaseInstance()->prepare("SELECT p.*, u.id, u.surname, u.name, u.photo, c.id, c.title as c_title FROM post p LEFT JOIN user u ON p.user_id = u.id LEFT JOIN category c ON p.category_id = c.id WHERE p.id = :id");
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        $q->execute();
        return $q->fetch();
    }

    public function edit($post)
    {
        $r = self::getDatabaseInstance()->prepare("UPDATE post SET title = :title, headline = :headline, image = :image, content = :content, creation_date = :creation_date, update_date = NOW() WHERE id = :id");
        $r->bindValue(':title', $title);
        $r->bindValue(':content', $content);
        $r->bindValue(':publication', $publication);
        $r->bindValue(':id', $id);
        return $r->execute();
    }

    public function delete($id)
    {
        $r = self::getDatabaseInstance()->prepare("DELETE FROM post WHERE id =".$id.";");
        return $r->execute();
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}