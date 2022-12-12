<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentor;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorCategory;
use App\Models\MentorAssignCategory;

class MentorSkillController extends Controller
{
    //save
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id'=>'required',
            'categories'=>'required|array',
            'token' => 'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $id=$request->mentor_id;
            // $cat_id=$request->category_id;
            // $parent_categroy_id=$request->parent_categroy_id;
            // $subCategroy_id=$request->subcategroy_id;
            MentorAssignCategory::where('mentor_id',$id)->delete();
            foreach($request->categories as $category){
                MentorAssignCategory::create(
                    ['mentor_id'=>$id,'category_id'=>$category],
                );
            }

            // MentorAssignCategory::insert([
            //     ['mentor_id'=>$id,'category_id'=>$parent_categroy_id],
            //     ['mentor_id'=>$id,'category_id'=>$cat_id],
            //     ['mentor_id'=>$id,'category_id'=>$subCategroy_id]
            // ]);

            $categories=MentorCategory::whereIn('id',$request->categories)->orderBy('id','ASC')->get();
            // $parent_categroy=MentorCategory::find($parent_categroy_id);
            // $child_category=MentorCategory::find($cat_id);

            $obj=["Status"=>true,"success"=>1,"data"=>["categories"=>$categories],"msg"=>"Mentor Skills Added Successfully"];

            return response()->json($obj);


        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //delete Mentor Skill
    public function delete(Request $request){
        $validator = Validator::make($request->all(), [

            'mentor_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $id=$request->mentor_id;

            // $cat_id=$request->category_id;
            MentorAssignCategory::where('mentor_id',$id)->delete();
            // $mentor=Mentor::where('user_id',$id)->update([
            //     'mentor_category_id'=>null
            // ]);
            $obj=["Status"=>true,"success"=>1,"data"=>["mentor"=>true],"msg"=>"Mentor Skills Deleted Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function selectCategory(Request $request){
        $validator = Validator::make($request->all(), [

            'mentor_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $id=$request->mentor_id;
            $mentor=Mentor::where('user_id',$id)->get();

            if(count($mentor)>0){
                $assign_categories=MentorAssignCategory::select('category_id')->where('mentor_id',$id)->get();
                $assign_categories_ids=[];
                foreach($assign_categories as $assign_category)
                {
                    array_push($assign_categories_ids,$assign_category->category_id);

                }
                $categories=MentorCategory::whereIn('id',$assign_categories_ids)->get();
                $obj=["Status"=>true,"success"=>1,"data"=>['mentor'=>$mentor,"category"=>$categories],"msg"=>"Mentor Skills Got Successfully"];

                return response()->json($obj);
            }else {
                $obj=["Status"=>false,"success"=>0,"msg"=>"Mentor Not Found"];

                return response()->json($obj);
            }

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
