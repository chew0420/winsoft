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
        /* =========================================
        PAGE BUILDER - SECTION CARD
        ========================================= */

        .section-item {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            position: relative;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);

            transition: all 0.25s ease;
        }

        .section-item:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }


        /* =========================================
        SORTING STATE
        ========================================= */

        .section-item.ui-sortable-helper {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
            transform: rotate(0.5deg);
        }

        .section-placeholder {
            height: 140px;

            border: 2px dashed #0d6efd;
            border-radius: 12px;

            background: rgba(13, 110, 253, 0.05);

            margin-bottom: 20px;
        }


        /* =========================================
        SECTION TOOLBAR
        ========================================= */

        .section-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 14px 16px;

            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-toolbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }


        /* =========================================
        DRAG HANDLE
        ========================================= */

        .drag-handle {
            cursor: grab;

            width: 30px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #94a3b8;

            font-size: 20px;

            flex-shrink: 0;

            transition: color 0.2s ease;
        }

        .drag-handle:hover {
            color: #0d6efd;
        }

        .drag-handle:active {
            cursor: grabbing;
        }


        /* =========================================
        SECTION TYPE ICON
        ========================================= */

        .section-type-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 8px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 18px;
        }


        /* =========================================
        SECTION TITLE
        ========================================= */

        .section-title-area {
            display: flex;
            flex-direction: column;
        }

        .section-title-area strong {
            font-size: 15px;
            color: #1f2937;
        }

        .section-type-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }


        /* =========================================
        STATUS BADGE
        ========================================= */

        .badge-status {
            font-size: 11px;
            padding: 4px 8px;
            margin-left: 6px;
        }


        /* =========================================
        ACTION BUTTONS
        ========================================= */

        .section-toolbar .actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-toolbar .actions button {
            margin: 0;
        }


        /* =========================================
        SECTION PREVIEW
        ========================================= */

        .section-preview {
            padding: 20px;

            background: #ffffff;

            min-height: 120px;
            max-height: 420px;

            overflow: auto;
        }

        /*
        Keep preview images responsive,
        but do not force a fixed height.
        */
        .section-preview img {
            max-width: 100%;
        }


        /* =========================================
        PREVIEW FOOTER
        ========================================= */

        .section-preview-label {
            padding: 8px 16px;

            background: #f9fafb;
            border-top: 1px solid #f0f0f0;

            font-size: 12px;
            color: #94a3b8;
        }


        /* =========================================
        ADD SECTION SIDEBAR
        ========================================= */

        .sidebar-form .form-control {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-pencil"></i> Editing... {{ $page->page_name }}</h2>
            </div>
            <div class="container-fluid mt-4">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3">
                        <div class="card sidebar-form">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add Section</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/superadmin/page/'.$page->page_id.'/addSection') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Section Type</label>
                                        <select name="section_type" class="form-select" required>
                                            <option value="hero">Hero Banner</option>
                                            <option value="products">Products Grid</option>
                                            <option value="categories">Categories</option>
                                            <option value="banner">Banner</option>
                                            <option value="featured">Featured Products</option>
                                            <option value="custom_html">Custom HTML</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Section Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter section title">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-plus"></i> Add Section
                                    </button>
                                </form>
                                
                                <hr>
                                
                                <a href="{{ url('/superadmin/pageList') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-left"></i> Back to Pages
                                </a>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6>Page: <strong>{{ $page->page_name }}</strong></h6>
                                <p class="text-muted small">Total Sections: <span class="badge bg-primary">{{ $sections->count() }}</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2><i class="bi bi-layout-three-columns"></i> Page Builder</h2>
                            <div>
                                <button class="btn btn-success" onclick="previewPage()">
                                    <i class="bi bi-eye"></i> Preview
                                </button>
                            </div>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <div id="sections-container">
                            @if($sections->isEmpty())
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> No sections added yet. Start building your page by adding sections from the sidebar!
                                </div>
                            @else
                                @foreach($sections as $section)
                                    <div
                                        class="section-item"
                                        data-section-id="{{ $section->section_id }}"
                                        data-is-active="{{ $section->is_active ? 'true' : 'false' }}"
                                    >

                                        <div class="section-toolbar">

                                            <div class="section-toolbar-left">

                                                <span
                                                    class="drag-handle"
                                                    title="Drag to reorder"
                                                >
                                                    <i class="bi bi-grip-vertical"></i>
                                                </span>

                                                @php
                                                    $sectionIcon = match($section->section_type) {
                                                        'hero' => 'bi-image',
                                                        'products' => 'bi-grid',
                                                        'categories' => 'bi-tags',
                                                        'banner' => 'bi-card-image',
                                                        'featured' => 'bi-star',
                                                        'custom_html' => 'bi-code-slash',
                                                        default => 'bi-layout-text-window'
                                                    };

                                                    $sectionLabel = match($section->section_type) {
                                                        'hero' => 'Hero Banner',
                                                        'products' => 'Products Grid',
                                                        'categories' => 'Categories',
                                                        'banner' => 'Banner',
                                                        'featured' => 'Featured Products',
                                                        'custom_html' => 'Custom HTML',
                                                        default => ucfirst($section->section_type)
                                                    };
                                                @endphp

                                                <div class="section-type-icon">
                                                    <i class="bi {{ $sectionIcon }}"></i>
                                                </div>

                                                <div class="section-title-area">

                                                    <strong>
                                                        {{ $section->title ?: $sectionLabel }}
                                                    </strong>

                                                    <span class="section-type-label">
                                                        {{ $sectionLabel }}
                                                    </span>

                                                </div>

                                                @if($section->is_active)
                                                    <span class="badge bg-success badge-status">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary badge-status">
                                                        Hidden
                                                    </span>
                                                @endif

                                            </div>


                                            <div class="actions">

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    onclick="editSection({{ $section->section_id }})"
                                                    title="Edit Section"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    onclick="toggleSection({{ $section->section_id }})"
                                                    title="{{ $section->is_active ? 'Hide Section' : 'Show Section' }}"
                                                >
                                                    <i class="bi {{ $section->is_active ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteSection({{ $section->section_id }})"
                                                    title="Delete Section"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </div>

                                        </div>


                                        <div class="section-preview">

                                            @if($section->is_active)

                                                {!! $section->render() !!}

                                            @else

                                                <div class="text-center text-muted py-4">
                                                    <i class="bi bi-eye-slash fs-2 d-block mb-2"></i>
                                                    This section is currently hidden.
                                                </div>

                                            @endif

                                        </div>


                                        <div class="section-preview-label">
                                            Section ID: {{ $section->section_id }}
                                            &nbsp;•&nbsp;
                                            Drag using the handle to reorder
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="editModalBody">
                            <!-- Dynamic content -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <div class="modal fade" id="previewModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Page Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="previewModalBody">
                            <!-- Preview content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>

    $(document).ready(function() {

        /*
        |--------------------------------------------------------------------------
        | Sortable Sections
        |--------------------------------------------------------------------------
        */

        $("#sections-container").sortable({

            handle: '.drag-handle',
            axis: 'y',
            placeholder: 'section-placeholder',
            tolerance: 'pointer',

            update: function(event, ui) {

                var order = [];

                $('.section-item').each(function() {

                    order.push(
                        $(this).data('section-id')
                    );

                });

                $.ajax({

                    url: "{{ url('/superadmin/sections/reorder') }}",

                    method: 'POST',

                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },

                    success: function(response) {

                        if(response.success) {

                            showToast(
                                'Sections reordered successfully!',
                                'success'
                            );

                        }

                    },

                    error: function() {

                        showToast(
                            'Error reordering sections',
                            'danger'
                        );

                    }

                });

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Edit Section
    |--------------------------------------------------------------------------
    */

    function editSection(sectionId) {

        $.ajax({

            url: '/superadmin/section/' + sectionId + '/edit',

            method: 'GET',

            success: function(response) {

                $('#editModalBody').html(response);

                var modal =
                    new bootstrap.Modal(
                        document.getElementById('editModal')
                    );

                modal.show();

            },

            error: function() {

                showToast(
                    'Error loading section editor',
                    'danger'
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Section
    |--------------------------------------------------------------------------
    */

    function deleteSection(sectionId) {

        if (
            !confirm(
                'Are you sure you want to delete this section?'
            )
        ) {
            return;
        }

        $.ajax({

            url: '/superadmin/section/' + sectionId + '/delete',

            method: 'DELETE',

            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {

                if(response.success) {
                    location.reload();
                }

            },

            error: function() {

                showToast(
                    'Error deleting section',
                    'danger'
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Section
    |--------------------------------------------------------------------------
    */

    function toggleSection(sectionId) {

        $.ajax({

            url: '/superadmin/section/' + sectionId + '/toggle',

            method: 'POST',

            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {

                if(response.success) {
                    location.reload();
                }

            },

            error: function() {

                showToast(
                    'Error toggling section',
                    'danger'
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Preview Page
    |--------------------------------------------------------------------------
    */

    function previewPage() {

        var previewContent = '';

        $('.section-item').each(function() {

            var isActive =
                $(this).data('is-active');

            if (
                isActive === true ||
                isActive === 'true'
            ) {

                previewContent +=
                    $(this)
                    .find('.section-preview')
                    .html();

            }

        });

        if (previewContent === '') {

            previewContent =
                '<div class="alert alert-warning">' +
                'No active sections to preview.' +
                '</div>';

        }

        $('#previewModalBody').html(
            previewContent
        );

        var modal =
            new bootstrap.Modal(
                document.getElementById('previewModal')
            );

        modal.show();

    }


    /*
    |--------------------------------------------------------------------------
    | Toast Message
    |--------------------------------------------------------------------------
    */

    function showToast(message, type) {

        var alertClass =
            type === 'success'
                ? 'alert-success'
                : 'alert-danger';

        var alert = $(

            '<div class="alert ' +
            alertClass +
            ' alert-dismissible fade show" role="alert">' +

            message +

            '<button type="button" ' +
            'class="btn-close" ' +
            'data-bs-dismiss="alert"></button>' +

            '</div>'

        );

        $('.container-fluid').prepend(alert);

        setTimeout(function() {

            alert.alert('close');

        }, 5000);

    }

    </script>
</body>
</html>