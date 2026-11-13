@if (session('success'))
    <div style="padding:10px; margin-bottom:14px; background:#e6f4ea; color:#137333; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="padding:10px; margin-bottom:14px; background:#fce8e6; color:#c5221f; border-radius:6px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="padding:10px; margin-bottom:14px; background:#fce8e6; color:#c5221f; border-radius:6px;">
        <ul style="margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
