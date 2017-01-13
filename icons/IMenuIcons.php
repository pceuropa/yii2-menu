<?php

namespace pceuropa\menu\icons;

interface IMenuIcons {

    /**
     * Returns all glyphicons
     *
     * @return mixed
     */
    public function getAll();

    public function getDropDownOption($key);
}