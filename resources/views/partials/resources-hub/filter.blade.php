<?php

?>
<div class="filter-content">
  <div class="flex justify-start xl:justify-between items-start xl:items-center flex-col xl:flex-row">
    <div class="indicate">
      <?= __('Filter Resources', 'covid-circle-wp') ?>
    </div>
    <div class="resources-filter">
      <div class="flex jusitify-start hidden xl:block flex-col xl:flex-row">
        <button type="button" value="" name="resources_types" class="@if($resources_filter == '') active @endif">All</button>
        @foreach($types as $type)
          <button type="button" class="@if($resources_filter == $type['slug']) active @endif" value="{{ $type['slug'] }}" name="{{ $type['category'] }}">{{ $type['name'] }} </button>
        @endforeach
      </div>
      <div class="block xl:hidden">
        <select class="select-control" name="resources_types" id="resources_types">
          <option value="">Resource Type</option>
          @foreach($types as $type)
            <option value="{{ $type['slug'] }}" @if($resources_filter == $type['slug']) selected @endif> {{ $type['name'] }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>
