<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Enums\EstadoEnum;
use App\Enums\MunicipioEnum;
use App\Enums\TipoAsentamientoEnum;
use App\Enums\TipoVialidadEnum;
use App\Enums\TipoHospedajeEnum;
use App\Enums\TipoActividadEnum;
use App\Helpers\EnumHelper;

class EnumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share enums with all views
        $this->shareEnumsWithViews();

        // Register Blade directives
        $this->registerBladeDirectives();
    }

    /**
     * Share enums with all views.
     */
    private function shareEnumsWithViews(): void
    {
        view()->share('estados', EnumHelper::enumToSelectArray(EstadoEnum::class));
        view()->share('municipios', EnumHelper::enumToSelectArray(MunicipioEnum::class));
        view()->share('tiposAsentamiento', EnumHelper::enumToSelectArray(TipoAsentamientoEnum::class));
        view()->share('tiposVialidad', EnumHelper::enumToSelectArray(TipoVialidadEnum::class));
        view()->share('tiposHospedaje', EnumHelper::enumToSelectArray(TipoHospedajeEnum::class));
        view()->share('tiposActividad', EnumHelper::enumToSelectArray(TipoActividadEnum::class));
    }

    /**
     * Register Blade directives.
     */
    private function registerBladeDirectives(): void
    {
        // Directive to get enum label from value
        Blade::directive('enumLabel', function ($expression) {
            return "<?php echo App\\Helpers\\EnumHelper::getEnumLabelFromValue($expression); ?>";
        });

        // Directive to get municipalities for a state
        Blade::directive('municipiosForEstado', function ($expression) {
            return "<?php echo json_encode(App\\Enums\\MunicipioEnum::forEstado($expression)); ?>";
        });
    }
} 