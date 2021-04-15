<?php


namespace Core;


/**
 * Class Pagination
 * @package Core
 */
class Pagination
{
    /**
     * @var int
     */
    public $total = 0;
    /**
     * @var int
     */
    public $page = 1;
    /**
     * @var int
     */
    public $limit = 100;
    /**
     * @var int
     */
    public $visibleLinks = 6;
    /**
     * @var
     */
    public $url;

    /**
     * @return string
     */
    public function render(): string
    {
        $allPages = ceil($this->total / $this->limit);

        $data = '';

        if ($allPages > 1) {
            $data .= '<a class="pagination" href="' . $this->url . '&page=1">first page</a>';


            if ($allPages <= $this->visibleLinks) {
                $start = 1;
                $end = $allPages;
            } else {
                $start = $this->page - floor($this->visibleLinks / 2);
                $end = $this->page + floor($this->visibleLinks / 2);

                if ($start < 1) {
                    $start = 1;
                }

                if ($end > $allPages) {
                    $end = $allPages;
                }
            }


            for ($i = $start; $i <= $end; $i++) {
                if ($i == $this->page) {
                    $data .= '<a class="pagination active" href="' . $this->url . '&page=' . $i . '">' . $i . '</a>';
                } else {
                    $data .= '<a class="pagination" href="' . $this->url . '&page=' . $i . '">' . $i . '</a>';
                }
            }

            $data .= '<a class="pagination" href="' . $this->url . '&page=' . $allPages . '">last page</a>';
        }

        return $data;
    }
}
