<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto text-center sm:px-6 lg:px-8">
            <div class="p-4">
                @forelse ($schedules as $year => $periods)
                    <div class="mb-6">
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-6">
                                <h6 class="text-lg font-semibold">Presensi {{ $year }}</h6>

                                @forelse ($periods as $period => $schedules)
                                    <h6 class="my-3 text-lg font-semibold">Periode {{ strtoupper($period) }}</h6>

                                    <div class="grid items-center justify-center grid-cols-4 col-span-2">
                                        @foreach ($schedules as $index => $schedule)
                                            <h6 class="my-3 text-lg font-semibold">
                                                {{ $schedule->class_subject_name }}
                                            </h6>

                                            <div class="overflow-x-auto">
                                                <table class="min-w-full bg-white border border-gray-200">
                                                    <thead class="bg-gray-100">
                                                        <tr>
                                                            <th
                                                                class="px-4 py-2 text-sm font-medium text-left text-gray-700">
                                                                Pertemuan</th>
                                                            <th
                                                                class="px-4 py-2 text-sm font-medium text-left text-gray-700">
                                                                Presensi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($schedule->checkAttendances(auth()->user()) as $session => $status)
                                                            <tr class="border-t border-gray-200">
                                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                                    {{ $session }}</td>
                                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                                    {{ $status }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                    @empty
                                        <p class="text-gray-500">No schedules available for this period.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="p-4">
                                <div class="flex items-center justify-center">
                                    <div class="max-w-lg p-6 text-center bg-white rounded-lg shadow">
                                        <p class="text-gray-500">No schedules available for this academic year.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-app-layout>
