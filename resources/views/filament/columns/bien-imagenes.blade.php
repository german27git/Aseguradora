@php
    use Illuminate\Support\Facades\Storage;
    $imagenes = $getState();

    if (is_string($imagenes)) {
        $imagenes = json_decode($imagenes, true);
    }

    if (!is_array($imagenes)) {
        $imagenes = [];
    }
@endphp

<div class="flex flex-wrap gap-2">
    @forelse ($imagenes as $imagen)
        @php
            // Si ya es una URL completa, la dejamos tal cual
            $url = str_starts_with($imagen, 'http')
                ? $imagen
                : Storage::disk('public')->url($imagen);
        @endphp

        <img src="{{ $url }}" 
             alt="Imagen del bien" 
             class="h-16 w-16 object-cover rounded-md border border-gray-300 shadow-sm">
    @empty
        <span class="text-gray-400 text-sm">Sin imágenes</span>
    @endforelse
</div>
