<script>
    function mediaPicker(initialFeatured = '', initialGallery = []) {
        return {
            featuredImage: initialFeatured,
            galleryImages: initialGallery,
            showPicker: false,
            pickerMode: 'featured', // 'featured' or 'gallery'
            mediaItems: [],
            folders: [],
            searchQuery: '',
            folderFilter: '',
            loading: false,
            tempSelected: [],

            openPicker(mode) {
                this.pickerMode = mode;
                this.tempSelected = [];
                this.showPicker = true;
                this.loadMedia();
            },

            async loadMedia() {
                this.loading = true;
                try {
                    const params = new URLSearchParams();
                    if (this.searchQuery) params.set('search', this.searchQuery);
                    if (this.folderFilter) params.set('folder', this.folderFilter);

                    const response = await fetch('/dr-admin/media/api?' + params.toString(), {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    this.mediaItems = data.media;
                    this.folders = data.folders;
                } catch (e) {
                    console.error('Failed to load media:', e);
                } finally {
                    this.loading = false;
                }
            },

            selectMedia(item) {
                if (this.pickerMode === 'featured') {
                    this.tempSelected = [item.path];
                } else {
                    const idx = this.tempSelected.indexOf(item.path);
                    if (idx > -1) {
                        this.tempSelected.splice(idx, 1);
                    } else {
                        this.tempSelected.push(item.path);
                    }
                }
            },

            isSelected(item) {
                return this.tempSelected.includes(item.path);
            },

            confirmSelection() {
                if (this.pickerMode === 'featured') {
                    this.featuredImage = this.tempSelected[0] || '';
                } else {
                    this.galleryImages = [...this.galleryImages, ...this.tempSelected];
                }
                this.showPicker = false;
                this.tempSelected = [];
            }
        }
    }
</script>
