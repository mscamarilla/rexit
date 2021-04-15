<?php


namespace Core;


/**
 * Interface DatabaseInterface
 * @package Core
 */
interface DatabaseInterface
{
    /**
     * @return object
     */
    public function makeConnection():object ;

}
