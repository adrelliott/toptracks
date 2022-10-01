<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if(! auth()->user()->spotify_id)
                    <div class="p-6 bg-white border-b border-gray-200"> 
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                            You're all set {{ auth()->user()->first_name }}!
                        </h3>
                        <p>
                            Now let's connect to your Spotify account.
                        </p>
                        <a href="/auth/redirect" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                            Connect to Spotify
                        </a>
                        <p class="text-sm">Your data: Spotify only gives us basic details. Click here ot see exactly what we have access to.</p>
                    </div>
                @else
                    <div class="p-6 bg-white border-b border-gray-200">
                        Spotify connected
                        {{ dump(auth()->user()) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
