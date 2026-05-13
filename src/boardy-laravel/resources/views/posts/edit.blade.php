@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать объявление</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT') {{-- КРИТИЧЕСКИ ВАЖНО для обновления --}}

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Описание</label>
            <textarea name="body" class="form-control" id="body" rows="5" required>{{ old('body', $post->body) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection