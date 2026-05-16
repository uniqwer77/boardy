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

        <!-- @foreach($posts as $post)
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
        @endforeach -->
        <div id="posts-feed">
            @foreach($posts as $post)
            <article class="card">
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->body }}</p>
                <small>{{ $post->user->name ?? $post->author->name }}</small> 
            </article>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script>
        @if(app()->environment('production'))
            const wsUrl = 'wss://api.{{ config("app.fastapi_domain") }}/ws'
        @else
            const wsUrl = 'ws://tlop.ai-info.ru/ws'
        @endif

        function connect() {
            const ws = new WebSocket(wsUrl)
            
            ws.onopen = () => console.log('WS connected')
            
            ws.onmessage = (e) => {
                const msg = JSON.parse(e.data)
                if (msg.type === 'new_post') prependPost(msg.post)
            }
            
            ws.onclose = () => setTimeout(connect, 3000)
        }

        function prependPost(post) {
            const feed = document.getElementById('posts-feed')
            if (!feed) return
            
            const el = document.createElement('article')
            el.className = 'card'
            el.innerHTML = `
                <h3>${escapeHtml(post.title)}</h3>
                <p>${escapeHtml(post.body)}</p>
                <small>${escapeHtml(post.author)}</small>
            `
            feed.prepend(el)
        }

        function escapeHtml(str) {
            const d = document.createElement('div')
            d.textContent = str
            return d.innerHTML
        }

        connect()
    </script>

</body>
</html>