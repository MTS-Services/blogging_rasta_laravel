<div>
    @section('meta')
        <meta name="description" content="{!! $data->meta_description ?? $data->description !!}">
        <meta name="keywords" content="{{ $data->meta_keywords ? implode(',', $data->meta_keywords) : $data->title }}">
        <meta name="title" content="{{ $data->meta_title ?? $data->title }}">

        <meta property="og:title" content="{{ $data->meta_title ?? $data->title }}" />
        <meta property="og:description" content="{!! $data->meta_description ?? $data->description !!}" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />

        <meta name="twitter:card" content="{{ site_name() }}">
        <meta name="twitter:title" content="{{ $data->meta_title ?? $data->title }}">
        <meta name="twitter:description" content="{!! $data->meta_description ?? $data->description !!}">
        <meta name="twitter:image" content="{{ site_logo() }}">
    @endsection
    <section class="bg-bg-primary">
        <div class="container pb-10">
            <div class="w-full pt-8 lg:pt-0 pb-5">
                <div class="w-full h-auto mx-auto">
                    <x-blog-media :file="$data->file" />
                </div>
            </div>
            <h3 class="text-3xl font-semibold font-montserrat text-text-primary">
                {{ __($data->title) }}</h3>
            <p class="text-base pt-4  text-text-primary">
                {!! $data->description !!}
            </p>
        </div>
    </section>
</div>
