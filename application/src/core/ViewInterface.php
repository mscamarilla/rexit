<?php

namespace Core;

/**
 * Interface ViewInterface
 * @package Core
 */
interface ViewInterface
{
    /**
     * @param string $view_name
     * @return mixed
     */
    public function setViewName(string $view_name);

    /**
     * @param null $data
     * @return mixed
     */
    public function render($data = null);
}
