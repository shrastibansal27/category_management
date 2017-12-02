<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sub_category = $request->sub_category;
        $sub_category_info = $request->sub_category_info;

        $category = $request->category;
        $subcat_arr = [];

        $subcategory_data = compact('category','sub_category','sub_category_info');

        $exists = Storage::disk('local')->exists('subcategory.json');

        if(!$exists){
            $subcat_arr[] = $subcategory_data;
            $subcat_json = json_encode($subcat_arr);
            Storage::put('subcategory.json',$subcat_json);
        }else{
            $get = Storage::get('subcategory.json');
            $subcat_arr  = json_decode($get);

            /*  Validation  */
            if($this->subCatValidation($subcat_arr,$sub_category)){
               $subcat_arr[] = $subcategory_data;
               $subcat_json = json_encode($subcat_arr);
               Storage::put('subcategory.json',$subcat_json);
            }else{
                return redirect()->back()->with('error', 'Please provide unique sub-category name');
            }
        }
        return redirect()->back();
    }


   public function subCatValidation($subcat_arr,$string)
   {
        $sub_cat_array = [];
        foreach ($subcat_arr as $key) {
            $sub_cat_array[] =$key->sub_category;
        }
        if(in_array($string, $sub_cat_array)){
            return false;
        }else{
            return true;
        }
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $catname = $_GET['catname'];
        $exists = Storage::disk('local')->exists('subcategory.json');

        if($exists){
            $get_sub_cat_data = Storage::get('subcategory.json');
            $sub_cat_data  = json_decode($get_sub_cat_data);
            $cat_array = [];
            $list_arr = [];
            foreach ($sub_cat_data as $key) {
                $cat_array = [
                'category' => $key->category,
                'sub_category' => $key->sub_category,
                ];

                $list_arr[] =$cat_array;
            }

            $arr = array_column($list_arr, 'category','sub_category');
            $catlist = array_keys($arr,$catname);
            return Response::json($catlist);
        }else{
            return redirect()->back();
    }
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
