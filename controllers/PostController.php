<?php

namespace Controllers;

use Models\PostModel;
use Models\CommentModel;
use Models\CategoryModel;

class PostController extends Controller {
    
    public function default() {
        return $this->blogAction();
    }

    public function blogAction() {

        $m = new PostModel();
        $data = [
            'posts' => $m->read()
        ];
        return $this->render('blog.html.twig', $data);
    }

    public function singleAction() {
        $m = new PostModel();
        $c = new CommentModel();
        $id = (int)$_GET['id'];
        $content = false;

        if (isset($_POST['content'])) {
            if(!empty($_POST['content']) && (isset($_SESSION['id'])))
            {
            $comment = [
                'content' => $_POST['content'], 
                'post' => $_POST['id'],
                'user' => $_SESSION['id']
            ];
            $c->create($comment);
            } else if (!empty($_POST['content']) && !empty($_POST['name']) && !empty($_POST['surname']))
            {
            $comment = [
                'content' => $_POST['content'], 
                'post' => $_POST['id'],
                'user' => NULL
            ];
            $c->create($comment);
            }
            $content = 'Votre commentaire a bien été soumis et sera publié dès sa validation par un modérateur';
        }
        return $this->render('single_post.html.twig', [
            'single' => $m->find($id),
            'comments' => $c->validated($id),
            'content' => $content,
        ]);
    }

    public function addAction()
    {
        $category = new CategoryModel();
        return $this->render('add_post.html.twig', [
            'category' => $category->category(),
        ]);
    }

    public function insertAction() {

        if (!empty($_FILES)) {

            $dossier = 'public/img/';
            $fichier = basename($_FILES['image']['name']);
            $taille_maxi = 50000000;
            $taille = filesize($_FILES['image']['tmp_name']);
            $extensions = array('.png', '.gif', '.jpg', '.jpeg');
            $extension = strrchr($_FILES['image']['name'], '.');

            if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
                $erreur = 'Seuls les fichiers de type png, gif, jpg ou jpeg sont acceptés';
            }
            if($taille>$taille_maxi) {
                $erreur = 'Le fichier est trop volumineux';
            }
            if(!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
                //Formatage du nom du fichier
                $fichier = strtr($fichier,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);
                $path = './public/img/' . $fichier;
            }
            else {
                echo $erreur;
            }

            if(!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['headline']) && !empty($_POST['content'])) {
                $m = new PostModel();
                $post = [
                    'title' => $_POST['title'], 
                    'category' => $_POST['category'],
                    'headline' => $_POST['headline'],
                    'content' => $_POST['content'],
                    'user' => $_POST['id'],
                    'image' => $path,
                ];
                $m->create($post);
                header('Location: ?controller=user&action=adminPost');
            } else {
                header('Location: ?controller=post&action=add');
            }
        }
    }

    public function editAction()
    {
        $post = new PostModel();
        $tag = new CategoryModel();
        $id = (int)$_GET['id'];
        return $this->render('edit_post.html.twig', ['post' => $post->find($id), 'category' => $tag->category()]);
    }

    public function updateAction()
    {
        $m = new PostModel();
        if (!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['headline']) && !empty($_POST['content']))
        {
            //
        }
        return $this->render('edit_post.html.twig');
    }

    public function deleteAction()
    {
        $m = new PostModel();
        $id = (int)$_GET['id'];
        $m->delete($id);
        header('Location: ?controller=user&action=adminPost');
    }

    public function validatePostAction() {
        $post = new PostModel();
        $id = (int)$_GET['id'];
        $post->validatePost($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function deletePostAdminAction()
    {
        $post = new PostModel();
        $id = (int)$_GET['id'];
        $post->delete($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function commentAction() {
        $m = new CommentModel();

        if(!empty($_POST['content']) && is_null($_POST['id_user']))
        {
            $comment = [
                'content' => $_POST['content'], 
                'post' => $_POST['id'],
                'user' => $_POST['id_user']
            ];
            $m->create($comment);
        } else {
            $comment = [
                'content' => $_POST['content'], 
                'post' => $_POST['id'],
                'user' => NULL
            ];
            $m->create($comment);
        }
        header('Location: ?controller=user&action=');
    }
}