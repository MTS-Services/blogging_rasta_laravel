<x-admin::app>
    <x-slot name="pageSlug">blog-comment</x-slot>
    <x-slot name="title">{{ __('Blog Comments') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Blog Management / Comments') }}</x-slot>
    <livewire:backend.admin.blog-comment.index />
</x-admin::app>
