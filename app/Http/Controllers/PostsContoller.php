<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Posts;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostsContoller extends Controller
{

    public function posts()
    {
        return view('admin.posts');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Posts::with('user')->with('category')->where('active', 'Yes');

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('styledStatus', function ($row) {
                    $chip = '<span class="badge badge-pill badge-primary">' . $row->status . '</span>';
                    return $chip;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';

                    return $btn;
                })

                ->rawColumns(['action', 'styledStatus'])

                ->make(true);
        }
        // dd($request);

        return view('user');
    }


    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'title' => 'required',
            'seotitle' => 'required',
            'content' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();

        DB::beginTransaction();
        try {
            $files = $request->file('images');
            $request->images->store('assets/images/news');
            $fileName = time() . '_' . $files->getClientOriginalName();
            $filePath = $files->storeAs('uploads', $fileName);
            // save post
            $post = Posts::create([
                'title' => $input['title'],
                'seotitle' => $input['seotitle'],
                'user_id' => auth()->user()->id,
                'content' => $input['content'],
                'status' => $input['status'] === true ? 'publish' : 'draft',
                'image' => $fileName,
                'active' => 'yes'
            ]);

            // // save post category
            $post->category()->attach($input['category_id']);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'success', 'data' => $filePath]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create post: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        $post = Posts::find($id);

        return response()->json(['status' => true, 'message' => 'success', 'data' => $post]);
    }

    public function update(Request $request): JsonResponse
    {
        return response()->json();
    }
}
