<ul class="dropdown-menu">
    <li>
        <a href="posts/{{ $post->id }}/articles?type=top-10">Top-Ten : {{$post->top_ten_articles_count}}</a>
    </li>
    <li>
        <a href="posts/{{ $post->id }}/articles?type=tools">Tools : {{$post->tools_articles_count}}</a>
    </li>
    <li>
        <a href="posts/{{ $post->id }}/articles?type=interviews">Interviews:{{$post->interviews_articles_count}}</a>
    </li>
    <li>
        <a href="posts/{{ $post->id }}/articles?type=books">Books:{{$post->books_articles_count}}</a>
    </li>
    <li>
        <a href="posts/{{ $post->id }}/articles?type=videos">Videos:{{$post->videos_articles_count}}</a>
    </li>
</ul>