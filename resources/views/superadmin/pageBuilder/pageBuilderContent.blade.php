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
        .section-item {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: move;
            position: relative;
            transition: all 0.3s;
        }
        
        .section-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-left: 4px solid #0d6efd;
        }
        
        .section-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .section-toolbar .actions button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            margin-left: 5px;
            border-radius: 4px;
        }
        
        .section-toolbar .actions button:hover {
            background: #f0f0f0;
        }
        
        .drag-handle {
            cursor: move;
            color: #999;
            margin-right: 10px;
        }
        
        .section-preview {
            padding: 15px;
            background: #fafafa;
            border-radius: 4px;
            min-height: 100px;
        }
        
        .section-preview img {
            max-width: 100%;
            height: auto;
        }
        
        .sidebar-form .form-control {
            margin-bottom: 15px;
        }
        
        .badge-status {
            font-size: 11px;
            padding: 4px 8px;
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
                                    <div class="section-item" data-section-id="{{ $section->section_id }}" data-is-active="{{ $section->is_active ? 'true' : 'false' }}">
                                        <div class="section-toolbar">
                                            <div>
                                                <strong>{{ $section->title ?? ucfirst($section->section_type) }}</strong>
                                                <span class="badge bg-secondary">{{ $section->section_type }}</span>
                                                @if($section->is_active)
                                                    <span class="badge bg-success badge-status">Active</span>
                                                @else
                                                    <span class="badge bg-warning text-dark badge-status">Inactive</span>
                                                @endif
                                            </div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-info" style="background-color: #49b4df; color: white; border: none;" onclick="editSection({{ $section->section_id }})">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-warning" style="background-color: #ffda33; color: black; border: none;" onclick="toggleSection({{ $section->section_id }})">
                                                    <i class="bi {{ $section->is_active ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" style="background-color: #dc3545; color: white; border: none;" onclick="deleteSection({{ $section->section_id }})">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="section-preview">
                                            {!! $section->render() !!}
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
    <script>
        $(document).ready(function() {
            // Make sections sortable
            $("#sections-container").sortable({
                handle: '.drag-handle',
                placeholder: 'section-item placeholder',
                update: function(event, ui) {
                    var order = [];
                    $('.section-item').each(function(index) {
                        order.push($(this).data('section-id'));
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
                                showToast('Sections reordered successfully!', 'success');
                            }
                        }
                    });
                }
            }).disableSelection();
        });

        function editSection(sectionId) {
            $.ajax({
                url: '/superadmin/section/' + sectionId + '/edit',
                method: 'GET',
                success: function(response) {
                    $('#editModalBody').html(response);
                    $('#editModal').modal('show');
                },
                error: function() {
                    showToast('Error loading section editor', 'danger');
                }
            });
        }

        function deleteSection(sectionId) {
            if(confirm('Are you sure you want to delete this section?')) {
                $.ajax({
                    url: '/superadmin/section/' + sectionId + '/delete',
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        }
                    },
                    error: function() {
                        showToast('Error deleting section', 'danger');
                    }
                });
            }
        }

        function toggleSection(sectionId) {
            $.ajax({
                url: '/superadmin/section/' + sectionId + '/toggle',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showToast('Error toggling section', 'danger');
                }
            });
        }

        function previewPage() {
            var previewContent = '';
            // Only include sections that are active
            $('.section-item').each(function() {
                var isActive = $(this).data('is-active');
                if (isActive === true || isActive === 'true') {
                    previewContent += $(this).find('.section-preview').html();
                }
            });
            
            if (previewContent === '') {
                previewContent = '<div class="alert alert-warning">No active sections to preview.</div>';
            }
            
            $('#previewModalBody').html(previewContent);
            $('#previewModal').modal('show');
        }

        function showToast(message, type) {
            // Simple notification
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var alert = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' + 
                        message + 
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>');
            $('.container-fluid').prepend(alert);
            
            setTimeout(function() {
                alert.alert('close');
            }, 5000);
        }
        </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI for Sortable -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</body>
</html>