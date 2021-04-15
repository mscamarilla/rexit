<?php


namespace Controller;


use Core\Controller;

/**
 * Class ControllerIndex
 * @package Controller
 */
class ControllerIndex extends Controller
{
    /**
     * Main page controller
     */
    public function actionIndex()
    {
        $this->loadModel('model_index');

        $isTablesExist = $this->model_index->checkTables();

        if (!$isTablesExist) {
            $this->import();
        }

        header(sprintf("Location: %s", 'index.php?route=users/index'));

    }

    /**
     * Import data from file to database tables
     */
    private function import()
    {
        $filePath = '/application/dataset.txt';
        $this->model_index->import($filePath);

    }

}
