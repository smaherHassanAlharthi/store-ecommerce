<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Enumerations\CategoryType;
use Exception;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories =   Category::select('id', 'parent_id')->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // return $request;
        try {

            DB::beginTransaction();
            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            //if user choose main category then we must remove paret id from the request

            // if ($request->type == CategoryType::mainCategory) //main category
            // {
            //     $request->request->add(['parent_id' => null]);
            // }

            //if he choose child category we mus t add parent id


            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' => __('translation.add_successfully_massage')]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error' => __('translation.failed_massage')]);
        }
    }


    public function edit($id)
    {

        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' =>  __('admin/categories.category_not_found')]);

        return view('dashboard.categories.edit', compact('category'));
    }


    public function update($id, MainCategoryRequest $request)
    {
        return $request;
        try {
            //validation

            //update DB
            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/categories.category_not_found')]);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' =>  __('translation.success_massage')]);
        } catch (Exception $ex) {
            // return $ex ;
            return redirect()->route('admin.maincategories')->with(['error' => __('translation.failed_massage')]);
        }
    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' =>  __('admin/categories.category_not_found')]);

            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' =>  __('translation.delete_successfully_massage')]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => __('translation.failed_massage')]);
        }
    }
}
