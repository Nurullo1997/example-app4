<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
//use App\Http\Controllers\Controller;

class PostApiController extends Controller
{
 
    // Barcha Postlar ro'yxatini ko'rsatish uchun ishlatiladi.
    public function index()
    {
       // return Post::limit(10)->get();
        return PostResource::collection(Post::limit(10)->get());
    }

    // Yangi Postni saqlash uchun ishlatiladi.
    public function store(Request $request)
    {
        if ($request->hasFile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-phots', $name);
        }


        $post =  Post::create([
            'user_id' => 1,
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

        return response(['success' => 'Post muvaffaqiyatli yaratildi']);
    }

    // Belgilangan Postni ma'lumotlarini ko'rsatish uchun ishlatiladi.
    public function show(Post $post)
    {
       // return $post;
       return new PostResource($post);
    }

    
     // Belgilangan Postni yangilash uchun ishlatiladi.
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post yangilandi');
    }

    
     // Belgilangan Postni o'chirish uchun ishlatiladi.
     
    public function destroy(Post $post)
    {
       
        $post->delete();

        return 'Ochirildi';
    }
}
