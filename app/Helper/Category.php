<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/12/2018
 * Time: 1:34 PM
 */

namespace App\Helper;


class Category
{
    public static function getParentsCount($category)
    {
        $parentCount = 0;
        $parent = $category->parentCategory;

        while (!is_null($parent)) {
            ++$parentCount;
            $parent = $parent->parentCategory;
        }

        return $parentCount;
    }

    public static function renderSubcategoriesTable($render, $category, $deep = 0)
    {
        foreach($category->subCategories as $subCategory) {
            echo $render($subCategory, $deep + 1);
            self::renderSubcategoriesTable($render, $subCategory, $deep + 1);
        }
    }

    public static function deepSubCategories($_categories, $_category)
    {
        $list = [];

        foreach ($_categories as $category) {
            if ($category->id == $_category->id) {
                continue;
            }

            if ($category->parent == $_category->id) {
                $list[] = $category->id;
                $list = array_merge($list, self::getSubsId($category));
            }
        }

        sort($list);
        return $list;
    }

    private static function getSubsId($category)
    {
        $ids = [];
        foreach ($category->subCategories as $subCategory) {
            $ids[] = $subCategory->id;
            $ids = array_merge($ids, self::getSubsId($subCategory));
        }

        return $ids;
    }
}