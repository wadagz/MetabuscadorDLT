# Enums Usage Guide

This directory contains PHP backed enums that replace the lookup tables in the database. This simplifies the database structure and makes it easier to work with these values in the code.

## Available Enums

- `EstadoEnum`: Replaces the `estados` table
- `MunicipioEnum`: Replaces the `municipios` table
- `TipoAsentamientoEnum`: Replaces the `tipos_asentamiento` table
- `TipoVialidadEnum`: Replaces the `tipos_vialidad` table
- `TipoHospedajeEnum`: Replaces the `tipo_hospedajes` table
- `TipoActividadEnum`: Replaces the `tipos_actividad` table

## How to Use Enums in Your Code

### In PHP Code

```php
use App\Enums\EstadoEnum;
use App\Enums\MunicipioEnum;
use App\Enums\TipoAsentamientoEnum;
use App\Enums\TipoVialidadEnum;
use App\Enums\TipoHospedajeEnum;
use App\Enums\TipoActividadEnum;

// Get a specific enum case
$estado = EstadoEnum::JALISCO;

// Get the name or description
$nombreEstado = $estado->nombre(); // Returns "Jalisco"
$abreviaturaEstado = $estado->abreviatura(); // Returns "JAL"

// Check if a value matches an enum case
if ($estadoId === EstadoEnum::JALISCO->value) {
    // Do something
}

// Using the enum in a switch statement
switch ($tipoHospedaje) {
    case TipoHospedajeEnum::HOTEL:
        // Handle hotel
        break;
    case TipoHospedajeEnum::HOSTAL:
        // Handle hostal
        break;
    // ...
}

// Convert from a value to an enum case
$tipoAsentamiento = TipoAsentamientoEnum::tryFrom($tipoAsentamientoId);
if ($tipoAsentamiento) {
    $descripcion = $tipoAsentamiento->descripcion();
}

// Working with municipalities
$municipio = MunicipioEnum::GUADALAJARA;
$nombreMunicipio = $municipio->nombre(); // Returns "Guadalajara"
$estadoId = $municipio->estadoId(); // Returns the ID of Jalisco
$estado = $municipio->estado(); // Returns EstadoEnum::JALISCO

// Get all municipalities for a state
$municipiosJalisco = MunicipioEnum::forEstado(EstadoEnum::JALISCO);
```

### Using the EnumHelper Class

```php
use App\Helpers\EnumHelper;
use App\Enums\EstadoEnum;
use App\Enums\MunicipioEnum;

// Get an array of options for a select dropdown
$estadosOptions = EnumHelper::enumToSelectArray(EstadoEnum::class);
// Returns [['value' => 1, 'label' => 'Aguascalientes'], ...]

// Get a collection of options
$estadosCollection = EnumHelper::enumToSelectCollection(EstadoEnum::class);

// Get an enum from a value
$estado = EnumHelper::getEnumFromValue(EstadoEnum::class, 14);
// Returns EstadoEnum::JALISCO

// Get a label from a value
$nombreEstado = EnumHelper::getEnumLabelFromValue(EstadoEnum::class, 14);
// Returns "Jalisco"

// Get all municipalities
$municipiosOptions = EnumHelper::enumToSelectArray(MunicipioEnum::class);
```

### In Blade Templates

The enums are automatically shared with all views, so you can use them directly in your Blade templates:

```blade
<select name="estado_id" id="estado_id">
    @foreach($estados as $estado)
        <option value="{{ $estado['value'] }}">{{ $estado['label'] }}</option>
    @endforeach
</select>

<select name="municipio_id" id="municipio_id">
    @foreach($municipios as $municipio)
        <option value="{{ $municipio['value'] }}" data-estado-id="{{ $municipio['estado_id'] }}">
            {{ $municipio['label'] }}
        </option>
    @endforeach
</select>
```

You can also use the `@enumLabel` directive to get the label for a value:

```blade
<p>Estado: @enumLabel(App\Enums\EstadoEnum::class, $estadoId)</p>
<p>Municipio: @enumLabel(App\Enums\MunicipioEnum::class, $municipioId)</p>
```

For filtering municipalities by state in a dropdown, you can use the `@municipiosForEstado` directive:

```blade
<script>
    // Get municipalities for a specific state
    const municipiosJalisco = @municipiosForEstado(App\Enums\EstadoEnum::JALISCO);
    
    // Or dynamically based on a selected state
    document.getElementById('estado_id').addEventListener('change', function() {
        const estadoId = this.value;
        const municipioSelect = document.getElementById('municipio_id');
        
        // Clear current options
        municipioSelect.innerHTML = '';
        
        // Filter municipalities by estado_id
        const municipios = Array.from(document.querySelectorAll('#municipio_id option'))
            .filter(option => option.dataset.estadoId === estadoId);
            
        // Add filtered options
        municipios.forEach(municipio => {
            municipioSelect.appendChild(municipio.cloneNode(true));
        });
    });
</script>
```

## Database Migrations

When creating or modifying database tables, instead of creating foreign key relationships to the lookup tables, you should use enum validation in your application code:

```php
// In a form request validator
public function rules(): array
{
    return [
        'estado_id' => ['required', 'integer', Rule::in(array_column(EstadoEnum::cases(), 'value'))],
        'municipio_id' => ['required', 'integer', Rule::in(array_column(MunicipioEnum::cases(), 'value'))],
        'tipo_asentamiento_id' => ['required', 'integer', Rule::in(array_column(TipoAsentamientoEnum::cases(), 'value'))],
        // ...
    ];
}
```

## Adding New Values

To add a new value to an enum:

1. Add a new case to the enum class
2. Add the corresponding description in the `descripcion()` or `nombre()` method
3. No database migration is needed!

Example:

```php
// Adding a new tipo_hospedaje
enum TipoHospedajeEnum: int
{
    // ... existing cases
    case ECO_LODGE = 16; // Add the new case with a unique value
    
    public function descripcion(): string
    {
        return match($this) {
            // ... existing cases
            self::ECO_LODGE => 'Eco Lodge', // Add the description
        };
    }
}
``` 