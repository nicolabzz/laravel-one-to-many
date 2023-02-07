<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Validation rules
    private $validations = [
        'slug'      => [
            'required',
            'string',
            'max:100',
        ],
        'title'     => 'required|string|max:100',
        'image'     => 'url|max:100',
        'uploaded_img'  => 'image|max:1024',
        'content'   => 'string',
        'excerpt'   => 'string',
    ];

    // ============================
    public function index()
    {
        $posts = Post::paginate(10);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    // ============================
    public function create()
    {
        return view('admin.posts.create');
    }

    // ============================
    public function store(Request $request)
    {
        // validation
        // $this->validations['slug'][] = 'unique:posts';
        // $request->validate($this->validations);

        $request->validate([
            'slug'      => 'required|string|max:100|unique:posts',
            'title'     => 'required|string|max:100',
            'image'     => 'url|max:100',
            'uploaded_img'  => 'image|max:1024',
            'content'   => 'string',
            'excerpt'   => 'string',
        ]);

        $data = $request->all();

        $img_path = Storage::put('uploads', $data['uploaded_img']);

        // salvare i dati nel DB
        $post = new Post;
        $post->slug          = $data['slug'];
        $post->title         = $data['title'];
        $post->image         = $data['image'];
        $post->uploaded_img  = $img_path;
        $post->content       = $data['content'];
        $post->excerpt       = $data['excerpt'];
        $post->save();

        // ridirezionare (e non ritornare una view)
        return redirect()->route('admin.posts.show', ['post' => $post]);
    }

    // ============================
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    // ============================
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // ============================
    public function update(Request $request, Post $post)
    {
        // validation
        // $this->validations['slug'][] = Rule::unique('posts')->ignore($post);
        // $request->validate($this->validations);

        $request->validate([
            'slug'      => [
                'required',
                'string',
                'max:100',
                Rule::unique('posts')->ignore($post),
            ],
            'title'     => 'required|string|max:100',
            'image'     => 'url|max:100',
            'uploaded_img'  => 'image|max:1024',
            'content'   => 'string',
            'excerpt'   => 'string',
        ]);

        $data = $request->all();

        $img_path = Storage::put('uploads', $data['uploaded_img']);
        Storage::delete($post->uploaded_img);

        // salvare i dati nel db
        $post->slug     = $data['slug'];
        $post->title    = $data['title'];
        $post->image    = $data['image'];
        $post->uploaded_img  = $img_path;
        $post->content  = $data['content'];
        $post->excerpt  = $data['excerpt'];
        $post->update();

        // ridirezionare (e non ritornare una view)
        return redirect()->route('admin.posts.show', ['post' => $post]);
    }

    // ============================
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success_delete', $post);
    }
}
