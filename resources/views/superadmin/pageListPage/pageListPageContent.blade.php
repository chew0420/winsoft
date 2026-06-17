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
</head>
<body>
    @if(session()->has('success'))
        <div class="flash-message flash-success">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @elseif(session()->has('error'))
        <div class="flash-message flash-error">
            <i class="fas fa-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-file-text"></i> Website Pages</h2>
            </div>

            <div class="row">
                @forelse($pages as $page)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body py-4">
                                <i class="bi bi-file-earmark-code" style="font-size: 48px; color: #667eea;"></i>
                                <p class="text-muted small">{{ $page->page_name }}</p>
                                @if($page->page_name == 'Visitor Home Page')
                                    <a href="{{ url('/superadmin/pageBuilder/'.$page->page_id) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i> Edit Page
                                    </a>
                                @else
                                    <a href="{{ url('/superadmin/webEditor/'.$page->page_id) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i> Edit Page
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> No pages found.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>