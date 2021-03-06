<?php

namespace Models;
use Utils\Tools;

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

    // Articles en attente de validation associés à l'utilisateur
    public function pending($id)
    {
        return self::getDatabaseInstance()->query("SELECT p.*, u.id as u_id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = 0 AND u.id = ".$id." ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Tous les articles en attente de validation
    public function allPending()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM post WHERE status = 0 ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Nombre d'articles associés à l'utilisateur en attente de validation
    public function countPending($id)
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*), p.user_id, u.id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = 0 AND u.id = ".$id."")->fetchColumn();
    }

    // Nombre d'articles en attente de validation
    public function countAllPending()
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*) FROM post WHERE status = 0")->fetchColumn();
    }

    // Articles validés
    public function validated($id)
    {
        return self::getDatabaseInstance()->query("SELECT p.*, u.id as u_id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = 1 AND u.id = ".$id." ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Nombre d'articles validés
    public function countValidated($id)
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*), p.user_id, u.id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = 1 AND u.id = ".$id."")->fetchColumn();
    }

    // Articles refusés
    public function refused($id)
    {
        return self::getDatabaseInstance()->query("SELECT p.*, u.id as u_id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = -1 AND u.id = ".$id." ORDER BY creation_date DESC")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    // Nombre d'articles refusés
    public function countRefused($id)
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*), p.user_id, u.id FROM post p LEFT JOIN user u ON p.user_id = u.id WHERE status = -1 AND u.id = ".$id."")->fetchColumn();
    }

    public function create(array $post)
    {
        $request = self::getDatabaseInstance()->prepare("INSERT INTO post SET title = :title, headline = :headline, image = :image, content = :content, user_id = :user, category_id = :category, creation_date = NOW()");
        $request->bindValue(':title', $post['title']);
        $request->bindValue(':headline', $post['headline']);
        $request->bindValue(':content', $post['content']);
        $request->bindValue(':image', $post['image']);
        $request->bindValue(':user', $post['user']);
        $request->bindValue(':category', $post['category']);
        $request->execute();
    }

    public function find($id)
    {
        $request = self::getDatabaseInstance()->prepare("SELECT p.*, p.id as post_id, u.id, u.surname, u.name, u.photo, c.title as c_title FROM post p LEFT JOIN user u ON p.user_id = u.id LEFT JOIN category c ON p.category_id = c.id WHERE p.id = :id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetch();
    }

    public function edit($id, $post)
    {
        $data = [];
        foreach ($post as $k => $v) {
            $data[]="$k = :$k";
        }
        $request = self::getDatabaseInstance()->prepare("UPDATE post SET ".implode(',', $data).", update_date = NOW() WHERE id = :id");
        $request->bindValue(':id', $id);

        foreach ($post as $k => $v) {
            $request->bindValue(":$k", $v);
        }
        return $request->execute();
    }

    // Valider un article
    public function validatePost($id)
    {
        return self::getDatabaseInstance()->query("UPDATE post SET status = 1 WHERE id = ".$id."");
    }

    public function delete($id)
    {
        return self::getDatabaseInstance()->query("DELETE FROM post WHERE id = ".$id."");
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
