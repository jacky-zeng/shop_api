<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    //获取首页分类
    public function getCategories()
    {
        $categoryRepository = new CategoryRepository();
        $rsData = $categoryRepository->getCategories();
        return $this->successResponse($rsData);
    }

}