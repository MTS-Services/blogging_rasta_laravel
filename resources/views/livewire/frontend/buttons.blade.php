 <div class="p-8 max-w-4xl mx-auto space-y-12">
     <div class="text-center">
         <h1 class="text-3xl font-bold mb-2">{{__('Blade Button Component Showcase')}}</h1>
         <p class="text-lg text-text-secondary-light dark:text-text-secondary-dark">{{__('A gallery of button variants and
             states.')}}</p>
     </div>

     <!-- Primary & Secondary Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">{{__('Primary & Secondary')}}</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary">{{__('Generate Report')}}</x-button>
             {{-- <x-button variant="primary" icon="plus">Add New Item</x-button>
             <x-button variant="primary" icon="download" iconPosition="right">Download</x-button> --}}
         </div>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="secondary">{{__('Cancel')}}</x-button>
             {{-- <x-button variant="secondary" icon="x-mark">Remove</x-button>
             <x-button variant="secondary" icon="check" iconPosition="right">Confirm</x-button> --}}
         </div>
     </div>

     <!-- Outline & Dashed Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">{{__('Outline & Dashed')}}</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="outline">{{__('Learn More')}}</x-button>
             {{-- <x-button variant="outline" icon="eye">Preview</x-button> --}}
             <x-button variant="dashed">{{__('Add Custom Field')}}</x-button>
             {{-- <x-button variant="dashed" icon="plus">New</x-button> --}}
         </div>
     </div>

     <!-- Link Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">{{__('Link Style')}}</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="link">{{__('Go Back')}}</x-button>
             {{-- <x-button variant="link" icon="arrow-left">Back to Dashboard</x-button> --}}
         </div>
     </div>

     <!-- Disabled States -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">{{__('Disabled Buttons')}}</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary" disabled>{{__('Saving...')}}</x-button>
             <x-button variant="secondary" disabled>{{__('Disabled')}}</x-button>
             <x-button variant="outline" disabled>{{__('Not Available')}}</x-button>
             <x-button variant="link" disabled>{{__('Disabled Link')}}</x-button>
         </div>
     </div>

     <!-- Small Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">{{__('Small Buttons')}}</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary" small>{{__('Submit')}}</x-button>
             <x-button variant="secondary" small>{{__('Cancel')}}</x-button>
             {{-- <x-button variant="primary" small icon="plus">Add</x-button> --}}
         </div>
     </div>
 </div>
