<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Muestra un listado de todos los posts.
     */
    public function index()
    {
        // Incluye al usuario que creó el post
        $posts = Post::with(['user', 'comments'=>function($query){
            return $query->with('user')->orderBy('id','desc');
        }])->latest()->get();

        return response()->json($posts);
    }

    public function indexUser()
    {
        // Incluye al usuario que creó el post
        $posts = Post::with(['user', 'comments.user'])->where('user_id', auth()->user()->id)->latest()->get();

        return response()->json($posts);
    }

    /**
     * Crea un nuevo post.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json($post, 201);
    }

    /**
     * Muestra un post específico.
     */
    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post no encontrado'], 404);
        }

        return response()->json($post);
    }

    /**
     * Actualiza un post existente.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post no encontrado'], 404);
        }

        // Validación de los datos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Verifica si el usuario autenticado es el autor del post
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $post->update($validated);

        return response()->json($post);
    }

    /**
     * Elimina un post.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post no encontrado'], 404);
        }

        // Verifica si el usuario autenticado es el autor del post
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post eliminado correctamente']);
    }
}
