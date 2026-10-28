<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/superadmin.css" rel="stylesheet"/>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* =========================
        Editable Text
        ========================= */

        #editContainer [contenteditable="true"] {
            outline: 1px dashed transparent;
            outline-offset: 3px;
            border-radius: 5px;
            cursor: text;
            transition: all 0.2s ease;
        }

        #editContainer [contenteditable="true"]:hover {
            outline-color: #0d6efd;
            background: rgba(13, 110, 253, 0.05);
        }

        #editContainer [contenteditable="true"]:focus {
            outline: 2px solid #0d6efd;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.10);
        }


        /* =========================
        Editable Images
        ========================= */

        #editContainer img {
            cursor: pointer;
            transition: outline 0.2s ease, opacity 0.2s ease;
        }

        #editContainer img:hover {
            outline: 3px solid #0d6efd;
            outline-offset: 3px;
            opacity: 0.88;
        }


        /* =========================
        Image Wrapper
        ========================= */

        .editor-image-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        .editor-image-wrapper img {
            display: block;
        }

        .editor-image-overlay {
            position: absolute;
            inset: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(17, 24, 39, 0.55);

            color: white;

            font-size: 14px;
            font-weight: 600;

            opacity: 0;

            pointer-events: none;

            transition: opacity 0.2s ease;

            border-radius: inherit;
        }

        .editor-image-wrapper:hover .editor-image-overlay {
            opacity: 1;
        }

        .editor-image-overlay i {
            margin-right: 7px;
        }


        /* =========================
        Editor Information
        ========================= */

        .editor-info-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;

            padding: 14px 16px;

            background: #eef6ff;
            border: 1px solid #cfe2ff;
            border-radius: 8px;

            color: #334155;

            font-size: 14px;
        }

        .editor-info-box i {
            color: #0d6efd;
            font-size: 18px;
            margin-top: 1px;
        }

        /* Default image wrapper */
        .editor-image-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }


        /* Store Location image wrapper */
        .editor-image-wrapper:has(.store-image) {
            display: block;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }


        /* Keep original Store Location image appearance */
        .editor-image-wrapper .store-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-pencil"></i> Editing... {{ $page->page_name }}</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url('/superadmin/pageList') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
            </div>

            <form id="editForm" method="post" action="{{ url('/superadmin/webEditor/saveEdit/' . $page->page_id) }}" enctype="multipart/form-data">
                @csrf

                <div id="editContainer" style="background-color: white; border: 2px solid #007bff; min-height: 400px; overflow: auto; padding: 20px; border-radius: 10px;">
                    {!! $editableContent !!}
                </div>

                <div class="editor-info-box mt-3">
                    <i class="bi bi-info-circle-fill"></i>

                    <div>
                        <strong>Visual Editor</strong><br>
                        Click any editable text to update its content.
                        Hover over an image and click it to replace the image.
                        Changes are not saved until you click
                        <strong>Save Changes</strong>.
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetChanges()"> <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Changes
                    </button>

                    <button type="submit" class="btn btn-primary"> <i class="bi bi-save"></i>
                        Save Changes
                    </button>

                </div>
            </form>
        </div>
    </div>

    <script>
    var form = document.getElementById('editForm');
    var editContainer = document.getElementById('editContainer');
    var fileInput = null;

    function initializeEditableImages() {
        var images = editContainer.querySelectorAll('img');

        images.forEach(function(img) {

            // Avoid wrapping the same image twice
            if (
                img.parentElement &&
                img.parentElement.classList.contains('editor-image-wrapper')
            ) {
                return;
            }

            var wrapper = document.createElement('span');

            wrapper.className = 'editor-image-wrapper';

            img.parentNode.insertBefore(wrapper, img);

            wrapper.appendChild(img);

            var overlay = document.createElement('span');

            overlay.className = 'editor-image-overlay';

            overlay.innerHTML =
                '<i class="bi bi-image"></i> Replace Image';

            wrapper.appendChild(overlay);
        });
    }

    initializeEditableImages();

    var originalContent = editContainer.innerHTML;
    var isSubmitting = false;

    // Handle image clicks for upload
    editContainer.addEventListener('click', function(event) {
        // Check if the clicked element is an IMG
        if(event.target.tagName === 'IMG') {
            event.preventDefault();
            event.stopPropagation();
            
            // Store the specific image that was clicked
            var clickedImage = event.target;
            
            if (fileInput) {
                fileInput.remove();
            }

            fileInput = document.createElement('input');
            fileInput.setAttribute('type', 'file');
            fileInput.setAttribute('accept', 'image/*');
            fileInput.style.display = 'none';
            form.appendChild(fileInput);
            fileInput.click();

            // Use a closure to capture the specific clicked image
            fileInput.addEventListener('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size exceeds 2MB');
                        return;
                    }
                    
                    var reader = new FileReader();

                    reader.onload = function(e) {

                        // Save the original image path before replacing it
                        if (!clickedImage.getAttribute('data-old-src')) {
                            clickedImage.setAttribute(
                                'data-old-src',
                                clickedImage.getAttribute('src')
                            );
                        }

                        // Preview the newly selected image
                        clickedImage.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                }
                
                // Clean up
                fileInput.remove();
                fileInput = null;
            });
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var currentEditorContent = editContainer.innerHTML;

        if (currentEditorContent === originalContent) {
            alert('No changes detected.');
            return;
        }

        if (!confirm('Are you sure you want to save these changes?')) {
            return;
        }

        var updatedContent = getCleanEditorContent();

        isSubmitting = true;

        var existingInput =
            form.querySelector('input[name="updatedContent"]');

        if (existingInput) {
            existingInput.remove();
        }

        var updatedContentInput =
            document.createElement('input');

        updatedContentInput.type = 'hidden';

        updatedContentInput.name =
            'updatedContent';

        updatedContentInput.value =
            updatedContent;

        form.appendChild(updatedContentInput);

        form.submit();
    });

    function resetChanges() {
        if (editContainer.innerHTML === originalContent) {
            alert('No changes to reset.');
            return;
        }

        if (confirm('Are you sure you want to reset all unsaved changes?')) {
            editContainer.innerHTML = originalContent;
        }
    }

    window.addEventListener('beforeunload', function(event) {
        if (
            !isSubmitting &&
            editContainer.innerHTML !== originalContent
        ) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    function getCleanEditorContent() {
        var clone = editContainer.cloneNode(true);

        /*
        |--------------------------------------------------------------------------
        | Remove image editor wrappers
        |--------------------------------------------------------------------------
        */

        clone.querySelectorAll('.editor-image-wrapper').forEach(function(wrapper) {

            var img = wrapper.querySelector('img');

            if (img) {
                wrapper.parentNode.insertBefore(img, wrapper);
            }

            wrapper.remove();
        });

        /*
        |--------------------------------------------------------------------------
        | Remove editor-only contenteditable attribute
        |--------------------------------------------------------------------------
        */

        clone.querySelectorAll('[contenteditable]').forEach(function(element) {
            element.removeAttribute('contenteditable');
        });

        return clone.innerHTML;
    }
</script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>