<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }} | Boardy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mb-4">← Назад в ленту</a>

        <article class="card shadow-sm mb-2">
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                <p class="text-muted small">
                    Автор: <strong>{{ $post->author->name }}</strong> | 
                    Опубликовано: {{ $post->created_at->format('d.m.Y H:i') }}
                </p>
                <hr>
                <p class="card-text" style="white-space: pre-line;">{{ $post->body }}</p>
            </div>
        </article>

        @can('update', $post)
            <div class="mb-3">
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редактировать</a>
                
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                </form>
            </div>
        @endcan

        <section>
            <h3 class="mb-4">Комментарии ({{ $post->comments->count() }})</h3>

            @auth
                <div class="card mb-1 border shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-350">
                                <label for="body" class="form-label font-weight-bold">Ваш комментарий</label>
                                <textarea name="body" id="body" rows="3" class="form-control mb-3" required placeholder="Напишите что-нибудь..."></textarea>
                            </div>
                            <button type="submit" class="btn" style="background-color: #1A5276; color: white;">Отправить</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    Чтобы оставить комментарий, пожалуйста, <a href="/login">войдите</a>.
                </div>
            @endauth

            @foreach($post->comments->sortByDesc('created_at') as $comment)
                <div class="card mb-2">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $comment->author->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0">{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</body>
</html>