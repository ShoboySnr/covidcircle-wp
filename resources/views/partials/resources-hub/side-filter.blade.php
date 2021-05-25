<div class="side-filter">
  <div class="flex xl:hidden toggle-category justify-between items-center w-full">
    <p>Categories</p>
    <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M18.5059 2L10.5518 10L1.98583 2" stroke="black" stroke-width="3"/>
    </svg>
  </div>
  <div class="hidden xl:flex flex-col justify-start category-show">
    @foreach($categories as $category)
      <label class="checkbox-group" for="{{ $category['slug'] }}">
        <span class="checkbox-name" for="{{ $category['slug'] }}">{{ $category['name'] }}</span>
        <input type="checkbox" value="{{ $category['slug'] }}" name="{{ $category['category'] }}" id="{{ $category['slug'] }}" @if(in_array($category['slug'], $resources_categories)) checked @endif onClick="this.checked=!this.checked;" />
        <span class="checkmark"></span>
      </label>
    @endforeach
  </div>
</div>
