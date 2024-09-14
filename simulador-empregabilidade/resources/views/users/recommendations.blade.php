@foreach ($recommendations as $rec)
    <div class="recommendation">
        <h2>{{ $rec['name'] }}</h2>
        <p>Posição: {{ $rec['job_title'] }}</p>
        <p>Habilidade: {{ $rec['skill'] }}</p>
    </div>
@endforeach
