<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Author;
use DB;
use yajra\Datatables\Datatables;
use Response;
use Validator;

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
        

           $validation = Validator::make($request->all(), [         
             'title'             => 'required',
             'author'           => 'required',
             'content'            => 'required',
             'published_at'      => 'required',
           
        ]);


        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                DB::table('posts')->insert([
                "title"           => $request->get('title'),
                "author_id"     => $request->get('author'),
                "content"      => $request->get('content'),
                "published_at"         => $request->get('published_at')
                     
                  ]);             
                $success_output        = '<div class="alert alert-success">Data Inserted</div>';
            }
            if($request->get('button_action') == 'update')
            {
                DB::table('posts')
                ->where('id',$request->get('student_id'))
                ->update([
                "title"           => $request->get('title'),
                "author_id"     => $request->get('author'),
                "content"      => $request->get('content'),
                "published_at"         => $request->get('published_at')  
                     ]);  

                $success_output         = '<div class="alert alert-success">Data Updated</div>';
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);


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
    public function edit(Request $request)
    {

         $id = $request->input('id');
        $query = Post::where('id',$id)->get();
        return response($query);
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
    public function destroy(Request $request)
    {
        
             if($request->input('id'))
        {
             DB::table('posts')->where('id', '=', $request->input('id') )->delete();
            echo 'Data Deleted';
        }

    }
}
