<?php

namespace core\helpers;

class Navigation
{
    public static function isCurrentPage($page)
    {
        global $currentPage;
        if (!empty($page) && strpos($page, ':id') > -1) {
            $page = str_replace(":id", "", $page);
            return strpos($currentPage, $page) > -1;
        }
        return $page == $currentPage;
    }

    public static function activeClass($page, $class = '')
    {
        $active = self::isCurrentPage($page);
        $class = $active ? $class . " active" : $class;
        return $class;
    }

    public static function navItem($link, $label, $isDropdownItem = false, $page = '')
    {
        $active = self::isCurrentPage($link);
        $class = self::activeClass($link);
        $linkClass = $isDropdownItem ? 'dropdown-item' : 'nav-link';
        $linkClass .= $active && $isDropdownItem ? " active" : "";
        $link =  '/' . $link;
        $html = "<li class=\"nav-item\">";
        $html .= "<a class=\"{$linkClass}{$class}\" href=\"{$link}\" >{$label}</a>";
        $html .= "</li>";
        return $html;
    }
}