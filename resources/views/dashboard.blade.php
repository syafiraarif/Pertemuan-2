<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    
                    <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-lg">
                            Nama: <strong>{{ Auth::user()->name }}</strong>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-widest mt-1">
                            Role: <span class="px-2 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 rounded font-bold">
                                {{ Auth::user()->role }}
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>