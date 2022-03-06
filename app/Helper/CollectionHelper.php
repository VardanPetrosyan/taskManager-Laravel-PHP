<?php


namespace App\Helper;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CollectionHelper
{
    public static function paginate(Collection $results, $pageSize, $path = false) {
        $page = Paginator::resolveCurrentPage('page');
        $total = $results->count();

        if (!$path) {
            $path =  Paginator::resolveCurrentPath();
        } else if (strpos($path, '&') !== false) {
            $path = explode('&page=', $path)[0];
        } else {
            $path = explode('?page=', $path)[0];
        }

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
           'path' => $path,
           'pageName' => 'page',
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static  function paginator(Collection $items, int $total, int $perPage, int $currentPage, array $options) {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}