<?php 

namespace Controllers;

use Models\CategoryModel;

class CategoryController extends Controller {

    public function default() {
        return $this->render('super_admin.html.twig');
    }

    public function addAction() {
        if(isset($_POST['category'])) {
            $tag = new CategoryModel();
            $name = $_POST['category'];
            
            $tag->create($name);

            header('Location: ?controller=user&action=adminPost');
        }
    }

    public function deleteAction()
    {
        $tag = new CategoryModel();
        $id = (int)$_GET['id'];
        $tag->delete($id);
        header('Location: ?controller=user&action=adminPost');
    }
}
