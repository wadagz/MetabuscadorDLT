<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoVialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_vialidad')->insert([
            [ 'abreviatura' => 'AMP.', 'descripcion' => 'Ampliación' ],
            [ 'abreviatura' => 'DIAG.', 'descripcion' => 'Diagonal' ],
            [ 'abreviatura' => 'AND.', 'descripcion' => 'Andador' ],
            [ 'abreviatura' => 'GTA.', 'descripcion' => 'Glorieta' ],
            [ 'abreviatura' => 'AUT.', 'descripcion' => 'Autopista' ],
            [ 'abreviatura' => 'JDN.', 'descripcion' => 'Jardín' ],
            [ 'abreviatura' => 'AV.', 'descripcion' => 'Avenida' ],
            [ 'abreviatura' => 'LIB.', 'descripcion' => 'Libramiento' ],
            [ 'abreviatura' => 'BJD.', 'descripcion' => 'Bajada' ],
            [ 'abreviatura' => 'PRJ.', 'descripcion' => 'Paraje' ],
            [ 'abreviatura' => 'BLV.', 'descripcion' => 'Boulevard' ],
            [ 'abreviatura' => 'PSJ.', 'descripcion' => 'Pasaje' ],
            [ 'abreviatura' => 'CALZ.', 'descripcion' => 'Calzada' ],
            [ 'abreviatura' => 'PSO.', 'descripcion' => 'Paseo' ],
            [ 'abreviatura' => 'C.', 'descripcion' => 'Calle' ],
            [ 'abreviatura' => 'PERIF.', 'descripcion' => 'Periférico' ],
            [ 'abreviatura' => 'CJON.', 'descripcion' => 'Callejón' ],
            [ 'abreviatura' => 'PZA.', 'descripcion' => 'Plaza' ],
            [ 'abreviatura' => 'CAM.', 'descripcion' => 'Camino' ],
            [ 'abreviatura' => 'PZLA.', 'descripcion' => 'Plazuela' ],
            [ 'abreviatura' => 'CARR.', 'descripcion' => 'Carretera' ],
            [ 'abreviatura' => 'PRIV.', 'descripcion' => 'Privada' ],
            [ 'abreviatura' => 'CDA.', 'descripcion' => 'Cerrada' ],
            [ 'abreviatura' => 'PROL.', 'descripcion' => 'Prolongación' ],
            [ 'abreviatura' => 'CTO.', 'descripcion' => 'Circuito' ],
            [ 'abreviatura' => 'RML.', 'descripcion' => 'Ramal' ],
            [ 'abreviatura' => 'CVLN.', 'descripcion' => 'Circunvalación' ],
            [ 'abreviatura' => 'RET.', 'descripcion' => 'Retorno' ],
            [ 'abreviatura' => 'CRO.', 'descripcion' => 'Crucero' ],
            [ 'abreviatura' => 'RCDA.', 'descripcion' => 'Rinconada' ],
            [ 'abreviatura' => 'CUCH.', 'descripcion' => 'Cuchilla' ],
            [ 'abreviatura' => 'VDA.', 'descripcion' => 'Vereda' ],
            [ 'abreviatura' => 'VDTO.', 'descripcion' => 'Viaducto' ],
        ]);
    }
}
