<select class="input-md  form-control input-s-sm inline" name="type">
    <option value="">Select Article Type</option>
    <option value="latest" {{ $type === 'latest' ? "selected":"" }}>
        Latest
    </option>
    <option value="top-10" {{ $type === 'top-10' ? "selected":"" }}>
        Top-10
    </option>
    <option value="videos" {{ $type === 'videos' ? "selected":"" }}>Videos
    </option>
    <option value="books" {{ $type === 'books' ? "selected":"" }}>
        Books
    </option>
    <option value="interviews" {{ $type === 'interviews' ? "selected":"" }}>
        Interviews
    </option>
    <option value="tools" {{ $type === 'tools' ? "selected":"" }}>
        Tools
    </option>
</select>