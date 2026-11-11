<x-app-layout>
    @if($img->caption)
        <p class="small text-muted mt-1 text-center">{{ $img->caption }}</p>
    @endif

    <div class="row g-3">
        @foreach($project->images as $img)
            <div class="col-md-4">
                <img src="{{ Storage::url($img->image) }}"
                     alt="{{ $img->caption ?? $project->name }}"
                     class="img-fluid rounded shadow-sm"
                     style="cursor: pointer; height: 220px; width: 100%; object-fit: cover;"
                     data-bs-toggle="modal"
                     data-bs-target="#lightboxModal"
                     onclick="openLightbox('{{ Storage::url($img->image) }}', '{{ addslashes($img->caption ?? '') }}')">
                @if($img->caption)
                    <p class="small text-muted mt-1">{{ $img->caption }}</p>
                @endif
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h6 class="modal-title" id="lightboxCaption"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="lightboxImage" src="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLightbox(src, caption) {
            document.getElementById('lightboxImage').src = src;
            document.getElementById('lightboxCaption').innerText = caption;
        }
    </script>
</x-app-layout>