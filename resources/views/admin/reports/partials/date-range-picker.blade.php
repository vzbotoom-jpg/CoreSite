{{-- resources/views/admin/reports/partials/date-range-picker.blade.php --}}
@props(['startDate' => null, 'endDate' => null, 'onChange' => null])

<div x-data="dateRangePicker()" x-init="init()" class="flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
        <input type="date" x-model="startDate" @change="onDateChange" class="input">
    </div>
    <div>
        <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
        <input type="date" x-model="endDate" @change="onDateChange" class="input">
    </div>
    <div>
        <label class="block text-sm font-medium mb-2">Preset</label>
        <select x-model="preset" @change="applyPreset" class="input">
            <option value="">Pilih Preset</option>
            <option value="today">Hari Ini</option>
            <option value="yesterday">Kemarin</option>
            <option value="this_week">Minggu Ini</option>
            <option value="last_week">Minggu Lalu</option>
            <option value="this_month">Bulan Ini</option>
            <option value="last_month">Bulan Lalu</option>
            <option value="this_year">Tahun Ini</option>
        </select>
    </div>
    <div>
        <button @click="applyFilter" class="btn btn-primary">
            Terapkan
        </button>
    </div>
</div>

<script>
function dateRangePicker() {
    return {
        startDate: '{{ $startDate ?? now()->startOfMonth()->format("Y-m-d") }}',
        endDate: '{{ $endDate ?? now()->format("Y-m-d") }}',
        preset: '',
        
        init() {
            this.startDate = '{{ $startDate ?? now()->startOfMonth()->format("Y-m-d") }}';
            this.endDate = '{{ $endDate ?? now()->format("Y-m-d") }}';
        },
        
        onDateChange() {
            this.preset = '';
            this.applyFilter();
        },
        
        applyPreset() {
            const today = new Date();
            const start = new Date();
            const end = new Date();
            
            switch(this.preset) {
                case 'today':
                    this.startDate = today.toISOString().split('T')[0];
                    this.endDate = today.toISOString().split('T')[0];
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(today.getDate() - 1);
                    this.startDate = yesterday.toISOString().split('T')[0];
                    this.endDate = yesterday.toISOString().split('T')[0];
                    break;
                case 'this_week':
                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    this.startDate = weekStart.toISOString().split('T')[0];
                    this.endDate = today.toISOString().split('T')[0];
                    break;
                case 'last_week':
                    const lastWeekStart = new Date(today);
                    lastWeekStart.setDate(today.getDate() - today.getDay() - 7);
                    const lastWeekEnd = new Date(lastWeekStart);
                    lastWeekEnd.setDate(lastWeekStart.getDate() + 6);
                    this.startDate = lastWeekStart.toISOString().split('T')[0];
                    this.endDate = lastWeekEnd.toISOString().split('T')[0];
                    break;
                case 'this_month':
                    this.startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                    this.endDate = today.toISOString().split('T')[0];
                    break;
                case 'last_month':
                    this.startDate = new Date(today.getFullYear(), today.getMonth() - 1, 1).toISOString().split('T')[0];
                    this.endDate = new Date(today.getFullYear(), today.getMonth(), 0).toISOString().split('T')[0];
                    break;
                case 'this_year':
                    this.startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                    this.endDate = today.toISOString().split('T')[0];
                    break;
            }
            this.applyFilter();
        },
        
        applyFilter() {
            @if(isset($onChange) && $onChange)
                {{ $onChange }}(this.startDate, this.endDate);
            @else
                // Trigger Alpine.js event
                this.$dispatch('date-range-change', {
                    startDate: this.startDate,
                    endDate: this.endDate
                });
            @endif
        }
    }
}
</script>