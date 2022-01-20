<?php

namespace Models;

class PostModel extends Model {

    private $id;
    private $title;
    private $headline;
    private $image;
    private $content;

    public function read()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function pending()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post WHERE status = 0 ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function countPending()
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*) FROM post WHERE status = 0")->fetchAll(\PDO::FETCH_NUM);
    }

    public function validated()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post WHERE status = 1 ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function countValidated()
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*) FROM post WHERE status = 1")->fetchAll(\PDO::FETCH_NUM);
    }

    public function category()
    {
        return self::getDatabaseInstance()->query("SELECT DISTINCT c.*, p.category_id FROM category c LEFT JOIN post p ON p.category_id = c.id")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function create(array $post)
    {
        $r = self::getDatabaseInstance()->prepare("INSERT INTO post SET title = :title, headline = :headline, image = :image, content = :content, user_id = :user, category_id = :category, creation_date = NOW()");
        $r->bindValue(':title', $post['title']);
        $r->bindValue(':headline', $post['headline']);
        $r->bindValue(':content', $post['content']);
        $r->bindValue(':image', $post['image']);
        $r->bindValue(':user', $post['user']);
        $r->bindValue(':category', $post['category']);
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
        $r = self::getDatabaseInstance()->prepare("UPDATE post SET title = :title, headline = :headline, image = :image, content = :content, update_date = NOW() WHERE id = :id");
        $r->bindValue(':title', $title);
        $r->bindValue(':content', $content);
        $r->bindValue(':headline', $headline);
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

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of headline
     */ 
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set the value of headline
     *
     * @return  self
     */ 
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}