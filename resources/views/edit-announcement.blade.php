<x-app-layout>
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    @endpush
    @if(session('success_message'))
        <div class="bg-green-200 text-green-800 px-4 py-2">
            {{ session('success_message') }}
        </div>
    @endif

    @if(session('errors'))
        <div class="bg-red-200 text-red-700 px-4 py-2">
            <ul class="list-disc ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-md border my-8 px-6 py-6">
        <div>
            <h2 class="text-2xl font-semibold">Edit Announcement</h2>
            <form enctype="multipart/form-data"
                  action="/announcement/update"
                  method="POST"
                  class="max-w-2xl mt-4"
                  id="updateAnnouncement"
            >
                @csrf
                @method('PATCH')
                <div>
                    <h4 class="font-semibold">Is Active?</h4>
                    <div class="mt-2">
                        <div>
                            <input type="radio"
                                   name="is_active"
                                   id="isActiveYes"
                                   value="1"
                                   @checked($announcement->is_active)
                                   required
                            >
                            <label for="isActiveYes">Yes</label>
                        </div>
                        <div>
                            <input type="radio"
                                   name="is_active"
                                   id="isActiveNo"
                                   value="0"
                                   @checked(!$announcement->is_active)
                                   required
                            >
                            <label for="isActiveNo">No</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="banner_text" class="font-semibold block">Banner Text</label>
                    <input class="border border-gray-400 rounded w-full px-2 py-2 mt-2"
                           type="text"
                           name="banner_text"
                           id="banner_text"
                           value="{{ $announcement->banner_text }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="banner_color" class="font-semibold block">Banner Color</label>
                    <input type="color"
                           name="banner_color"
                           id="banner_color"
                           value="{{ $announcement->banner_color }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="title_text" class="font-semibold block">Title Text</label>
                    <input class="border border-gray-400 rounded w-full px-2 py-2 mt-2"
                           type="text"
                           name="title_text"
                           id="title_text"
                           value="{{ $announcement->title_text }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="title_color" class="font-semibold block">Title Color</label>
                    <input type="color"
                           name="title_color"
                           id="title_color"
                           value="{{ $announcement->title_color }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="content" class="font-semibold block">Content</label>
                    <textarea cols="30" rows="10"
                              class="hidden border border-gray-400 rounded w-full px-2 py-2 mt-2"
                              name="content"
                              id="content"
                              required
                    >{{ $announcement->content }}</textarea>
                    <div id="editor">
                        {!! $announcement->content !!}
                    </div>
                </div>

                <div class="mt-4">
                    <label for="button_text" class="font-semibold block">Button Text</label>
                    <input class="border border-gray-400 rounded w-full px-2 py-2 mt-2"
                           type="text"
                           name="button_text"
                           id="button_text"
                           value="{{ $announcement->button_text }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="button_color" class="font-semibold block">Button Color</label>
                    <input type="color"
                           name="button_color"
                           id="button_color"
                           value="{{ $announcement->button_color }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="button_link" class="font-semibold block">Button Link</label>
                    <input class="border border-gray-400 rounded w-full px-2 py-2 mt-2"
                           type="text"
                           name="button_link"
                           id="button_link"
                           value="{{ $announcement->button_link }}"
                           required
                    >
                </div>

                <div class="mt-4">
                    <label for="image_upload" class="font-semibold block">Image Upload</label>
                    <input class="mt-2"
                           type="file"
                           name="image_upload"
                           id="image_upload"
                           value="{{ $announcement->image_upload }}"
                           accept="image/*"
                    >
                </div>

                @if($announcement->image_upload)
                    <div class="mt-4">
                        <img src="{{ asset('storage/'.$announcement->image_upload) }}" alt="image" class="max-w-xs">
                    </div>
                @endif

                <!-- Filepond -->
                <div class="mt-4">
                    <label for="image_upload_filepond" class="font-semibold block">Image Upload Filepond</label>
                    <input class="mt-2"
                           type="file"
                           name="image_upload_filepond"
                           id="image_upload_filepond"
                           value="{{ $announcement->image_upload_filepond }}"
                           accept="image/*"
                    >
                </div>

                @if($announcement->image_upload_filepond)
                    <div class="mt-4">
                        <img src="{{ asset('storage/'.$announcement->image_upload_filepond) }}" alt="image" class="max-w-xs">
                    </div>
                @endif

                <div class="mt-8">
                    <button type="submit"
                            class="bg-blue-600 rounded inline-block text-white px-4 py-4"
                    >
                        Update Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <!-- Imports -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

        <script>
            //----------- Filepond

            // 1. Register plugins
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginImageTransform);
            FilePond.registerPlugin(FilePondPluginImageResize);

            // 2. Get a reference to the file input element
            const inputEl = document.querySelector('#image_upload_filepond');

            // 3. Create a FilePond instance
            const pond = FilePond.create(inputEl, {
                imageResizeTargetWidth: 800,
                imageResizeMode: 'contain',
                imageResizeUpscale: false,
                server: {
                    url: '/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                }
            });

            //----------- Quill editor

            // Initialize Quill editor
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Enter announcement details',
            });

            const form = document.querySelector('#updateAnnouncement')

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const quillEditor = document.querySelector('#editor');
                const html = quillEditor.children[0].innerHTML;

                document.querySelector('#content').value = html;

                form.submit();
            });

        </script>
    @endpush
</x-app-layout>
