<section id="regions-bg" class="w-screen bg-white">
  <div class="container">
    <div class="regions-container">
      <div class="flex justify-start xl:justify-between items-start xl:items-center w-full flex-col xl:flex-row">
        <div class="tag">
          <span><?= __('Regions:', 'covid-circle-wp') ?></span>
        </div>
        <div class="filter-regions">
          <div class="block xl:hidden">
            <select class="select-control" name="post_type" id="add-regions-select">
              <option value="" selected><?= __('All Regions', 'covid-circle-wp') ?></option>
              @foreach($regions as $region)
                <option value="{{ $region['slug'] }}">{{ $region['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="hidden xl:flex justify-start items-center add-regions" id="add-regions">
            <button type="button" value="" name="regions" class="active"><?= __('All Regions', 'covid-circle-wp') ?></button>
            @foreach($regions as $region)
            <button type="button" value="{{ $region['slug'] }}" name="regions">{{ $region['name'] }}</button>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
