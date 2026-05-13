<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лента постов Boardy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Лента постов</h1>

        @foreach($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title" style="color: #1A5276;">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <div class="text-muted small">
                        Автор: <strong>{{ $post->author->name }}</strong> | 
                        Дата: {{ $post->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</body>
</html>