<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Author;
use DB;
use yajra\Datatables\Datatables;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            $posts = Post::all();


            return view('blog', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $users = DB::table('postsandauthors')   
       ->select(['title','id',
                'firstName', 
                'lastName',
                'content',
                'published_at'
                ]);

    return Datatables::of($users)
        ->addColumn('action', function ($user) {
            $actions = '<a href="#" class="btn btn-xs btn-primary edit" id="'.$user->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
            $actions .= '<a href="#" class="btn btn-xs btn-danger delete" id="'.$user->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            return $actions;
        })->make(true);
    }

      public function crud()
    {

            $authors = Author::all();
            return view('posts', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
