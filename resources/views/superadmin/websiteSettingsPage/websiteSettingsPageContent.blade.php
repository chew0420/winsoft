<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings | {{ $websiteSettings->website_name }}</title>
    <link rel="icon" href="{{ $websiteSettings->favicon_url }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/superadmin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
<div class="d-flex">
    <main class="main-content pl-page ws-page">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please check your information.</strong>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="pl-breadcrumb">
            <a href="{{ url('/superadminHomePage') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <span>Website Management</span>
            <i class="bi bi-chevron-right"></i>
            <span>Website Settings</span>
        </div>

        <section class="pl-banner">
            <div class="pl-banner-content">
                <span>WEBSITE MANAGEMENT</span>
                <h1>Website Settings</h1>
                <p>Manage your website branding, logo and browser appearance from one place.</p>
            </div>
            <div class="pl-banner-icon"><i class="bi bi-gear"></i></div>
        </section>

        <div class="ws-global-notice">
            <div class="ws-notice-icon"><i class="bi bi-globe2"></i></div>
            <div>
                <h4>Global Website Settings</h4>
                <p>Saved branding changes will appear across connected website pages, including all user roles.</p>
            </div>
        </div>

        <nav class="ws-settings-tabs">
            <a href="{{ url('/superadmin/websiteSettings?tab=branding') }}" class="ws-settings-tab {{ $activeTab === 'branding' ? 'active' : '' }}">
                <i class="bi bi-palette"></i>
                <div>
                    <strong>Branding</strong>
                    <span>Logo, name & favicon</span>
                </div>
            </a>
            <a href="{{ url('/superadmin/websiteSettings?tab=footer') }}" class="ws-settings-tab {{ $activeTab === 'footer' ? 'active' : '' }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <div>
                    <strong>Footer</strong>
                    <span>Content & visibility</span>
                </div>
            </a>
            <a href="{{ url('/superadmin/websiteSettings?tab=contact') }}" class="ws-settings-tab {{ $activeTab === 'contact' ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i>
                <div>
                    <strong>Contact & Social</strong>
                    <span>Contact details & links</span>
                </div>
            </a>
        </nav>

        @if($activeTab === 'branding')

        {{-- Website Name --}}
        <section class="ws-card">
            <div class="ws-card-header">
                <div class="ws-section-icon"><i class="bi bi-globe"></i></div>
                <div>
                    <h2>General Information</h2>
                    <p>Manage your website name and brand identity.</p>
                </div>
            </div>

            <form method="post" action="{{ url('/superadmin/websiteSettings/update') }}" id="websiteNameForm">
                @csrf
                <input type="hidden" name="type" value="website_name">

                <div class="ws-card-body">
                    <div class="ws-form-group">
                        <label for="websiteName">Website Name <span>*</span></label>
                        <input type="text" class="form-control" name="website_name" id="websiteName" value="{{ old('website_name', $websiteSettings->website_name) }}" maxlength="100" required>
                        <small>This name is displayed in your website branding and connected page titles.</small>
                    </div>
                </div>
            </form>

            <div class="ws-card-footer">
                <form method="post" action="{{ url('/superadmin/websiteSettings/reset/website_name') }}" onsubmit="return confirm('Restore the default website name?');">
                    @csrf
                    <button type="submit" class="ws-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Restore Default</button>
                </form>
                <button type="submit" form="websiteNameForm" class="ws-save-btn"><i class="bi bi-check2"></i> Save Website Name</button>
            </div>
        </section>

        {{-- Website Logo --}}
        <section class="ws-card">
            <div class="ws-card-header">
                <div class="ws-section-icon"><i class="bi bi-image"></i></div>
                <div>
                    <h2>Website Logo</h2>
                    <p>Customize the logo displayed across all user interfaces.</p>
                </div>
            </div>

            <form method="post" action="{{ url('/superadmin/websiteSettings/update') }}" enctype="multipart/form-data" id="websiteLogoForm">
                @csrf
                <input type="hidden" name="type" value="website_logo">

                <div class="ws-card-body">
                    <div class="ws-image-grid">
                        <div class="ws-preview-group">
                            <label>Current Logo</label>
                            <div class="ws-image-preview">
                                <img src="{{ $websiteSettings->logo_url }}" alt="{{ $websiteSettings->website_name }}">
                            </div>
                            <small>Currently displayed website logo</small>
                        </div>

                        <div class="ws-preview-group">
                            <label>Upload New Logo</label>
                            <label for="websiteLogoInput" class="ws-upload-area">
                                <div class="ws-upload-placeholder" id="logoPlaceholder">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <strong>Choose Logo Image</strong>
                                    <span>PNG, JPG, JPEG or WEBP</span>
                                    <span>Maximum 2 MB</span>
                                </div>
                                <img id="logoPreview" alt="New logo preview" hidden>
                            </label>
                            <input type="file" name="website_logo" id="websiteLogoInput" class="visually-hidden" accept="image/png,image/jpeg,image/webp" required>
                            <small id="logoFileName">No new image selected</small>
                        </div>
                    </div>

                    <div class="ws-tip">
                        <i class="bi bi-info-circle"></i>
                        <span>For the best appearance, use a high-quality PNG image with a transparent background.</span>
                    </div>
                </div>
            </form>

            <div class="ws-card-footer">
                <form method="post" action="{{ url('/superadmin/websiteSettings/reset/website_logo') }}" onsubmit="return confirm('Restore the original website logo?');">
                    @csrf
                    <button type="submit" class="ws-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Reset Logo</button>
                </form>
                <button type="submit" form="websiteLogoForm" id="saveLogoButton" class="ws-save-btn" disabled><i class="bi bi-check2"></i> Save Logo</button>
            </div>
        </section>

        {{-- Website Favicon --}}
        <section class="ws-card">
            <div class="ws-card-header">
                <div class="ws-section-icon"><i class="bi bi-window"></i></div>
                <div>
                    <h2>Website Favicon</h2>
                    <p>Manage the website icon displayed in browser tabs and bookmarks.</p>
                </div>
            </div>

            <form method="post" action="{{ url('/superadmin/websiteSettings/update') }}" enctype="multipart/form-data" id="websiteFaviconForm">
                @csrf
                <input type="hidden" name="type" value="favicon">

                <div class="ws-card-body">
                    <div class="ws-image-grid">
                        <div class="ws-preview-group">
                            <label>Current Favicon</label>
                            <div class="ws-image-preview ws-favicon-preview">
                                <img src="{{ $websiteSettings->favicon_url }}" alt="Current favicon">
                            </div>
                            <small>Currently displayed browser icon</small>
                        </div>

                        <div class="ws-preview-group">
                            <label>Upload New Favicon</label>
                            <label for="websiteFaviconInput" class="ws-upload-area ws-favicon-upload">
                                <div class="ws-upload-placeholder" id="faviconPlaceholder">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <strong>Choose Favicon</strong>
                                    <span>Square PNG image</span>
                                    <span>Maximum 1 MB</span>
                                </div>
                                <img id="faviconPreview" alt="New favicon preview" hidden>
                            </label>
                            <input type="file" name="favicon" id="websiteFaviconInput" class="visually-hidden" accept="image/png" required>
                            <small id="faviconFileName">No new image selected</small>
                        </div>
                    </div>

                    <div class="ws-browser-preview">
                        <span class="ws-preview-label">Browser Tab Preview</span>
                        <div class="ws-browser">
                            <div class="ws-browser-tabs">
                                <div class="ws-browser-tab">
                                    <img src="{{ $websiteSettings->favicon_url }}" id="browserFaviconPreview" alt="">
                                    <span id="browserNamePreview">{{ $websiteSettings->website_name }}</span>
                                    <i class="bi bi-x"></i>
                                </div>
                                <i class="bi bi-plus-lg ws-browser-plus"></i>
                            </div>
                            <div class="ws-browser-toolbar">
                                <i class="bi bi-arrow-left"></i>
                                <i class="bi bi-arrow-right"></i>
                                <i class="bi bi-arrow-clockwise"></i>
                                <div class="ws-browser-address">
                                    <i class="bi bi-globe2"></i>
                                    <span>{{ url('/') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ws-tip">
                        <i class="bi bi-info-circle"></i>
                        <span>Recommended size: 32 × 32 or 64 × 64 pixels. A simple square icon works best.</span>
                    </div>
                </div>
            </form>

            <div class="ws-card-footer">
                <form method="post" action="{{ url('/superadmin/websiteSettings/reset/favicon') }}" onsubmit="return confirm('Restore the default favicon?');">
                    @csrf
                    <button type="submit" class="ws-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Reset Favicon</button>
                </form>
                <button type="submit" form="websiteFaviconForm" id="saveFaviconButton" class="ws-save-btn" disabled><i class="bi bi-check2"></i> Save Favicon</button>
            </div>
        </section>

        {{-- Global Sync Information --}}
        <section class="ws-card">
            <div class="ws-card-header">
                <div class="ws-section-icon"><i class="bi bi-diagram-3"></i></div>
                <div>
                    <h2>Global Branding</h2>
                    <p>Website branding is shared across the following interfaces.</p>
                </div>
            </div>

            <div class="ws-card-body">
                <div class="ws-role-grid">
                    @foreach([
                        ['Visitor', 'bi-globe2'],
                        ['Customer', 'bi-person'],
                        ['Superadmin', 'bi-shield-check'],
                        ['Staff', 'bi-person-badge'],
                        ['Technician', 'bi-tools'],
                        ['Login & Register', 'bi-box-arrow-in-right']
                    ] as $role)
                        <div class="ws-role-item">
                            <i class="bi {{ $role[1] }}"></i>
                            <strong>{{ $role[0] }}</strong>
                        </div>
                    @endforeach
                </div>

                <div class="ws-last-updated">
                    <i class="bi bi-clock-history"></i>
                    Last updated: {{ $websiteSettings->updated_at ? $websiteSettings->updated_at->format('d M Y, h:i A') : 'Not updated yet' }}
                </div>
            </div>
        </section>
        @elseif($activeTab === 'footer')
            @include('superadmin.websiteSettingsPage.footerSettings')
        @elseif($activeTab === 'contact')
            @include('superadmin.websiteSettingsPage.contactSettings')
        @endif
    </main>
</div>

@if($activeTab === 'branding')
    <script>
        function setupImagePreview(inputId, previewId, placeholderId, fileNameId, buttonId, maxSize, allowedTypes, squareOnly = false) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const fileName = document.getElementById(fileNameId);
            const button = document.getElementById(buttonId);
            const browserIcon = document.getElementById('browserFaviconPreview');
            const originalFavicon = browserIcon.src;
            let previewUrl = null;

            input.addEventListener('change', function() {
                if(previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                }

                preview.hidden = true;
                preview.removeAttribute('src');
                placeholder.hidden = false;
                button.disabled = true;
                fileName.textContent = 'No new image selected';

                if(squareOnly) {
                    browserIcon.src = originalFavicon;
                }

                const file = this.files[0];

                if(!file) return;

                if(!allowedTypes.includes(file.type)) {
                    alert('Invalid image format.');
                    this.value = '';
                    return;
                }

                if(file.size > maxSize) {
                    alert('The selected image exceeds the maximum file size.');
                    this.value = '';
                    return;
                }

                const imageUrl = URL.createObjectURL(file);
                previewUrl = imageUrl;
                const image = new Image();

                image.onload = function() {
                    if(previewUrl !== imageUrl) return;

                    if(squareOnly && (image.width !== image.height || image.width < 16 || image.width > 512)) {
                        alert('Please select a square PNG image between 16 and 512 pixels.');
                        input.value = '';
                        URL.revokeObjectURL(imageUrl);
                        previewUrl = null;
                        return;
                    }

                    if(!squareOnly && (image.width > 4096 || image.height > 4096)) {
                        alert('Logo dimensions must not exceed 4096 x 4096 pixels.');
                        input.value = '';
                        URL.revokeObjectURL(imageUrl);
                        previewUrl = null;
                        return;
                    }

                    preview.src = imageUrl;
                    preview.hidden = false;
                    placeholder.hidden = true;
                    fileName.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
                    button.disabled = false;

                    if(squareOnly) {
                        browserIcon.src = imageUrl;
                    }
                };

                image.onerror = function() {
                    if(previewUrl !== imageUrl) return;

                    alert('Unable to preview this image.');
                    input.value = '';
                    URL.revokeObjectURL(imageUrl);
                    previewUrl = null;
                };

                image.src = imageUrl;
            });
        }

        setupImagePreview(
            'websiteLogoInput', 'logoPreview', 'logoPlaceholder',
            'logoFileName', 'saveLogoButton', 2 * 1024 * 1024,
            ['image/png', 'image/jpeg', 'image/webp']
        );

        setupImagePreview(
            'websiteFaviconInput', 'faviconPreview', 'faviconPlaceholder',
            'faviconFileName', 'saveFaviconButton', 1024 * 1024,
            ['image/png'], true
        );

        document.getElementById('websiteName').addEventListener('input', function() {
            document.getElementById('browserNamePreview').textContent = this.value.trim() || 'Website Name';
        });
    </script>
@endif
</body>
</html>