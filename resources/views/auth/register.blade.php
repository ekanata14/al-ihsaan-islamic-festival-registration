<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Group -->
        <div class="mt-4 relative">
            <x-input-label for="group" :value="__('Group')" />
            <x-text-input id="group" class="block mt-1 w-full" type="text" name="group" :value="old('group')"
                required autocomplete="off" />
            <x-input-error :messages="$errors->get('group')" class="mt-2" />
            <ul id="group-suggestions"
                class="absolute z-10 bg-white border border-gray-300 mt-1 rounded-md shadow-md hidden w-full">
                <!-- Suggestions will be dynamically added here -->
            </ul>
            <div id="loading-spinner" class="hidden mt-2 text-center">
                <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
        </div>

        <input type="hidden" id="group_id" name="group_id" />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const groupInput = document.getElementById('group');
                const suggestionsList = document.getElementById('group-suggestions');
                const groupIdInput = document.getElementById('group_id');
                const loadingSpinner = document.getElementById('loading-spinner');

                // Fetch all groups when the input is clicked
                groupInput.addEventListener('click', async function() {
                    loadingSpinner.classList.remove('hidden');

                    try {
                        const response = await fetch(`{{ route('group.getAllGroups') }}`);
                        const data = await response.json();

                        suggestionsList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(group => {
                                const listItem = document.createElement('li');
                                listItem.textContent = group.name;
                                listItem.classList.add('px-4', 'py-2', 'cursor-pointer',
                                    'hover:bg-gray-200');
                                listItem.addEventListener('click', function() {
                                    groupInput.value = group.name;
                                    groupIdInput.value = group.id;
                                    suggestionsList.classList.add('hidden');
                                });
                                suggestionsList.appendChild(listItem);
                            });
                            suggestionsList.classList.remove('hidden');
                        } else {
                            suggestionsList.classList.add('hidden');
                        }
                    } catch (error) {
                        console.error('Error fetching group suggestions:', error);
                    } finally {
                        loadingSpinner.classList.add('hidden');
                    }
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function(event) {
                    if (!suggestionsList.contains(event.target) && event.target !== groupInput) {
                        suggestionsList.classList.add('hidden');
                    }
                });
            });
        </script>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center flex-col mt-4">
            <div class="flex flex-col justify-center w-full text-center gap-2">
                <button type="submit" class="btn-primary w-full">Daftar</button>
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Sudah Terdaftar?') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
