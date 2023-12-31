<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

use App\Models\CategoryPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();
        //The same as "SELECT * FROM categories"
        return view('users.posts.create')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        # 1. validate the first
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image'       => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Display the error message if there is an error in the validation

        # 3. Store/save the post details posts table
        $this->post->user_id = Auth::user()->id; //this is the owner of the post
        //The image is being conveter into a series of long text
        $this->post->image = 'data:image/' .$request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save(); // does not request fillable array

        # 4. Insert the categories
        //category[1, 3, 5]

        # Given data:
            //$this->post->id = 1
            //category[1, 3, 5]

        foreach ($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
            //  $category_post[
            //      ['category_id' =>1],
            //      ['category_id' =>3],
            //      ['category_id' =>5],
            //      ]
        }

        $this->post->categoryPost()->createMany($category_post); // category_post(PIVOT)

        # After the "$this->post->categoryPost()";
            // $category_post[
            //  ['category_id' = 1, 'post_id' => 1],
            //  ['category_id' = 3, 'post_id' => 1],
            //  ['category_id' = 5, 'post_id' => 1],
            // ]

        # 5. Return to homepage
        return redirect()->route('index');
    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post',$post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id); //1

        # If the AUTH (logged in user) is NOT the OWNER of the post, redirect them to the homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index'); //homepage
        }

        $all_categories = $this->category->all();
        #all_categories[1,2,3,4,5,6] // 1->Travel, 2->Food, 3->Lifestyle, 4->Technology, 5->Career, 6->Movie

        # Get all the category IDs of this post, Save it in an array
        $selected_categories = [];
        #$post->categoruPost[2,3,5]
        foreach($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
            #$selected_categories[2...3...5]
        }

        return view('users.posts.edit')
            ->with('post',$post)
            ->with('selected_categories',$selected_categories)
            ->with('all_categories',$all_categories);
    }

    # This method is going to received the data coming from
    # the form in edit.blade.php, and update the post
    # details with that data
    public function update(Request $request, $id){
        # 1. Validate the data first -- category[], description, image
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:150',
            'image'       => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        // Check if there is new image uploaded
        if($request->image){
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' .
             base64_encode(file_get_contents($request->image));
        }

        $post->save(); // Execute the query and save it to DB

        # 3. Delete all the records (category ids) in category_post related to this post
        $post->categoryPost()->delete();
        // Use the relationship Post::categoryPost() to select the records related to this post
        // Equivalent: "DELETE FROM category_post WHERE id = $id"

        # 4. Save the new categories into the category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        # 5. Redirect to Show Post page (to confirm the update)
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        $post = $this->post->findOrFail($id);
        $post->forceDelete(); // this will totally removed the post from the database

        return redirect()->route('index');
    }

    # $id is a category id
    public function category($id){
        $category = $this->category->findOrFail($id);

        return view('users.posts.category')->with('category',$category);
    }
}
