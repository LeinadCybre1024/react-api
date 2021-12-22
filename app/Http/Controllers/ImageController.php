<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Fetch images
     * @param NA
     * @return JSON response
     */
    public function index() {
       // return view('welcome');
        
        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
        
    }
 
    /**
     * Upload Image
     * @param $request
     * @return JSON response
     */
    public function upload(Request $request) {
        $imagesName = [];
        $response = [];

        $validator = Validator::make($request->all(),
            [
                'images' => 'required',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        );

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "Validation error", "errors" => $validator->errors()]);
        }

        if($request->has('images')) {
            foreach($request->file('images') as $image) {
                $filename = time().rand(3). '.'.$image->getClientOriginalExtension();
                $image->move('uploads/', $filename);

                Image::create([
                    'image_name' => $filename
                ]);
            }

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        }

        else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }
        return response()->json($response);
    }
    public function uploadImage(Request $request)
    {
        if($request->hasFile('image')){
            $file=$request->file('image');
            $filename=$file->getClientOriginalName();
            $finalName=date('His').$filename;
Image::create([
                    'image_name' => $finalName
                ]);
            $request->file('image')->storeAs('images/',$finalName,'public');
                return response()->json(["message"=>"success"]);

        }else{
            return response()->json(["message"=>"nosuccess"]);
        }
    }
}

/*
<?php
...
class HomeController extends Controller
{
...
public function uploadimage(Request $request)
    {
      //check file
      if ($request->hasFile('image'))
      {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            //move image to public/img folder
            $file->move(public_path('img'), $picture);
            return response()->json(["message" => "Image Uploaded Succesfully"]);
      } 
      else
      {
            return response()->json(["message" => "Select image first."]);
      }
    }
}
*/
