<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Category;

class CategoryRepository
{
    use Errors;

    /**
     * 获取首页所有分类
     * @return mixed
     */
    public function getCategories()
    {
        $catColumn = ['id', 'name', 'image'];
        $catData = Category::orderBy('sort')
            ->get($catColumn)
            ->toArray();
        return $catData;
    }

}