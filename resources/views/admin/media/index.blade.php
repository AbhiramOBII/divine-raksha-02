@extends('admin.layouts.app')

@section('title', 'Media Manager')
@section('page-title', 'Media Manager')

@section('content')
    <div x-data="mediaManager()" class="space-y-6">

        <!-- Upload Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue">Upload Images</h2>
                    <p class="text-sm text-gray-500">Drag & drop or click to upload (max 5MB each, up to 20 files)</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data"
                  class="relative"
                  x-ref="uploadForm">
                @csrf

                <div class="flex flex-col sm:flex-row gap-4 mb-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Folder</label>
                        <input type="text" name="folder" value="{{ request('folder', 'general') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="e.g. products, banners, blogs">
                    </div>
                </div>

                <!-- Drop Zone -->
                <label class="block cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-royal-blue hover:bg-royal-blue/5 transition-all"
                       @dragover.prevent="dragOver = true"
                       @dragleave.prevent="dragOver = false"
                       @drop.prevent="handleDrop($event)"
                       :class="dragOver ? 'border-royal-blue bg-royal-blue/5' : ''">
                    <input type="file" name="files[]" multiple accept="image/*"
                           class="hidden" @change="previewFiles($event)" x-ref="fileInput">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-600 font-medium">Drop images here or click to browse</p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, GIF, WebP, SVG — up to 5MB each</p>
                </label>

                <!-- Preview -->
                <template x-if="previews.length > 0">
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-700"><span x-text="previews.length"></span> file(s) selected</p>
                            <button type="button" @click="clearPreviews()" class="text-xs text-red-600 hover:underline">Clear</button>
                        </div>
                        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                            <template x-for="(preview, index) in previews" :key="index">
                                <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                        <button type="submit" class="mt-4 px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                            Upload Files
                        </button>
                    </div>
                </template>
            </form>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="Search by filename...">
                </div>
                <div>
                    <select name="folder" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="">All Folders</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder }}" {{ request('folder') == $folder ? 'selected' : '' }}>{{ ucfirst($folder) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Filter
                </button>
                @if(request('search') || request('folder'))
                    <a href="{{ route('admin.media.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">Clear</a>
                @endif
            </form>
        </div>

        <!-- Bulk Actions -->
        <div x-show="selected.length > 0" x-cloak class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center justify-between">
            <p class="text-sm text-red-700 font-medium"><span x-text="selected.length"></span> file(s) selected</p>
            <form method="POST" action="{{ route('admin.media.bulkDelete') }}" @submit.prevent="confirmBulkDelete($event)">
                @csrf
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Delete Selected
                </button>
            </form>
        </div>

        <!-- Media Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($media as $item)
                <div class="group relative bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
                     :class="selected.includes({{ $item->id }}) ? 'ring-2 ring-royal-blue' : ''">
                    <!-- Checkbox -->
                    <div class="absolute top-2 left-2 z-10">
                        <input type="checkbox" value="{{ $item->id }}"
                               class="w-4 h-4 rounded border-gray-300 text-royal-blue focus:ring-royal-blue"
                               @change="toggleSelect({{ $item->id }})">
                    </div>

                    <!-- Image -->
                    <div class="aspect-square bg-gray-50 relative cursor-pointer" @click="openDetail({{ json_encode($item) }})">
                        <img src="{{ $item->url }}" alt="{{ $item->alt_text ?? $item->original_name }}"
                             class="w-full h-full object-cover" loading="lazy">
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-2">
                        <p class="text-xs text-gray-700 font-medium truncate" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                        <p class="text-xs text-gray-400">{{ $item->size_formatted }} &middot; {{ ucfirst($item->folder) }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">No media files found</p>
                    <p class="text-sm text-gray-400 mt-1">Upload some images to get started</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $media->links() }}
        </div>

        <!-- Detail Modal -->
        <div x-show="detailItem" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="detailItem = null">
            <div class="fixed inset-0 bg-black/50" @click="detailItem = null"></div>
            <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.stop>
                <button @click="detailItem = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <template x-if="detailItem">
                    <div class="p-6">
                        <!-- Preview -->
                        <div class="rounded-xl overflow-hidden bg-gray-100 mb-6 max-h-80 flex items-center justify-center">
                            <img :src="'/storage/' + detailItem.path" :alt="detailItem.original_name" class="max-w-full max-h-80 object-contain">
                        </div>

                        <!-- Info -->
                        <div class="space-y-3 mb-6">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Filename</span>
                                    <p class="font-medium text-gray-900 truncate" x-text="detailItem.original_name"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Folder</span>
                                    <p class="font-medium text-gray-900" x-text="detailItem.folder"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Size</span>
                                    <p class="font-medium text-gray-900" x-text="formatSize(detailItem.size)"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Type</span>
                                    <p class="font-medium text-gray-900" x-text="detailItem.mime_type"></p>
                                </div>
                            </div>

                            <!-- URL Copy -->
                            <div>
                                <span class="text-sm text-gray-500">URL</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <input type="text" :value="'/storage/' + detailItem.path" readonly
                                           class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-mono text-gray-600" x-ref="urlInput">
                                    <button type="button" @click="copyUrl()" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 text-xs font-medium transition-colors">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Alt Text Form -->
                        <form :action="'/dr-admin/media/' + detailItem.id" method="POST" class="mb-4">
                            @csrf
                            @method('PUT')
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                            <div class="flex gap-2">
                                <input type="text" name="alt_text" :value="detailItem.alt_text || ''"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                                       placeholder="Describe this image...">
                                <button type="submit" class="px-4 py-2 bg-royal-blue text-white text-sm rounded-lg hover:bg-deep-royal transition-colors">Save</button>
                            </div>
                        </form>

                        <!-- Delete -->
                        <form :action="'/dr-admin/media/' + detailItem.id" method="POST" @submit.prevent="confirmDelete($event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors border border-red-200">
                                Delete This Image
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function mediaManager() {
            return {
                previews: [],
                dragOver: false,
                selected: [],
                detailItem: null,

                previewFiles(event) {
                    this.previews = [];
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => this.previews.push(e.target.result);
                        reader.readAsDataURL(files[i]);
                    }
                },

                handleDrop(event) {
                    this.dragOver = false;
                    const dt = event.dataTransfer;
                    this.$refs.fileInput.files = dt.files;
                    this.previewFiles({ target: { files: dt.files } });
                },

                clearPreviews() {
                    this.previews = [];
                    this.$refs.fileInput.value = '';
                },

                toggleSelect(id) {
                    const idx = this.selected.indexOf(id);
                    if (idx > -1) {
                        this.selected.splice(idx, 1);
                    } else {
                        this.selected.push(id);
                    }
                },

                openDetail(item) {
                    this.detailItem = item;
                },

                copyUrl() {
                    const url = window.location.origin + '/storage/' + this.detailItem.path;
                    navigator.clipboard.writeText(url);
                },

                formatSize(bytes) {
                    if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
                    return (bytes / 1024).toFixed(1) + ' KB';
                },

                confirmDelete(event) {
                    if (confirm('Are you sure you want to delete this image?')) {
                        event.target.submit();
                    }
                },

                confirmBulkDelete(event) {
                    if (confirm('Delete ' + this.selected.length + ' selected file(s)?')) {
                        event.target.submit();
                    }
                }
            }
        }
    </script>
@endsection
