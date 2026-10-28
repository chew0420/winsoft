<style>
    .section-editor-form {
        padding: 4px;
    }

    .section-editor-header {
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-editor-header h6 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
    }

    .section-editor-header p {
        margin: 5px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .editor-field {
        margin-bottom: 18px;
    }

    .editor-field label {
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        margin-bottom: 7px;
    }

    .editor-field .form-control,
    .editor-field .form-select {
        border-radius: 8px;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
    }

    .editor-field .form-control:focus,
    .editor-field .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.10);
    }

    .editor-help {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #6b7280;
    }

    .editor-code {
        font-family: Consolas, Monaco, monospace;
        font-size: 13px;
        min-height: 220px;
        resize: vertical;
        background: #111827;
        color: #f9fafb;
        border: 1px solid #374151;
    }

    .editor-code:focus {
        background: #111827;
        color: #f9fafb;
    }

    .editor-actions {
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;

        display: flex;
        justify-content: flex-end;
    }

    .save-section-btn {
        min-width: 140px;
        border-radius: 8px;
        font-weight: 600;
    }

    .featured-product-select {
        min-height: 180px;
    }
</style>

@if($section->section_type == 'hero')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">
        <h6>
            <i class="bi bi-image me-1"></i>
            Hero Banner Settings
        </h6>

        <p>
            Edit the hero title, subtitle, background image and button.
        </p>
    </div>


    <div class="editor-field">
        <label class="form-label">
            Title
        </label>

        <input
            type="text"
            name="content[title]"
            value="{{ $section->content['title'] ?? '' }}"
            class="form-control"
            placeholder="Enter hero title"
        >
    </div>


    <div class="editor-field">
        <label class="form-label">
            Subtitle
        </label>

        <input
            type="text"
            name="content[subtitle]"
            value="{{ $section->content['subtitle'] ?? '' }}"
            class="form-control"
            placeholder="Enter hero subtitle"
        >
    </div>


    <div class="editor-field">
        <label class="form-label">
            Background Image
        </label>

        @if(!empty($section->content['image']))
            <div class="mb-3">
                <img
                    src="{{ asset($section->content['image']) }}"
                    id="heroImagePreview"
                    class="img-fluid rounded border"
                    style="max-height: 180px;"
                    alt="Hero Image"
                >
            </div>
        @else
            <div class="mb-3">
                <img
                    id="heroImagePreview"
                    class="img-fluid rounded border d-none"
                    style="max-height: 180px;"
                    alt="Hero Image Preview"
                >
            </div>
        @endif

        <input
            type="file"
            name="image"
            id="heroImageInput"
            class="form-control"
            accept="image/png,image/jpeg,image/jpg,image/webp"
        >

        <small class="editor-help">
            Leave empty to keep the current image. Maximum recommended size: 2MB.
        </small>

    </div>


    <div class="editor-field">
        <label class="form-label">
            Button Text
        </label>

        <input
            type="text"
            name="content[button_text]"
            value="{{ $section->content['button_text'] ?? 'Shop Now' }}"
            class="form-control"
            placeholder="Example: Shop Now"
        >
    </div>


    <div class="editor-field">
        <label class="form-label">
            Button URL
        </label>

        <input
            type="text"
            name="content[button_url]"
            value="{{ $section->content['button_url'] ?? '/shop' }}"
            class="form-control"
            placeholder="Example: /shop"
        >

        <small class="editor-help">
            Example: /shop
        </small>
    </div>


    <div class="editor-field">
        <label class="form-label">
            Section Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
            placeholder="Internal section title"
        >
    </div>


    <div class="editor-actions">
        <button
            type="submit"
            class="btn btn-primary save-section-btn"
        >
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>
    </div>

</form>

