<div class="grid row">
    @foreach ($images as $image)
        <div class="image col-xs-6 col-md-4 col-lg-3">
            <img src="{{ $image->url }}">
            <div class="image-title">{{ $image->title }}</div>
        </div>
    @endforeach
</div>