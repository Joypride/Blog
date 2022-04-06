<?php 

namespace Controllers;

use Models\CommentModel;
use Utils\Tools;

class CommentController extends Controller {

    public function default() {
        return $this->render('super_admin.html.twig');
    }

    public function addAction() {
        if(Tools::getValue('category')) {
            $tag = new CommentModel();
            $name = Tools::getValue('category');
            
            $tag->create($name);

            header('Location: /user/adminPost');
        }
    }

    public function deleteCommentAction() {
        $comment = new CommentModel();
        $id = (int)Tools::getValue('id');
        $comment->delete($id);
        header('Location: /user/superAdmin');
    }

    public function validateAction() {
        $comment = new CommentModel();
        $id = (int)Tools::getValue('id');
        $comment->validate($id);
        header('Location: /user/superAdmin');
    }
}
