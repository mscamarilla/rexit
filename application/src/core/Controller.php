<?php


namespace Core;


/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * @var object
     */
    protected $view;
    /**
     * @var array|string
     */
    protected $get;

    /**
     * Controller constructor.
     * @param object $view
     */
    function __construct(object $view)
    {
        $view_name = str_replace('Controller', 'View', implode('', array_slice(explode('\\', get_class($this)), -1)));

        $this->view = $view;
        $this->view->setViewName($view_name . '.tpl');

        $this->get = $this->clean($_GET);

    }

    /**
     * Create dynamic Model
     * @param string $model_alias
     */
    protected function loadModel(string $model_alias): void
    {
        $model_name = $this->renameModel($model_alias);

        $this->$model_alias = new $model_name;

    }

    /**
     * Rename model
     * @param string $model_alias
     * @return string
     */
    protected function renameModel(string $model_alias): string
    {
        $model_name_parts = explode('_', $model_alias);

        foreach ($model_name_parts as $value) {
            $model_name_array[] = ucfirst($value);
        }

        $model_name = '\Model\\' . implode('', $model_name_array);

        return $model_name;

    }

    /**
     * Trimming data for $_GET
     * @param mixed $data
     * @return array|string
     */
    protected function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset ($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }
        return $data;
    }


}
