<x-admin::app>
    <x-slot name="pageSlug">{{__('rewiew-management')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.rm.review.create')
            <x-slot name="breadcrumb">{{__('Reiew Management > Page View Create')}}</x-slot>
            <x-slot name="title">{{__('Page View Create')}}</x-slot>
            <livewire:backend.admin.review-management.page-view.create />
        @break
        @case('admin.rm.review.trash')
            <x-slot name="breadcrumb">{{__('Reiew Management > Page View Trash')}}</x-slot>
            <x-slot name="title">{{__('Currency Trash')}}</x-slot>
            <livewire:backend.admin.review-management.page-view.trash />
        @break

        @case('admin.rm.review.show')
            <x-slot name="breadcrumb">{{__('Reiew Management > Page View Details')}}</x-slot>
            <x-slot name="title">{{__('Currency Details')}}</x-slot>
            <livewire:backend.admin.review-management.page-view.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{__('Reiew Management > Page View List')}}</x-slot>
            <x-slot name="title">{{__('Page View List')}}</x-slot>
            <livewire:backend.admin.review-management.page-view.index />
    @endswitch

</x-admin::app>
