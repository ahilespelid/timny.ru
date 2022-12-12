<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function categoryBlogList(Request $request){
        $token="123";
        if ($request->token==$token){

            $categories=BlogCategory::all();
            $categoryBlogs=[];
            foreach($categories as $category){
                $blog=Blog::where('category_id',$category->id)->get();

                array_push($categoryBlogs,["category"=>$category,"blogs"=>$blog]);
            }
            //dd($categoryBlogs);
            $featured=Blog::where('featured',1)->get();


            $obj=["Status"=>true,"success"=>1,"data"=>["categoryBlogs"=>$categoryBlogs,'featured_blogs'=>$featured],"msg"=>"Successfully fetched categories with blogs"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function blogDetail(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){

            $blog=Blog::find($request->id);
            $obj=["Status"=>true,"success"=>1,"data"=>["blog"=>$blog],"msg"=>"Successfully fetched  blog"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function allBlogs(Request $request)
    {
        $token="123";
        if ($request->token==$token){

            $allBlogs=Blog::with('category')->orderBy('id','desc')->get();
            $obj=["Status"=>true,"success"=>1,"data"=>['allBlogs'=>$allBlogs],"msg"=>"Successfully fetched All Blogs blogs"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function blogDetailWithSlug(Request $request){
        $slug=$request->slug;
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){

            $blog=Blog::where('slug', $slug)->first();
            $obj=["Status"=>true,"success"=>1,"data"=>["blog"=>$blog],"msg"=>"Successfully fetched  blog"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function allFeaturedPosts(Request $request)
    {
        $token="123";
        if ($request->token==$token){

            $featuredBlogs=Blog::where('featured',1)->orderBy('id','desc')->with('category')->get();
            $obj=["Status"=>true,"success"=>1,"data"=>['featuredBlogs'=>$featuredBlogs],"msg"=>"Successfully fetched All featured blogs"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
