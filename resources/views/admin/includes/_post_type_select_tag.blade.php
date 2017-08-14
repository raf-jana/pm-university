<select class="input-md  form-control input-s-sm inline" name="type">
    <option value="">Select Post Type</option>
    <option value="bachelore" {{ $type === 'bachelore' ? "selected":"" }}>
        Bachelore
    </option>
    <option value="master" {{ $type === 'master' ? "selected":"" }}>Master
    </option>
    <option value="specialization" {{ $type === 'specialization' ? "selected":"" }}>
        Specialization
    </option>
</select>