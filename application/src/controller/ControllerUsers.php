<?php


namespace Controller;

use Core\Controller;
use Core\Pagination;


/**
 * Class ControllerUsers
 * @package Controller
 */
class ControllerUsers extends Controller
{
    /**
     * Users page controller
     */
    public function actionIndex()
    {
        $this->loadModel('model_users');

        /*define variables*/
        $currentUrl = 'index.php?route=users/index';
        $data['filterCategory'] = '';
        $data['filterGender'] = '';
        $data['filterbirthDate'] = '';
        $data['filterAge'] = '';
        $data['filterAgesFrom'] = 0;
        $data['filterAgesTo'] = 1000;


        if (isset($this->get['page'])) {
            $page = $this->get['page'];
        } else {
            $page = 1;
        }

        /*filters start*/
        $filters = array();

        if (isset($this->get['category'])) {
            $filters['category'] = $this->get['category'];
            $currentUrl .= '&category=' . $this->get['category'];
            $data['filterCategory'] = $this->get['category'];
        }

        if (isset($this->get['gender'])) {
            $filters['gender'] = $this->get['gender'];
            $currentUrl .= '&gender=' . $this->get['gender'];
            $data['filterGender'] = $this->get['gender'];
        }

        if (isset($this->get['birthDate'])) {
            $filters['birthDate'] = $this->get['birthDate'];
            $currentUrl .= '&birthDate=' . $this->get['birthDate'];
            $data['filterbirthDate'] = $this->get['birthDate'];
        }

        if (isset($this->get['age'])) {
            $filters['age'] = $this->get['age'];
            $currentUrl .= '&age=' . $this->get['age'];
            $data['filterAge'] = $this->get['age'];
        }

        if (isset($this->get['ages'])) {
            $parts = explode("-", $this->get['ages']);
            $filters['agesFrom'] = $parts[0];
            $filters['agesTo'] = $parts[1];
            $currentUrl .= '&ages=' . $parts[0] . '-' . $parts[1];
            $data['filterAgesFrom'] = $parts[0];
            $data['filterAgesTo'] = $parts[1];
        }
        /*filters end */

        $limit = 100;

        /*categories in filter start*/
        $categories = array();

        $categoriesData = $this->model_users->getCategories();

        foreach ($categoriesData as $categoryData) {
            $categories[] = array(
                'name' => $categoryData,
                'value' => $currentUrl . '&category=' . $categoryData,
            );

        }
        /*categories in filter end*/

        /*genderss in filter start*/
        $genders = array();

        $gendersData = $this->model_users->getGenders();

        foreach ($gendersData as $genderData) {
            $genders[] = array(
                'name' => $genderData,
                'value' => $currentUrl . '&gender=' . $genderData,
            );

        }
        /*genders in filter end*/

        /*pagination start*/
        $pagination = new Pagination;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $totalUsers = $this->model_users->GetTotalUsers($filters);
        $pagination->total = $totalUsers;
        $pagination->url = $currentUrl;
        /*pagination end*/

        /*data for display in view start*/
        $data['pagination'] = $pagination->render();
        $data['currentUrl'] = $currentUrl;
        $data['exportUrl'] = str_replace('users/index', 'users/export', $currentUrl);
        $data['categories'] = $categories;
        $data['genders'] = $genders;
        $data['users'] = $this->model_users->getUsers($page, $limit, $filters);
        /*data for display in view end*/

        $this->view->render($data);

    }

    /**
     * Export filtered data into file
     */
    public function actionExport()
    {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="datasetExport.csv";');

        $this->loadModel('model_users');
        /*filters start*/
        $filters = array();

        if (isset($this->get['category'])) {
            $filters['category'] = $this->get['category'];
        }

        if (isset($this->get['gender'])) {
            $filters['gender'] = $this->get['gender'];
        }

        if (isset($this->get['birthDate'])) {
            $filters['birthDate'] = $this->get['birthDate'];
        }

        if (isset($this->get['age'])) {
            $filters['age'] = $this->get['age'];
        }

        if (isset($this->get['ages'])) {
            $parts = explode("-", $this->get['ages']);
            $filters['agesFrom'] = $parts[0];
            $filters['agesTo'] = $parts[1];
        }
        /*filters end*/

        /*users = lines start*/
        $users = $this->model_users->getUsers(false, false, $filters); //get all users by filter without limits

        $output = '';

        if (!empty($users)) {
            /*headers start*/
            unset($users[0]['id']);
            $columnHeaders = array_keys($users[0]);

            foreach ($columnHeaders as $header) {
                $output .= $header;

                if (next($columnHeaders)) {
                    $output .= ',';
                }
            }

            $output .= "\n";
            /*headers end*/

            /*lines start*/
            foreach ($users as $user) {
                unset($user['id']);

                foreach ($user as $key => $value) {
                    $output .= $value;

                    if (next($user)) {
                        $output .= ',';
                    }
                }

                $output .= "\n";
            }
            /*lines end*/

        }
        /*file generation*/
        $csvHandler = fopen('php://output', 'w');
        fwrite($csvHandler, $output);
        fclose($csvHandler);
    }

}
