<div>
    <section class="bg-bg-primary">
        <div class="container pb-10">
            <div class="w-full pt-8 lg:pt-0 pb-5">
                <div class="w-full h-full mx-auto">
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
