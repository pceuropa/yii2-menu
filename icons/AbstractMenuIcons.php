<?php

namespace pceuropa\menu\icons;

abstract class AbstractMenuIcons implements IMenuIcons
{
    private static $instance = null;

    public function forge()
    {
        if (is_null(self::$instance))
            self::$instance = new static;

        return self::$instance;
    }

    public final function getDropDownOptions()
    {
        $result = [];
        foreach ($this->getAll() as $glyphName => $glyphCode)
        {
            $result[$glyphName] = $this->getDropDownOption($glyphName);
        }

        return $result;
    }
}