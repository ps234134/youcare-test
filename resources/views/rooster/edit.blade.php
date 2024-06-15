<x-app-layout>
    <div>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-1">
                <div class="bg-white shadow-md rounded my-6 p-5">

                    <form method="POST" action="{{ route('rooster.update', $rooster) }}">
                        @csrf
                        @method('put')
                        <div class="flex flex-col space-y-2">
                            <label for="shift" class="text-gray-700 select-none font-medium">Dienst datum</label>
                            <input id="shift" type="date" name="date" value="{{ $rooster->date }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                            <label for="shift" class="text-gray-700 select-none font-medium">Dienst start tijd</label>
                            <input id="shift" type="time" name="start_time" value="{{ $rooster->start_time }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                            <label for="shift" class="text-gray-700 select-none font-medium">Dienst eind tijd</label>
                            <input id="shift" type="time" name="end_time" value="{{ $rooster->end_time }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                            <div>
                                <label for="user">User</label><br>
                                <select
                                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200"
                                    id="user" name="user" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $rooster->user_id ? 'selected' : '' }}>{{ $user->name }}  - {{ $user->roles->first()->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-center mt-16">
                            <button type="submit"
                                class="bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors ">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
