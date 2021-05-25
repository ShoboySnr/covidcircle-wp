@if(!empty($clients) && isset($clients))
<section id="funded-by" class="w-screen bg-white">
  <div class="container">
    <div class="title">
      <h2>Funded By</h2>
    </div>
    <div class="content">
      <div class="items-card flex justify-center items-start flex-wrap">
        @foreach($clients as $client)
        <div class="card bg-gray-100">
          <div class="featured-image">
            <img src="{{ $client['image'] }}" title="{{ $client['title'] }}" />
          </div>
          <div class="details">
            {!! $client['content'] !!}
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif
