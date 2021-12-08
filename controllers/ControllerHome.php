<?php 

class Home extends Controller {

    public function default() {
        return $this->indexAction();
    }

    public function indexAction() {
        return $this->render('index.html.twig');
    }

    public function run() {
        $action = $this->action.'Action';
        return $this->{$action}();
    }
}