@props(['name', 'label', 'options', 'selected' => []])

@php
    $selected = is_array($selected) ? $selected : [];
    $uid = 'ms_' . str_replace(['[', ']', '.'], '_', $name) . '_' . rand(100,999);
@endphp

<div class="relative" x-data="{
    open: false,
    selected: @js(old(str_replace('[]', '', $name), $selected)),
    toggle(val) {
        const idx = this.selected.indexOf(val);
        if (idx === -1) this.selected.push(val);
        else this.selected.splice(idx, 1);
    },
    isSelected(val) {
        return this.selected.includes(val);
    },
    get label() {
        if (this.selected.length === 0) return 'Select...';
        if (this.selected.length <= 3) return this.selected.join(', ');
        return this.selected.length + ' selected';
    }
}" @click.outside="open = false">
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>

    <!-- Trigger -->
    <button type="button" @click="open = !open"
            class="w-full flex items-center justify-between px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-royal-blue focus:border-royal-blue text-left">
        <span x-text="label" class="truncate" :class="selected.length === 0 ? 'text-gray-400' : 'text-gray-900'"></span>
        <svg class="w-4 h-4 text-gray-400 ml-2 shrink-0 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
         class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
        @foreach($options as $value => $optionLabel)
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition-colors text-sm"
                   @click.stop>
                <input type="checkbox"
                       :checked="isSelected('{{ $value }}')"
                       @change="toggle('{{ $value }}')"
                       class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue mr-3">
                <span class="text-gray-700">{{ $optionLabel }}</span>
            </label>
        @endforeach
    </div>

    <!-- Hidden inputs -->
    <template x-for="val in selected" :key="val">
        <input type="hidden" :name="'{{ str_replace('[]', '', $name) }}[]'" :value="val">
    </template>
</div>
