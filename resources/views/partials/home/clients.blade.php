@if(isset($clients))
<section id="clients">
  <div class="container">
    <div class="title text-center w-full">
      <h2>Funded By:</h2>
    </div>
    <div class="content">
      <div class="client-container flex justify-center items-center w-full">
        @foreach($clients as $client)
          @if(!empty($client['link']))
            <a href="{{ $client['link'] }}" target="_blank" class="client-padding">
              <img src="{{ $client['image'] }}" title="{{ $client['title'] }}" alt="{{ $client['title'] }}" />
            </a>
          @else
            <img src="{{ $client['image'] }}" class="client-padding" title="{{ $client['title'] }}" alt="{{ $client['title'] }}" />
          @endif
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif
