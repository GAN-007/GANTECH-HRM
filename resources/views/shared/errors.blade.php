@if ($errors->any())
    <div class="alert alert-danger text-left">
        <ul>
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </ul>
    </div>
@endif
