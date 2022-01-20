<?php

namespace Controllers;

use Models\PostModel;

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
        $id = (int)$_GET['id'];
        return $this->render('single_post.html.twig', [
            'single' => $m->find($id),
        ]);
    }

    public function addAction()
    {
        $m = new PostModel();
        return $this->render('add_post.html.twig', [
            'category' => $m->category(),
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
        $m = new PostModel();
        $id = (int)$_GET['id'];
        return $this->render('edit_post.html.twig', ['post' => $m->find($id), 'category' => $m->category()]);
    }

    public function updateAction()
    {
        $m = new PostModel();
        if (!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['headline']) && !empty($_POST['content']))
        {
            $up = new Article($_POST);
            $m->update($up);
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
}