@elseif($section->section_type == 'products')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">
        <h6>
            <i class="bi bi-grid me-1"></i>
            Products Grid Settings
        </h6>
        <p>Control how many products are displayed in this section.</p>
    </div>

    <div class="editor-field">
        <label class="form-label">
            Number of Products to Show
        </label>

        <input
            type="number"
            name="content[limit]"
            value="{{ $section->content['limit'] ?? 8 }}"
            class="form-control"
            min="1"
            max="50"
        >

        <small class="editor-help">
            Recommended: 4 to 8 products.
        </small>
    </div>

    <div class="editor-field">
        <label class="form-label">Section Title</label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
            placeholder="Example: Latest Products"
        >
    </div>

    <div class="editor-actions">
        <button type="submit" class="btn btn-primary save-section-btn">
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>
    </div>

</form>

@elseif($section->section_type == 'categories')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">

        <h6>
            <i class="bi bi-tags me-1"></i>
            Categories Settings
        </h6>

        <p>
            Configure how the product categories section appears.
        </p>

    </div>

    <div class="editor-field">

        <label class="form-label">
            Section Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
            placeholder="Example: Shop by Category"
        >

        <small class="editor-help">
            Categories are loaded automatically from the category database.
        </small>

    </div>


    <div class="editor-field">

        <label class="form-label">
            Number of Categories
        </label>

        <input
            type="number"
            name="content[limit]"
            value="{{ $section->content['limit'] ?? 6 }}"
            class="form-control"
            min="1"
            max="20"
        >

        <small class="editor-help">
            Controls the maximum number of categories shown.
        </small>

    </div>


    <div class="editor-actions">

        <button
            type="submit"
            class="btn btn-primary save-section-btn"
        >
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>

    </div>

</form>

@elseif($section->section_type == 'banner')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">

        <h6>
            <i class="bi bi-card-image me-1"></i>
            Banner Settings
        </h6>

        <p>
            Configure the banner image, link and alternative text.
        </p>

    </div>


    <div class="editor-field">
        <label class="form-label">
            Banner Image
        </label>

        @if(!empty($section->content['image']))
            <div class="mb-3">
                <img
                    src="{{ asset($section->content['image']) }}"
                    id="bannerImagePreview"
                    class="img-fluid rounded border"
                    style="max-height: 180px;"
                    alt="Banner Image"
                >
            </div>
        @else
            <div class="mb-3">
                <img
                    id="bannerImagePreview"
                    class="img-fluid rounded border d-none"
                    style="max-height: 180px;"
                    alt="Banner Preview"
                >
            </div>
        @endif

        <input
            type="file"
            name="image"
            id="bannerImageInput"
            class="form-control"
            accept="image/png,image/jpeg,image/jpg,image/webp"
        >

        <small class="editor-help">
            Leave empty to keep the current banner image.
        </small>

    </div>


    <div class="editor-field">

        <label class="form-label">
            Banner Link
        </label>

        <input
            type="text"
            name="content[link]"
            value="{{ $section->content['link'] ?? '#' }}"
            class="form-control"
            placeholder="Example: /shop"
        >

    </div>


    <div class="editor-field">

        <label class="form-label">
            Alt Text
        </label>

        <input
            type="text"
            name="content[alt]"
            value="{{ $section->content['alt'] ?? 'Banner' }}"
            class="form-control"
            placeholder="Describe the banner image"
        >

        <small class="editor-help">
            Helps accessibility and describes the image.
        </small>

    </div>


    <div class="editor-actions">

        <button
            type="submit"
            class="btn btn-primary save-section-btn"
        >
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>

    </div>

</form>

@elseif($section->section_type == 'custom_html')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">
        <h6>
            <i class="bi bi-code-slash me-1"></i>
            Custom HTML Settings
        </h6>

        <p>
            Add custom HTML content for this section.
        </p>
    </div>

    <div class="editor-field">
        <label class="form-label">
            Custom HTML Content
        </label>

        <textarea
            name="content[html]"
            class="form-control editor-code"
            rows="12"
            spellcheck="false"
        >{{ $section->content['html'] ?? '' }}</textarea>

        <small class="editor-help">
            HTML, CSS and JavaScript can be entered here.
        </small>
    </div>

    <div class="editor-field">
        <label class="form-label">Section Title</label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
            placeholder="Internal section title"
        >
    </div>

    <div class="editor-actions">
        <button type="submit" class="btn btn-primary save-section-btn">
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>
    </div>

