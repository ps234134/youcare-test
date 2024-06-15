<x-app-layout>
    <div>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-2">

                <div class="text-right">
                    <a href="{{ route('rooster.create') }}"
                        class="bg-[#4CC9D1] text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-[#1e3129] transition-colors ">Nieuwe
                        dienst</a>
                </div>


                <div class="bg-white shadow-md rounded my-6">
                    <div class="p-3" id="calendar"></div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridWeek',
                    selectable: true,
                    events: @json($events),
                    eventContent: function(arg) {
                        var startTime = new Date(arg.event.start).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        var endTime = new Date(arg.event.end).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        var html = `
                        <div>
                            <div>${startTime} - ${endTime}</div>
                            <div>${arg.event.title}</div>
                            <div class="fc-event-buttons flex gap-4">
                               <a href="{{ route('rooster.edit') }}" class="fc-event-button edit-btn" data-event-id="${arg.event.id}"><svg class="h-5 w-5 text-green-500"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                               <a href="{{ route('rooster.delete') }}" class="fc-event-button edit-btn" data-event-id="${arg.event.id}"><svg class="h-5 w-5 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg></a>
                            </div>
                        </div>
                    `;
                        return {
                            html: html
                        };
                    },
                });
                calendar.render();

                // Event delegation for handling clicks on dynamically created buttons
                document.addEventListener('click', function(event) {
                    if (event.target.classList.contains('edit-btn')) {
                        var eventId = event.target.getAttribute('data-event-id');
                        alert('Edit button clicked for event ID: ' + eventId);
                        // Add your edit logic here
                    } else if (event.target.classList.contains('delete-btn')) {
                        var eventId = event.target.getAttribute('data-event-id');
                        alert('Delete button clicked for event ID: ' + eventId);
                        // Add your delete logic here
                    }
                });
            });
        </script> --}}


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var events = @json($events);
                var roosterId = @json($rooster->id); // Pass the rooster ID to JavaScript
                console.log(events);
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridWeek',
                    selectable: true,
                    events: @json($events),
                    eventContent: function(arg) {
                        var startTime = new Date(arg.event.start).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        var endTime = new Date(arg.event.end).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        var html = `
                    <div>
                        <div>${startTime} - ${endTime}</div>
                        <div>${arg.event.title}</div>
                        <div class="flex gap-10 mt-2">
                              <a href="/rooster/${roosterId}/edit" title="Edit">
                                <svg class="h-5 w-5 text-green-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"/>
                                    <line x1="16" y1="5" x2="19" y2="8"/>
                                </svg>
                            </a>
                            {{-- wierd route mixing server and client logic --}}
                             <form action="{{ route('rooster.destroy', '') }}/${roosterId}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this event?');">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                `;
                        return {
                            html: html
                        };
                    },
                });
                calendar.render();
            });
        </script>
    @endpush

</x-app-layout>
