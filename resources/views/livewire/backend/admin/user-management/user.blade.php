 <section>
     <div class="glass-card rounded-2xl p-6 mb-6">
         <div class="flex items-center justify-between">
             <h2 class="text-xl font-bold text-text-primary">{{ __('Admin List') }}</h2>
             <div class="flex items-center gap-2">
                 <x-button href="#" icon="trash-2" type='secondary' permission="admin-trash">
                     {{ __('Trash') }}
                 </x-button>
                 <x-button href="#" icon="plus" permission="admin-create">
                     {{ __('Add') }}
                 </x-button>
             </div>
         </div>
     </div>
   
     <div class="mt-4 glass-card rounded-2xl p-6">
         @livewire('user-table')
     </div>
 </section>
