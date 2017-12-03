<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $exists = Storage::disk('local')->exists('category.json');
        if($exists){
            $category = Storage::get('category.json');
            $category_list = json_decode($category,true);

            /* Pagination */
            $paginate = 5;
            $page = (int) $request->input('page') ?: 1;
            $offSet = ($page * $paginate) - $paginate;
            $itemsForCurrentPage = array_slice($category_list, $offSet, $paginate, true);
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage,count($category_list), $paginate, $page);
            return view('home')->with('category_list',$paginator);
        }else{
            return view('home')->with('message', 'No Data Found');;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_name = $request->category_name;
        $category_image = $request->category_image;

        $cat_arr = [];
        $category_data = compact('category_name','category_image');
        $exists = Storage::disk('local')->exists('category.json');

        if(!$exists){
            $category_data = compact('category_name','category_image');
            $cat_arr[] = $category_data;
            $cat_json = json_encode($cat_arr);
            Storage::put('category.json',$cat_json);
            return redirect()->back();
        } else{
            $get = Storage::get('category.json');
            $cat_arr  = json_decode($get);

            /*  Validation  */
            if($this->catValidation($cat_arr,$category_name)){
                 $cat_arr[] = $category_data;
                 $cat_json = json_encode($cat_arr);
                 Storage::put('category.json',$cat_json);
                  return redirect()->back();
            } else{
                return redirect()->back()->with('error', 'Please provide unique category name');
            }
        }


    }

     public function catValidation($cat_arr,$string)
     {
        $cat_array = [];
        foreach ($cat_arr as $key) {
            $cat_array[] =$key->category_name;
        }
        if(in_array($string, $cat_array)){
            return false;
        } else{
            return true;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
}
