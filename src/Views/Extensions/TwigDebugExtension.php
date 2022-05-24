<?php

declare(strict_types=1);

namespace App\Views\Extensions {

    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;
    use function extension_loaded;
    use const PHP_SAPI;

    final class TwigDebugExtension extends AbstractExtension
    {
        public function getFunctions(): array
        {
            $isDumpOutputHtmlSafe = extension_loaded('xdebug')
                && (false === ini_get('xdebug.overload_var_dump') || ini_get('xdebug.overload_var_dump'))
                && (false === ini_get('html_errors') || ini_get('html_errors'))
                || 'cli' === PHP_SAPI;

            return [
                new TwigFunction('dump', 'twig_var_dump', ['is_safe' => $isDumpOutputHtmlSafe ? ['html'] : [], 'needs_context' => true, 'needs_environment' => true, 'is_variadic' => true]),
            ];
        }
    }
}


namespace {

    use Twig\Environment;
    use Twig\Template;
    use Twig\TemplateWrapper;

    function twig_var_dump(Environment $env, $context, ...$vars)
    {
        if (!$env->isDebug()) {
            return;
        }

        if (!$vars) {
            $vars = [];
            foreach ($context as $key => $value) {
                if (!$value instanceof Template && !$value instanceof TemplateWrapper) {
                    $vars[$key] = $value;
                }
            }

            dump($vars);
        } else {
            dump(...$vars);
        }
    }
}
