<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /*
     ** Get All recipe filter & paginate
    */
    public function index()
    {
        try {
            $recipes = Recipe::filter(request(['category']))->orderBy('id' ,'DESC')->paginate(6);
            return $recipes;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }

    }

    /*
     ** Get Single recipe
    */
    public function show($id)
    {
        try {
            $recipe = Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => 404
                ], 404);
            }
            return $recipe;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    /*
     ** Get Single recipe
    */
    public function destroy($id)
    {
        try {
            $recipe = Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => 404
                ], 404);
            }
            $recipe->delete();

            return response()->json([
                    'message' => 'Recipe Deleted Successfully',
                    'status' => 200
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    /*
     ** Create Single recipe
    */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'description' => 'required',
                'photo' => 'required',
                'category_id' => ['required', Rule::exists('categories' ,'id')],
            ]);

            if($validator->fails()){

                $formattedErrors = [];
                foreach ( $validator->errors()->messages() as $field => $messages)
                {
                $formattedErrors[$field] = $messages[0];  // Take the first error message
                }

                return response()->json([
                    'error' => $formattedErrors,
                    'status' => 400
                ], 400);
            }

            $recipe = new Recipe();
                $recipe->name = request('name');
                $recipe->description = request('description');
                $recipe->photo = request('photo');
                $recipe->category_id = request('category_id');
                $recipe->save();

                return response()->json([
                    'data' => $recipe,
                    'status' => 201
                ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }

    }

    /*
     ** update Single recipe
    */
    public function update($id,Request $request)
    {
        try {
            $recipe = Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => 404
                ], 404);
            }

            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'description' => 'required',
                'photo' => 'required',
                'category_id' => ['required', Rule::exists('categories' ,'id')],
            ]);

            if($validator->fails()){

                $formattedErrors = [];
                foreach ( $validator->errors()->messages() as $field => $messages)
                {
                $formattedErrors[$field] = $messages[0];  // Take the first error message
                }

                return response()->json([
                    'error' => $formattedErrors,
                    'status' => 400
                ], 400);
            }

                $recipe->name = request('name');
                $recipe->description = request('description');
                $recipe->photo = request('photo');
                $recipe->category_id = request('category_id');
                $recipe->save();

                return response()->json([
                    'data' => $recipe,
                    'status' => 201
                ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    /*
     ** upload Single recipe
    */
    public function upload(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'photo' => ['required' , 'image'],
            ]);

            if($validator->fails()){

                $formattedErrors = [];
                foreach ( $validator->errors()->messages() as $field => $messages)
                {
                $formattedErrors[$field] = $messages[0];  // Take the first error message
                }

                return response()->json([
                    'error' => $formattedErrors,
                    'status' => 400
                ], 400);
            }
                $path = '/storage/' . request('photo')->store('/recipes');

                return response()->json([
                    'path' => $path,
                    'status' => 201
                ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }
}
