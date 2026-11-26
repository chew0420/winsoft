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
@php
    $visitorCount = $pages->filter(fn($page) => str_contains(strtolower($page->page_name), 'visitor'))->count();
    $customerCount = $pages->filter(fn($page) => str_contains(strtolower($page->page_name), 'customer'))->count();
    $otherCount = $pages->count() - $visitorCount - $customerCount;

    $pageBuilderPages = ['Visitor Home Page', 'Customer Home Page'];
@endphp
<div class="d-flex">
    <main class="main-content pl-page">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="pl-breadcrumb">
            <a href="{{ url('/superadminHomePage') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <span>Website Management</span>
            <i class="bi bi-chevron-right"></i>
            <span>Website Pages</span>
        </div>

        <section class="pl-banner">
            <div class="pl-banner-content">
                <span>WEBSITE MANAGEMENT</span>
                <h1>Website Pages</h1>
                <p>Manage and customize your website pages, content and layout from one place.</p>
            </div>
            <div class="pl-banner-icon"><i class="bi bi-window-stack"></i></div>
        </section>

        <div class="pl-stats-grid">
            <div class="pl-stat-card">
                <div class="pl-stat-icon pl-icon-dark"><i class="bi bi-files"></i></div>
                <div>
                    <span>Total Pages</span>
                    <h3>{{ $pages->count() }}</h3>
                </div>
            </div>
            <div class="pl-stat-card">
                <div class="pl-stat-icon pl-icon-blue"><i class="bi bi-globe2"></i></div>
                <div>
                    <span>Visitor Pages</span>
                    <h3>{{ $visitorCount }}</h3>
                </div>
            </div>
            <div class="pl-stat-card">
                <div class="pl-stat-icon pl-icon-purple"><i class="bi bi-people"></i></div>
                <div>
                    <span>Customer Pages</span>
                    <h3>{{ $customerCount }}</h3>
                </div>
            </div>
        </div>

        <section class="pl-workspace">
            <div class="pl-workspace-header">
                <div>
                    <h2>Manage Pages</h2>
                    <p>Select a page to edit its layout and content.</p>
                </div>
                <div class="pl-search">
                    <i class="bi bi-search"></i>
                    <input type="search" id="pageSearch" placeholder="Search pages..." aria-label="Search pages">
                </div>
            </div>

            <div class="pl-tabs">
                <button type="button" class="pl-tab active" data-filter="all">All Pages <span>{{ $pages->count() }}</span></button>
                <button type="button" class="pl-tab" data-filter="visitor">Visitor <span>{{ $visitorCount }}</span></button>
                <button type="button" class="pl-tab" data-filter="customer">Customer <span>{{ $customerCount }}</span></button>
                @if($otherCount > 0)
                    <button type="button" class="pl-tab" data-filter="other">Other <span>{{ $otherCount }}</span></button>
                @endif
            </div>

            <div class="pl-result-bar">
                Showing <strong id="visiblePageCount">{{ $pages->count() }}</strong> of {{ $pages->count() }} pages
            </div>

            <div class="pl-pages-grid">
                @forelse($pages as $page)
                    @php
                        $pageName = strtolower($page->page_name);

                        if(str_contains($pageName, 'visitor')) {
                            $pageType = 'visitor';
                            $typeLabel = 'Visitor';
                            $typeDescription = 'Public website page';
                        } elseif(str_contains($pageName, 'customer')) {
                            $pageType = 'customer';
                            $typeLabel = 'Customer';
                            $typeDescription = 'Signed-in customer page';
                        } else {
                            $pageType = 'other';
                            $typeLabel = 'Other';
                            $typeDescription = 'Website content page';
                        }

                        $pageIcon = 'bi-file-earmark-text';
                        $description = 'Manage and update the content of this website page.';

                        if(str_contains($pageName, 'home')) {
                            $pageIcon = 'bi-house-door';
                            $description = 'Customize homepage banners, featured content and layout sections.';
                        } elseif(str_contains($pageName, 'contact')) {
                            $pageIcon = 'bi-envelope';
                            $description = 'Edit contact information and customer enquiry content.';
                        } elseif(str_contains($pageName, 'location') || str_contains($pageName, 'store')) {
                            $pageIcon = 'bi-geo-alt';
                            $description = 'Edit store location information and page content.';
                        } elseif(str_contains($pageName, 'shop') || str_contains($pageName, 'product')) {
                            $pageIcon = 'bi-bag';
                            $description = 'Customize product and shopping page content.';
                        } elseif(str_contains($pageName, 'service')) {
                            $pageIcon = 'bi-tools';
                            $description = 'Manage repair service and technical support content.';
                        } elseif(str_contains($pageName, 'about')) {
                            $pageIcon = 'bi-info-circle';
                            $description = 'Update company information and business introduction.';
                        }

                        $isPageBuilder = in_array($page->page_name, $pageBuilderPages, true);
                        $editorUrl = $isPageBuilder ? '/superadmin/pageBuilder/'.$page->page_id : '/superadmin/webEditor/'.$page->page_id;
                    @endphp

                    <article class="pl-page-card" data-type="{{ $pageType }}">
                        <div class="pl-card-header">
                            <div class="pl-page-icon pl-type-{{ $pageType }}"><i class="bi {{ $pageIcon }}"></i></div>
                            <span class="pl-type-label pl-type-{{ $pageType }}">{{ $typeLabel }}</span>
                        </div>
                        <div class="pl-card-body">
                            <span class="pl-page-id">PAGE #{{ $page->page_id }}</span>
                            <h3>{{ $page->page_name }}</h3>
                            <span class="pl-page-category">{{ $typeDescription }}</span>
                            <p>{{ $description }}</p>
                        </div>
                        <div class="pl-card-footer">
                            <div class="pl-editor-info">
                                @if($isPageBuilder)
                                    <i class="bi bi-layout-text-window-reverse"></i>
                                    <span>Page Builder</span>
                                @else
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Web Editor</span>
                                @endif
                            </div>
                            <a href="{{ url($editorUrl) }}" class="pl-edit-btn">Edit Page <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </article>
                @empty
                    <div class="pl-empty">
                        <i class="bi bi-folder2-open"></i>
                        <h3>No website pages found</h3>
                        <p>Website pages will appear here when available.</p>
                    </div>
                @endforelse
            </div>

            <div id="plNoResults" class="pl-empty" style="display: none;">
                <i class="bi bi-search"></i>
                <h3>No matching pages</h3>
                <p>Try searching with another keyword or changing the filter.</p>
                <button type="button" class="pl-reset-btn" id="plResetFilters">Clear Filters</button>
            </div>
        </section>

        <div class="pl-editor-guide">
            <div class="pl-guide-icon"><i class="bi bi-info-circle"></i></div>
            <div class="pl-guide-content">
                <h3>About Website Editors</h3>
                <div class="pl-guide-grid">
                    <div>
                        <strong><i class="bi bi-layout-text-window-reverse"></i> Page Builder</strong>
                        <p>Manage homepage sections, banners, featured products and custom layouts.</p>
                    </div>
                    <div>
                        <strong><i class="bi bi-pencil-square"></i> Web Editor</strong>
                        <p>Edit existing website content through the visual editor.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    const pageSearch = document.getElementById('pageSearch');
    const pageCards = document.querySelectorAll('.pl-page-card');
    const pageTabs = document.querySelectorAll('.pl-tab');
    let pageFilter = 'all';

    function filterPages() {
        const keyword = pageSearch.value.toLowerCase().trim();
        let visibleCount = 0;

        pageCards.forEach(card => {
            const matchType = pageFilter === 'all' || card.dataset.type === pageFilter;
            const matchSearch = card.textContent.toLowerCase().includes(keyword);
            const visible = matchType && matchSearch;
            card.style.display = visible ? '' : 'none';

            if(visible) visibleCount++;
        });

        document.getElementById('visiblePageCount').textContent = visibleCount;
        document.getElementById('plNoResults').style.display = pageCards.length > 0 && visibleCount === 0 ? 'block' : 'none';
    }

    pageTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            pageTabs.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
            pageFilter = this.dataset.filter;
            filterPages();
        });
    });

    pageSearch.addEventListener('input', filterPages);

    document.getElementById('plResetFilters').addEventListener('click', function() {
        pageSearch.value = '';
        pageFilter = 'all';
        pageTabs.forEach(tab => tab.classList.toggle('active', tab.dataset.filter === 'all'));
        filterPages();
    });
</script>
</body>
</html>