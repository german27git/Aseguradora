<x-filament::page>
    <div class="space-y-6">

        {{-- Encabezado del cliente --}}
        <div class="filament-card p-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $record->nombre }} {{ $record->apellido }}
            </h2>
            <p class="text-gray-700 mt-2">
                CUIT: {{ $record->cuit }} <br>
                Teléfono: {{ $record->telefono }} <br>
                Email: {{ $record->email }}
            </p>
        </div>

        {{-- Tabla de pólizas --}}
        <div class="filament-card p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Pólizas del Cliente</h3>

            @if ($record->polizas->isEmpty())
                <p class="text-gray-500">Este cliente no tiene pólizas registradas.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-medium tracking-wider">
                            <tr>
                                <th class="p-2">ID</th>
                                <th class="p-2">Poliza</th>
                                <th class="p-2">Compañía</th>
                                <th class="p-2">Bien Asegurado</th>
                                <th class="p-2">Patente</th>
                                <th class="p-2">Tipo de Cobertura</th>
                                <th class="p-2">Fecha Inicio</th>
                                <th class="p-2">Fecha Fin</th>
                                
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($record->polizas as $poliza)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2">{{ $poliza->id_poliza }}</td>
                                    <td class="p-2">{{ $poliza->numero_poliza }}</td>
                                    <td class="p-2">{{ $poliza->compania->nombre_compania ?? '-' }}</td>
                                    <td class="p-2">{{ $poliza->bienAsegurado->descripcion ?? '-' }}</td>
                                    <td class="p-2">{{ $poliza->bienAsegurado->patente ?? '-' }}</td>
                                    <td class="p-2">{{ $poliza->tipoCobertura->nombre ?? '-' }}</td>
                                    <td class="p-2">{{ $poliza->fecha_inicio ?? '-' }}</td>
                                    <td class="p-2">{{ $poliza->fecha_fin ?? '-' }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-filament::page>
