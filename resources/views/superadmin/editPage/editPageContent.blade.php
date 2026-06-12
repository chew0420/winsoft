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
        [contenteditable="true"] {
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 4px;
            cursor: text;
        }
        [contenteditable="true"]:hover {
            background: #ffe69e;
        }
        img {
            cursor: pointer;
            max-width: 100%;
            height: auto;
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
                <p class="text-muted mt-2">💡 Click on any text to edit. Click on any image to replace it.</p>
                <button type="submit" class="btn btn-primary mt-3" onclick="return confirm('Are you sure you want to Save Changes?')">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        var form = document.getElementById('editForm');
        var editContainer = document.getElementById('editContainer');
        var fileInput = null;
        var currentImage = null;

        // Handle image clicks for upload
        editContainer.addEventListener('click', function(event) {
            if(event.target.tagName === 'IMG') {
                event.preventDefault();
                currentImage = event.target;
                
                if (fileInput) {
                    fileInput.remove();
                }

                fileInput = document.createElement('input');
                fileInput.setAttribute('type', 'file');
                fileInput.setAttribute('name', 'images');
                fileInput.setAttribute('accept', 'image/*');
                fileInput.style.display = 'none';
                form.appendChild(fileInput);
                fileInput.click();

                fileInput.addEventListener('change', function(e) {
                    var file = e.target.files[0];
                    if (file) {
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size exceeds 2MB');
                            return;
                        }
                        
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            if (currentImage) {
                                currentImage.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // Handle form submission
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            var updatedContent = editContainer.innerHTML;
            
            var updatedContentInput = document.createElement('input');
            updatedContentInput.setAttribute('type', 'hidden');
            updatedContentInput.setAttribute('name', 'updatedContent');
            updatedContentInput.value = updatedContent;
            form.appendChild(updatedContentInput);
            
            form.submit();
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>