</form>

@elseif($section->section_type == 'featured')
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">
        <h6>
            <i class="bi bi-star me-1"></i>
            Featured Products Settings
        </h6>

        <p>
            Select the products that should appear in this section.
        </p>
    </div>

    <div class="editor-field">
        <label class="form-label">Section Title</label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
            placeholder="Example: Featured Products"
        >
    </div>

    <div class="editor-field">

        <label class="form-label">
            Select Featured Products
        </label>

        <select
            name="content[product_ids][]"
            class="form-select featured-product-select"
            multiple
        >

            @foreach(
                \App\Models\tbl_product::where('status', 'active')->get()
                as $product
            )

                <option
                    value="{{ $product->product_id }}"

                    {{ in_array(
                        $product->product_id,
                        $section->content['product_ids'] ?? []
                    ) ? 'selected' : '' }}
                >

                    {{ $product->name }}
                    -
                    RM {{ number_format($product->price, 2) }}

                </option>

            @endforeach

        </select>

        <small class="editor-help">
            Hold Ctrl on Windows or Cmd on Mac to select multiple products.
        </small>

    </div>

    <div class="editor-actions">
        <button type="submit" class="btn btn-primary save-section-btn">
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>
    </div>

</form>

@else
<form id="sectionForm" class="section-editor-form">
    @csrf

    <div class="section-editor-header">

        <h6>
            <i class="bi bi-layout-text-window me-1"></i>
            Section Settings
        </h6>

        <p>Edit the general section information.</p>

    </div>

    <div class="editor-field">

        <label class="form-label">
            Section Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ $section->title }}"
            class="form-control"
        >

    </div>

    <div class="editor-actions">

        <button
            type="submit"
            class="btn btn-primary save-section-btn"
        >
            <i class="bi bi-save me-1"></i>
            Save Section
        </button>

    </div>

</form>

@endif

<script>
$(document).ready(function() {
    $('#sectionForm').on('submit', function(e) {
        e.preventDefault();

        var formData =
            new FormData(this);

        formData.append(
            '_token',
            '{{ csrf_token() }}'
        );

        $.ajax({

            url: '/superadmin/section/{{ $section->section_id }}/update',

            method: 'POST',

            data: formData,

            processData: false,

            contentType: false,

            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            },

            error: function(xhr) {

                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);

                if(
                    xhr.responseJSON &&
                    xhr.responseJSON.errors
                ) {

                    var message = '';

                    Object.values(
                        xhr.responseJSON.errors
                    ).forEach(function(errors) {

                        message +=
                            errors[0] + '\n';

                    });

                    alert(message);

                } else {

                    alert(
                        'Error updating section. Status: '
                        + xhr.status
                    );

                }

            }

        });

    });
});

function previewSelectedImage(input, previewId) {

    if (
        input.files &&
        input.files[0]
    ) {

        var file = input.files[0];

        if (file.size > 2 * 1024 * 1024) {

            alert('Image size must not exceed 2MB.');

            input.value = '';

            return;
        }

        var reader = new FileReader();

        reader.onload = function(e) {

            $(previewId)
                .attr('src', e.target.result)
                .removeClass('d-none');

        };

        reader.readAsDataURL(file);

    }

}


$('#heroImageInput').on('change', function() {

    previewSelectedImage(
        this,
        '#heroImagePreview'
    );

});


$('#bannerImageInput').on('change', function() {

    previewSelectedImage(
        this,
        '#bannerImagePreview'
    );

});
</script>