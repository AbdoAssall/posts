<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostController extends Controller
{
    public function index(){
        // select * all from posts
        $postsFromDB = Post::all();
        // dd($postsFromDB);

        // $allPostes = [
        //     ['id' => 1, 'title' => 'PHP', 'Posted-by' => 'Abdo', 'Created_at' => '2022-10-10 09:00:00'],
        //     ['id' => 2, 'title' => 'JavaScipt', 'Posted-by' => 'Mohamed', 'Created_at' => '2023-8-10 09:00:00'],
        //     ['id' => 3, 'title' => 'Laravel', 'Posted-by' => 'Mohamed', 'Created_at' => '2023-6-01 09:00:00'],
        //     ['id' => 4, 'title' => 'CSS', 'Posted-by' => 'Ahmed', 'Created_at' => '2024-10-25 09:00:00'],
        // ];
        $search = request()->search;
        if($search){
            $postsFromDB = Post::where('title', 'LIKE', "%$search%")->get();
        }     

        return view('posts.index', ['posts' => $postsFromDB]);
    }

    public function show(Post $post){
        // select *  from posts where id = '$postID'
        // $singlePostFromDB = Post::find($postID); //model object

        // $singlePostFromDB = Post::where('id', $postID)->first(); // model object
        // $singlePostFromDB = Post::where('id', $postID)->get();  // collection object

        // Post::where('title', 'php')->first(); // select *  from posts where title = 'php' limit 1
       // Post::where('title', 'php')->get(); // select *  from posts where title = 'php'

        return view('posts.show', ['post' => $post]);
    }  
    
    public function create(){
        // select * from users
        $users = User::all();
        
        return view('posts.create', ['users' => $users]);
    }

    public function store(){

        // code to validate the data
        request()->validate([
            'title'=> ['required', 'min:3'],
            'description' => ['required', 'min:5'],
            'post_creater' => ['required', 'exists:users,id']
        ]);
        // $request = request();
        // dd($request-> title, $request->all());

        // 1- get the user data 
        $data = request()->all();

        $title = request()->title;
        $description = request()->description;
        $post_creater = request()->post_creater;
        // dd($data, $title, $description, $postCreater);
        // return $data;

        // 2- store the user data in database

        
        // Way1
        //$post = new Post;

        //$post->title = $title;
        //$post->description = $description;
 
        //$post->save(); // insert into posts

        // Way2
        Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $post_creater,
        ]);

        // 3- redirection to posts.index

        return to_route('posts.index');  
    }
    public function edit(Post $post){
        // @dd($post);
        // select * from users
        $users = User::all();

        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }
    public function update($postId){

        request()->validate([
            'title' => ['required','min:3'],
            'description' => ['required', 'min:5'],
            'user_id' => ['required', 'exists:users,id']
        ]);
        // 1- get the user data 
        $title = request()->title;
        $description = request()->description;
        $postCreater = request()->post_creater;

        // dd($title, $description, $postCreater);

        // 2- update the user data in database
             // select or find the post
             // update the post data
        $singlePostFromDB = Post::find($postId);
        $singlePostFromDB-> update([
            'title'=> $title,
            'description'=> $description,
            'user_id' => $postCreater,
        ]);
        // 3- redirection to posts.show
        return to_route('posts.show', $postId);
    }
    public function destroy($postId){
        // 1- delete the post form the database
           // select or find the post
           // delete the post data
           $post = Post::find($postId);
           $post-> delete();

        // 2- redirection to posts.index
       return to_route('posts.index');
    }

    // public function search(Request $request){
    //     $search = $request->input('search');
    //     $results = Post::where('title', 'like', "%$search%")->get();
    //     // $results = Post::where($request->input('search'))->get();
    //     return view('posts.index', ['results' => $results]);
    // }
}
