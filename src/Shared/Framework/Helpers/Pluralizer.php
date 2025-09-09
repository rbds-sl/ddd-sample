<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Helpers;

use function in_array;

final class Pluralizer
{
    /**
     * @var string[]
     */
    private static $irregular = [
        'oes' => 'o',
        'esprais' => 'espray',
        'noes' => 'no',
        'yoes' => 'yos',
        'volumenes' => 'volumen',
        'cracs' => 'crac',
        'albalaes' => 'albala',
        'faralaes' => 'farala',
        'clubes' => 'club',
        'paases' => 'paas',
        'jerseis' => 'jersey',
        'especamenes' => 'especimen',
        'caracteres' => 'caracter',
        'menus' => 'menu',
        'regamenes' => 'regimen',
        'curraculos' => 'curriculum',
        'ultimatos' => 'ultimatum',
        'memorandos' => 'memroandum',
        'referendos' => 'referendum',
        'canciones' => 'cancion',
        'sandwiches' => 'sandwich',
        'migrations' => 'migration',
    ];

    private static $invariable = [
        'abrelatas',
        'afrikaans',
        'afueras',
        'albricias',
        'aledaños',
        'alias',
        'alicates',
        'andurriales',
        'analisis',
        'atlas',
        'caries',
        'cascarrabias',
        'compost',
        'cortaplumas',
        'creces',
        'crisis',
        'cuelgacapas',
        'cumpleaños',
        'cuadriceps',
        'dosis',
        'dux',
        'deficit',
        'escolaridad',
        'enseres',
        'esponsales',
        'exequias',
        'fauces',
        'facciones',
        'forceps',
        'gafas',
        'gargaras',
        'guardarropas',
        'hipotesis',
        'honorarios',
        'jueves',
        'lavacoches',
        'limpiabotas',
        'lunes',
        'maitines',
        'marcapasos',
        'martes',
        'metamorfosis',
        'miercoles',
        'mondadientes',
        'modales',
        'nupcias',
        'parabrisas',
        'paracaadas',
        'paraguas',
        'pararrayos',
        'pisapapeles',
        'portaaviones',
        'portaequipajes',
        'quitamanchas',
        'rascacielos',
        'rompeolas',
        'sacacorchos',
        'salvavidas',
        'salvavidas',
        'saltamontes',
        'sms',
        'santesis',
        'tesis',
        'test',
        'tenazas',
        'tijeras',
        'triceps',
        'trust',
        'vacaciones',
        'valses',
        'vaveres',
        'viacrucis',
        'viernes',
        'virus',
        'viveres',
        'extasis',
    ];

    private static $noPlural = [
        'adolescencia',
        'azucar',
        'calor',
        'cafe',
        'canal',
        'caos',
        'cariz',
        'carne',
        'decrepitud',
        'descanso',
        'el',
        'el',
        'ella',
        'ellas',
        'ellos',
        'equipaje',
        'estambre',
        'este',
        'eternidad',
        'fenix',
        'generosidad',
        'grima',
        'hambre',
        'hielo',
        'hojaldre',
        'lente',
        'linde',
        'mar',
        'margen',
        'nada',
        'nadie',
        'norte',
        'nosotras',
        'nosotros',
        'oeste',
        'panico',
        'pereza',
        'poblacion',
        'policia',
        'pringue',
        'pringue',
        'publico',
        'salud',
        'sed',
        'sur',
        'te',
        'tez',
        'tilde',
        'tizne',
        'tu',
        'tu',
        'viescas',
        'vosotras',
        'vosotros',
        'yo',
    ];

    private static $singularRules = [
        'particular' => [
            'z' => 'ces',
        ],
        'normal' => [
            'es',
            's',
        ],
    ];

    private static $pluralRules = [
        'particular' => [
            'ces' => 'z',
        ],
        'normal' => [
            's' => '/[aeo]$/i',
            'es' => '/[^iu]$/i',
        ],
    ];

    public static function singular($value)
    {
        if (isset(self::$irregular[$value])) {
            return self::$irregular[$value];
        }

        if (in_array($value, self::$invariable) || in_array($value, self::$noPlural)) {
            return $value;
        }

        if ($cut = self::endsWith($value, self::$singularRules['particular'])) {
            return self::cut($value, $cut) . array_search($cut, self::$singularRules['particular']);
        }

        if ($cut = self::endsWith($value, self::$singularRules['normal'])) {
            return self::cut($value, $cut);
        }

        return $value;

    }

    public static function plural($value)
    {
        if ($key = array_search($value, self::$irregular)) {
            return $key;
        }

        if (in_array($value, self::$invariable) || in_array($value, self::$noPlural)) {
            return $value;
        }

        if ($cut = self::endsWith($value, self::$pluralRules['particular'])) {
            return self::cut($value, $cut) . array_search($cut, self::$pluralRules['particular']);
        }

        if ($put = self::endsWith_match($value, self::$pluralRules['normal'])) {
            return $value . $put;
        }

        return $value;

    }

    public static function cut($string, $suffix)
    {
        return preg_replace('/' . $suffix . '*$/', '', $string);
    }

    public static function invariable($value)
    {
        return in_array(strtolower($value), self::$invariable);
    }

    public static function toCamel($value)
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
    }

    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {

            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return $needle;
            }
        }

        return false;
    }

    public static function endsWith_match($string, $needles)
    {
        foreach ((array) $needles as $key => $needle) {
            if (preg_match((string) $needle, $string)) {
                return $key;
            }
        }

        return false;
    }
}
