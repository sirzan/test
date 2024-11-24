<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Crea un nuevo comentario asociado a un post.
     */
    public function store(Request $request, $postId)
    {
        // Verifica si el post existe
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post no encontrado'], 404);
        }

        // Valida los datos enviados
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return response()->json($comment, 201);
    }

    /**
     * Muestra un comentario específico.
     */
    public function show($postId, $id)
    {
        $comment = Comment::with('user')->where('post_id', $postId)->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json($comment);
    }

    /**
     * Actualiza un comentario existente.
     */
    public function update(Request $request, $postId, $id)
    {
        // Encuentra el comentario a actualizar
        $comment = Comment::where('post_id', $postId)->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        // Verifica si el usuario autenticado es el autor del comentario
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Valida los datos enviados
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    /**
     * Elimina un comentario.
     */
    public function destroy($postId, $id)
    {
        // Encuentra el comentario a eliminar
        $comment = Comment::where('post_id', $postId)->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        // Verifica si el usuario autenticado es el autor del comentario
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $comment->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente']);
    }
}
