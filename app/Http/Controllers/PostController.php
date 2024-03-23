<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\StorePostRequest;
use App\Jobs\ChangePost;
use App\Jobs\UploadBigFile;
use App\Mail\PostCreated as MailPostCreated;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Notifications\PostCreated as NotificationsPostCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');

        // $this->authorizeResource(Post::class, 'post');
    }



    // Ma'lumotlarni ko'rish

    public function index()
    {

        $posts = Post::latest()->paginate(9);

        return view('posts.index')->with('posts', $posts);
    }

    // Yangi ma'lumot yaratish formasini ko'rish

    public function create()
    {
        //Gate::authorize('create-post', Role::where('name', 'editor')->first());


        return view('posts.create')->with([
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }


    //Yangi ma'lumotni omborga saqlash.

    public function store(StorePostRequest $request)
    {
        if ($request->hasFile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-phots', $name);
        }


        $post =  Post::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $path ?? null,
        ]);

        if (isset($request->tags)) {
            foreach ($request->tags as $tag) {
                $post->tags()->attach($tag);
            }
        }

        PostCreated::dispatch($post);

        ChangePost::dispatch($post)->onQueue('uploading');

        Mail::to($request->user())->later(now()->addMilliseconds(60), (new MailPostCreated($post))->onQueue('sending-mails'));

        Notification::send(auth()->user(), new NotificationsPostCreated($post));

        return redirect()->route('posts.index')->with('success', 'Post yaratildi!');
    }


    // Ma'lum bir postni ko'rish

    public function show(Post $post)
    {

        return view('posts.show')->with([
            'post' => $post,
            'recent_posts' => Post::latest()->get()->except($post->id)->take(4),
            'categories' => Category::all(),
            'tags' => Tag::all(),


        ]);
    }


    // Ma'lum bir postni o'zgartirish formasini ko'rish

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);


        return view('posts.edit')->with(['post' => $post]);
    }


    // Ma'lum bir postni o'zgartirish

    public function update(StorePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        if ($request->hasFile('photo')) {
            if (isset($post->photo)) {
                Storage::delete($post->photo);
            }

            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-phots', $name);
        }



        $post->update([
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $path ?? $post->photo,
        ]);

        return redirect()->route('posts.show', ['post' => $post->id]);
    }


    // Ma'lum bir postni o'chirish

    public function destroy(Post $post)
    {

        if (isset($post->photo)) {
            Storage::delete($post->photo);
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}
