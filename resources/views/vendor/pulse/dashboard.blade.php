<x-pulse>
    {{-- Top Section: Critical Metrics --}}
    <livewire:pulse.servers cols="full" />

    <livewire:pulse.exceptions cols="6" />

    <livewire:pulse.slow-requests cols="6" />

    <livewire:pulse.slow-queries cols="4" />

    {{-- Middle Section: Resource Utilization --}}
    <livewire:pulse.usage cols="4" rows="2" />

    <livewire:pulse.cache cols="4" />

    <livewire:database cols="6" title="Active Threads"
        :values="['Threads_connected', 'Threads_running']"
        :graphs="[
            'avg' => ['Threads_connected' => '#ffffff', 'Threads_running' => '#3c5dff'],
        ]"
    />

    <livewire:database cols="6" title="Connections"
        :values="['Connections', 'Max_used_connections']"
    />

    {{-- Optional/Additional Section --}}
    <livewire:pulse.slow-outgoing-requests cols="6" />

    {{-- Uncomment these if needed --}}
    {{-- <livewire:pulse.queues cols="4" /> --}}
    {{-- <livewire:pulse.slow-jobs cols="6" /> --}}
    {{-- <livewire:database cols='full' title="Innodb"
        :values="['Innodb_buffer_pool_reads', 'Innodb_buffer_pool_read_requests', 'Innodb_buffer_pool_pages_total']"
        :graphs="[
            'avg' => ['Innodb_buffer_pool_reads' => '#ffffff', 'Innodb_buffer_pool_read_requests' => '#3c5dff'],
        ]"
    /> --}}
</x-pulse>
