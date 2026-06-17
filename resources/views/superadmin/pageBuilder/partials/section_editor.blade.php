@if($section->section_type == 'hero')
    <form id="sectionForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="content[title]" value="{{ $section->content['title'] ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="content[subtitle]" value="{{ $section->content['subtitle'] ?? '' }}" class="form-control">
        </div>
        <!-- <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" name="content[image]" value="{{ $section->content['image'] ?? '' }}" class="form-control">
            <small class="text-muted">Path: img/banner.jpg</small>
        </div> -->
        <div class="mb-3">
            <label class="form-label">Button Text</label>
            <input type="text" name="content[button_text]" value="{{ $section->content['button_text'] ?? '' }}" class="form-control">
        </div>
        <!-- <div class="mb-3">
            <label class="form-label">Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $section->content['button_url'] ?? '' }}" class="form-control">
        </div> -->
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>

@elseif($section->section_type == 'products')
    <form id="sectionForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Number of Products to Show</label>
            <input type="number" name="content[limit]" value="{{ $section->content['limit'] ?? 4 }}" class="form-control" min="1" max="50">
        </div>
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>

@elseif($section->section_type == 'banner')
    <form id="sectionForm">
        @csrf
        <!-- <div class="mb-3">
            <label class="form-label">Banner Image URL</label>
            <input type="text" name="content[image]" value="{{ $section->content['image'] ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Link URL</label>
            <input type="text" name="content[link]" value="{{ $section->content['link'] ?? '#' }}" class="form-control">
        </div> -->
        <div class="mb-3">
            <label class="form-label">Alt Text</label>
            <input type="text" name="content[alt]" value="{{ $section->content['alt'] ?? '' }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>

@elseif($section->section_type == 'custom_html')
    <form id="sectionForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Custom HTML Content</label>
            <textarea name="content[html]" rows="10" class="form-control">{{ $section->content['html'] ?? '' }}</textarea>
            <small class="text-muted">You can add any HTML, CSS, or JavaScript here</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>

@elseif($section->section_type == 'featured')
    <form id="sectionForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Select Featured Products</label>
            <select name="content[product_ids][]" class="form-select" multiple size="5">
                @foreach(\App\Models\tbl_product::where('status', 'active')->get() as $product)
                    <option value="{{ $product->product_id }}" 
                        {{ in_array($product->product_id, $section->content['product_ids'] ?? []) ? 'selected' : '' }}>
                        {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>

@else
    <form id="sectionForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </form>
@endif

<script>
$(document).ready(function() {
    $('#sectionForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/superadmin/section/{{ $section->section_id }}/update',
            method: 'POST',
            data: formData + '&_token={{ csrf_token() }}',
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            },
            error: function() {
                alert('Error updating section');
            }
        });
    });
});
</script>